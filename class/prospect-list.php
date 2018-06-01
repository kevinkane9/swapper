<?php

namespace Sapper;
use Sapper\Util;

class ProspectList {

    public static function populateData($request) {
        $data = json_decode($request['data'], true);

        $request['comments'] = Db::fetchAll(
            'SELECT lrc.*, u.`first_name`, u.`last_name`
                   FROM     `sap_list_request_comment` lrc
              LEFT JOIN     `sap_user` u ON lrc.`created_by` = u.`id`
                  WHERE lrc.`list_request_id` = :list_request_id
               ORDER BY lrc.`created_at` DESC',
            ['list_request_id' => $request['id']]
        );

        //sourceId
        if (array_key_exists('sourceId', $data) && !empty($data['sourceId'])) {
            $request['source'] = Db::fetchColumn(
                'SELECT * FROM `sap_prospect_source` WHERE `id` = :id',
                ['id' => $data['sourceId']],
                'name'
            );
        }

        //companyId
        if (array_key_exists('companyId', $data) && !empty($data['companyId'])) {
            $request['company'] = Db::fetchColumn(
                'SELECT * FROM `sap_prospect_company` WHERE `id` = :id',
                ['id' => $data['companyId']],
                'name'
            );
        }

        //industries
        if (array_key_exists('industries', $data) && !empty($data['industries'])) {
            $request['industries'] = [];
            foreach ($data['industries'] as $industryId) {
                if (0 === strpos($industryId, '!')) {
                    $request['industries'][] = substr($industryId, 1);
                } else {
                    $request['industries'][] = Db::fetchColumn(
                        'SELECT * FROM `sap_prospect_industry` WHERE `id` = :id',
                        ['id' => $industryId],
                        'name'
                    );
                }
            }
        }

        //titles
        if (array_key_exists('titles', $data) && !empty($data['titles'])) {
            $request['titles'] = [];
            foreach ($data['titles'] as $titleId) {
                $request['titles'][] = Db::fetchColumn(
                    'SELECT * FROM `sap_group_title` WHERE `id` = :id',
                    ['id' => $titleId],
                    'name'
                );
            }
        }

        //department
        if (array_key_exists('departments', $data) && !empty($data['departments'])) {
            $request['departments'] = [];
            foreach ($data['departments'] as $departmentId) {
                $request['departments'][] = Db::fetchColumn(
                    'SELECT * FROM `sap_department` WHERE `id` = :id',
                    ['id' => $departmentId],
                    'department'
                );
            }
        }

        //countries
        if (array_key_exists('countries', $data) && !empty($data['countries'])) {
            $request['countries'] = $data['countries'];
        }

        //geotarget
        if (array_key_exists('geotarget', $data) && !empty($data['geotarget'])) {
            $request['geotarget'] = $data['geotarget'];
        }

        //radius
        if (array_key_exists('radius', $data) && !empty($data['radius'])) {
            $request['radius'] = $data['radius'];
        }

        //states
        if (array_key_exists('states', $data) && !empty($data['states'])) {
            $request['states'] = $data['states'];
        }

        $request['num_comments'] = Db::fetchColumn(
            'SELECT COUNT(*) AS `count` FROM `sap_list_request_comment` WHERE `list_request_id` = :list_request_id',
            ['list_request_id' => $request['id']],
            'count'
        );

        return $request;
    }

    public static function process($file, $filename, $data = [], $listCertified = false, $persistProspects = false, $geoEncode = true) {
        set_time_limit(0);

        // load models
        $states  = Model::get('states');
        $domains = Model::get('domains');

        // titles
        $titles       = [];
        $titlesToKeep = [];

        // title
        $titlesDb = Db::fetchAll(
            'SELECT t.*, g.`sort_order` AS `group_sort_order`
                   FROM `sap_group_title` t
              LEFT JOIN `sap_group` g ON t.`group_id` = g.`id`'
        );

        foreach ($titlesDb as $title) {
            $groupSortOrder = $title['group_sort_order'] * 10000;
            $titles[$title['id']] = ['sortOrder' => $title['sort_order'] + $groupSortOrder, 'title' => $title['name'], 'variations' => [], 'negatives' => []];

            if (array_key_exists('titles', $data) && in_array($title['id'], $data['titles'])) {
                $titlesToKeep[$title['id']] = ['sortOrder' => $title['sort_order'] + $groupSortOrder, 'title' => $title['name'], 'variations' => [], 'negatives' => []];
            }

            // variations
            $variations = Db::fetchAll(
                'SELECT * FROM `sap_group_title_variation` WHERE `group_title_id` = :group_title_id',
                ['group_title_id' => $title['id']]
            );

            foreach ($variations as $variation) {
                $titles[$title['id']]['variations'][] = $variation['name'];

                if (array_key_exists('titles', $data) && in_array($title['id'], $data['titles'])) {
                    $titlesToKeep[$title['id']]['variations'][] = $variation['name'];
                }
            }

            // negatives
            $negatives = Db::fetchAll(
                'SELECT * FROM `sap_group_title_negative` WHERE `group_title_id` = :group_title_id',
                ['group_title_id' => $title['id']]
            );

            foreach ($negatives as $negative) {
                $titles[$title['id']]['negatives'][] = $negative['keyword'];

                if (array_key_exists('titles', $data) && in_array($title['id'], $data['titles'])) {
                    $titlesToKeep[$title['id']]['negatives'][] = $negative['keyword'];
                }
            }
        }

        // departments + keywords
        $keywords         = [];
        $keywordsNegative = [];
        if (array_key_exists('departments', $data)) {
            foreach ($data['departments'] as $departmentId) {
                $keywords[] = Db::fetchColumn(
                    'SELECT * FROM `sap_department_keyword` WHERE `department_id` = :department_id',
                    ['department_id' => $departmentId],
                    'keyword'
                );
            }

            // negative department keywords
            $negativeKeywords = Db::fetchAll(
                sprintf(
                    'SELECT * FROM `sap_department_keyword` WHERE `department_id` NOT IN (%s)',
                    implode(',', $data['departments'])
                )
            );
            foreach ($negativeKeywords as $negativeKeyword) {
                $keywordsNegative[] = $negativeKeyword['keyword'];
            }
        }

        // states
        $statesToKeep = [];
        if (array_key_exists('states', $data)) {
            $statesToKeep = $data['states'];
        }

        if (array_key_exists('client_id', $data) && $data['client_id'] > 0) {
            $clientId   = $data['client_id'];
            $clientName = Db::fetchColumn(
                'SELECT * FROM `sap_client` WHERE `id` = :client_id',
                ['client_id' => $clientId],
                'name'
            );
        } else {
            $clientId    = null;
            $clientName  = null;
        }

        // prospects
        $prospects = 0;
        if (array_key_exists('prospects', $data) && $data['prospects'] > 0) {
            $prospects = $data['prospects'];
        }

        // file header
        $file = fopen($file, 'r');

        // identify columns of header row
        $columns     = ['title' => []];
        $fileColumns = fgetcsv($file);

        for ($i = 0; $i < count($fileColumns); $i++) {
            if (false !== strpos(strtolower($fileColumns[$i]), 'email')) {
                $columns['email'] = $i;
            } elseif (false !== strpos(strtolower($fileColumns[$i]), 'title')) {
                $columns['title'][] = $i;
            } elseif (false !== strpos(strtolower($fileColumns[$i]), 'industry')) {
                $columns['industry'] = $i;
            } elseif (false !== strpos(strtolower($fileColumns[$i]), 'company')) {
                $columns['company'] = $i;
            } elseif (false !== strpos(strtolower($fileColumns[$i]), 'state')) {
                $columns['state'] = $i;
            } elseif (false !== strpos(strtolower($fileColumns[$i]), 'first')) {
                $columns['first name'] = $i;
            } elseif (false !== strpos(strtolower($fileColumns[$i]), 'last')) {
                $columns['last name'] = $i;
            } elseif (false !== strpos(strtolower($fileColumns[$i]), 'account')) {
                $columns['account'] = $i;
            } elseif (false !== strpos(strtolower($fileColumns[$i]), 'work phone')) {
                $columns['work phone'] = $i;
            } elseif (false !== strpos(strtolower($fileColumns[$i]), 'mobile phone')) {
                $columns['mobile phone'] = $i;
            } elseif (false !== strpos(strtolower($fileColumns[$i]), 'website')) {
                $columns['website'] = $i;
            } elseif (false !== strpos(strtolower($fileColumns[$i]), 'address')) {
                $columns['address'] = $i;
            } elseif (false !== strpos(strtolower($fileColumns[$i]), 'city')) {
                $columns['city'] = $i;
            } elseif (false !== strpos(strtolower($fileColumns[$i]), 'zip')) {
                $columns['zip'] = $i;
            } elseif (false !== strpos(strtolower($fileColumns[$i]), 'country')) {
                $columns['country'] = $i;
            } elseif (false !== strpos(strtolower($fileColumns[$i]), 'revenue')) {
                $columns['revenue'] = $i;
            } elseif (false !== strpos(strtolower($fileColumns[$i]), 'employees')) {
                $columns['employees'] = $i;
            } elseif (false !== strpos(strtolower($fileColumns[$i]), 'source')) {
                $columns['source'] = $i;
            }

            if (!isset($columns['work phone']) && !isset($columns['mobile phone'])) {
                if (false !== strpos(strtolower($fileColumns[$i]), 'phone')) {
                    $columns['work phone'] = $i;
                }
            }
        }

        if (!array_key_exists('email', $columns)) {
            throw new \Exception('Missing email column');
        }

        // filter rows
        $rows             = [];
        $listCertifiedBad = [];
        $rowCount         = 0;
        $rowsToKeep       = [];
        $rowsFiltered     = [];

        if (true == $listCertified) {
            $pathEnd = date('Y-m-d') . '/' . str_replace([' ', '.'], '', microtime());
            $path    = APP_ROOT_PATH . '/upload/' . $pathEnd;

            if (!is_dir(APP_ROOT_PATH . '/upload/' . date('Y-m-d'))) {
                mkdir(APP_ROOT_PATH . '/upload/' . date('Y-m-d'));
            }

            if (!is_dir($path)) {
                mkdir($path);
            }

            $listCertifiedFile  = $path . '/' . time() . '.csv';
            $listCertifiedInput = fopen($listCertifiedFile, 'w');

            fputcsv(
                $listCertifiedInput,
                    [
                        'subscriber_email',
                        'subscriber_fname',
                        'subscriber_lname',
                        'subscriber_phone',
                        'subscriber_mobile',
                        'subscriber_addr1',
                        'subscriber_city',
                        'subscriber_state',
                        'subscriber_zip',
                        'subscriber_country'
                    ]
            );
        }

        while ($row = fgetcsv($file)) {
            $rows[] = $row;

            if (true == $listCertified) {
                fputcsv(
                    $listCertifiedInput,
                    [
                        !empty($row[$columns['email']])        ? $row[$columns['email']]        : '',
                        !empty($row[$columns['first name']])   ? $row[$columns['first name']]   : '',
                        !empty($row[$columns['last name']])    ? $row[$columns['last name']]    : '',
                        !empty($row[$columns['work phone']])   ? $row[$columns['work phone']]   : '',
                        !empty($row[$columns['mobile phone']]) ? $row[$columns['mobile phone']] : '',
                        !empty($row[$columns['address']])      ? $row[$columns['address']]      : '',
                        !empty($row[$columns['city']])         ? $row[$columns['city']]         : '',
                        !empty($row[$columns['state']])        ? $row[$columns['state']]        : '',
                        !empty($row[$columns['zip']])          ? $row[$columns['zip']]          : '',
                        !empty($row[$columns['country']])      ? $row[$columns['country']]      : '',
                    ]
                );
            }
        }

        if (true == $listCertified) {
            fclose($listCertifiedInput);

            $iCount=1;

            operations:

            try {
                    $operations = new \Operations(
                        \Operations::http(),
                        'sapper_suite',
                        '76a9d38c-7a0c-4cab-8fea-c7825b8c03a1',
                        8080,
                        'api.mydatamanage.com',
                        10,
                        'http'
                    );
        
                    $operations->init();
            } catch (\Exception $e) {
                if ($iCount <= 5) {
                    $iCount++;
                    sleep(10);

                    goto operations;
                } else {
                    throw $e;
                }
            }

            // upload
            list($err, $message) = $operations->upload($listCertifiedFile, true);
            ##Util::addLog("Process Request Log [upload-normalized-csv-filtered] POST: Client Id $client_id Download Id $download_id List Request Id $list_request_id: Siftlogic message - $message Error $err");
            if (!$err){
                throw new \RuntimeException($message);
            }

            // poll + download
            list($err, $message, $zip) = $operations->download($path, true);
            
            ##Util::addLog("Process Request Log [upload-normalized-csv-filtered] POST: Client Id $client_id Download Id $download_id List Request Id $list_request_id: Siftlogic message - $message Error $err");
            
            if (!$err){
                throw new \RuntimeException($message);
            }

            $archive = new \ZipArchive;
            if ($archive->open($path . '/' . $zip) === TRUE) {
                $archive->extractTo($path);
                $archive->close();
            } else {
                ##Util::addLog("Process Request Log [upload-normalized-csv-filtered] POST: Client Id $client_id Download Id $download_id List Request Id $list_request_id: Siftlogic message - Unable to unzip listCertified results");
                throw new \Exception('Unable to unzip listCertified results');
            }

            if (!file_exists($path . '/results.csv')) {
                ##Util::addLog("Process Request Log [upload-normalized-csv-filtered] POST: Client Id $client_id Download Id $download_id List Request Id $list_request_id: Siftlogic message - ListCertified results empty");
                throw new \Exception('listCertified results empty');
            }

            $results = fopen($path . '/results.csv', 'r');
            fgetcsv($results);

            while ($row = fgetcsv($results)) {
                if ('bad' == $row[1] || $row[3] < 0) {
                    $listCertifiedBad[] = strtolower($row[0]);
                }
            }
        }

        foreach ($rows as $row) {
            $rowCount++;
            $keepRow   = true;
            $sortOrder = 10000000;
            $company   = '';

            $row['purgedReason'] = '';

            // company
            if (array_key_exists('company', $columns)) {
                $company = $row[$columns['company']];
            }

            // email
            if (array_key_exists('email', $columns)) {
                $email = strtolower($row[$columns['email']]);

                // country
                foreach ($domains as $extension => $domain) {
                    if (strpos($email, strtolower($extension)) == strlen($email) - strlen($extension) &&
                        !in_array($extension, $data['countries'])
                    ) {
                        $keepRow = false;
                        $row['purgedReason'] = 'Email domain country';
                        $row['hardPurge']    = true;
                        goto placeIntoBucket;
                    }
                }

                // suppression list
                if (null !== $clientId) {
                    $emailParts = explode('@', $email);
                    if (isset($emailParts[1])) {
                        $select = Db::query(
                            'SELECT * FROM `sap_client_dne` WHERE `client_id` = :client_id AND `domain` = :domain',
                            [
                                'client_id' => $data['client_id'],
                                'domain'    => '@' . $emailParts[1]
                            ]
                        );

                        if ($select->rowCount() > 0) {
                            $keepRow = false;
                            $row['purgedReason'] = 'Client DNE';
                            $row['hardPurge']    = false;
                            goto placeIntoBucket;
                        }
                    }
                }

                if (in_array($email, $listCertifiedBad)) {
                    $keepRow = false;
                    $row['purgedReason'] = 'List Certified marked as bad';
                    $row['hardPurge']    = true;
                    goto placeIntoBucket;
                }
            }

            // titles
            if (count($columns['title']) > 0) {

                // set sort order
                foreach ($columns['title'] as $titleColumnIndex) {
                    foreach ($titles as $titleData) {
                        $titleMatches = false;

                        // test title
                        if (false !== strpos(strtolower($row[$titleColumnIndex]), strtolower($titleData['title']))) {
                            $titleMatches = true;
                        }

                        // test variations
                        foreach ($titleData['variations'] as $variation) {
                            if (false !== strpos(strtolower($row[$titleColumnIndex]), strtolower($variation))) {
                                $titleMatches = true;
                            }
                        }

                        // test negatives
                        if (true == $titleMatches) {
                            foreach ($titleData['negatives'] as $negative) {
                                if (false !== strpos(strtolower($row[$titleColumnIndex]), strtolower($negative))) {
                                    $titleMatches = false;
                                }
                            }
                        }

                        if (true == $titleMatches) {
                            $sortOrder = $titleData['sortOrder'];
                            break 2;
                        }
                    }
                }
                
                // filter by title
                if (count($titlesToKeep) > 0) {
                    $titleMatches = false;
                    foreach ($columns['title'] as $titleColumnIndex) {
                        foreach ($titlesToKeep as $titleData) {

                            // test title
                            if (false !== strpos(strtolower($row[$titleColumnIndex]), strtolower($titleData['title']))) {
                                $titleMatches = true;
                            }

                            // test variations
                            if (false == $titleMatches) {
                                foreach ($titleData['variations'] as $variation) {
                                    if (false !== strpos(strtolower($row[$titleColumnIndex]), strtolower($variation))) {
                                        $titleMatches = true;
                                    }
                                }
                            }

                            // test negatives
                            if (true == $titleMatches) {
                                foreach ($titleData['negatives'] as $negative) {
                                    if (false !== strpos(strtolower($row[$titleColumnIndex]), strtolower($negative))) {
                                        $titleMatches = false;
                                    }
                                }
                            }

                            if (true == $titleMatches) {
                                break 2;
                            }
                        }
                    }
                    if (false == $titleMatches) {
                        $keepRow = false;
                        $row['purgedReason'] = 'Prospect title';
                        $row['hardPurge']    = false;
                        goto placeIntoBucket;
                    }
                }

                // filter by department + keyword
                if (count($keywords) > 0) {
                    $keywordMatches = false;
                    foreach ($columns['title'] as $titleColumnIndex) {
                        foreach ($keywords as $keyword) {
                            if (false !== strpos(strtolower($row[$titleColumnIndex]), strtolower($keyword))) {
                                $keywordMatches = true;
                                break 2;
                            }
                        }
                        foreach ($keywords as $keyword) {
                            $positiveKeywordPosition = strpos(strtolower($row[$titleColumnIndex]), strtolower($keyword));

                            if (false !== $positiveKeywordPosition) {

                                $keywordMatches = true;

                                // test against negative keywords
                                foreach ($keywordsNegative as $keywordNegative) {
                                    $negativeKeywordPosition = strpos(strtolower($row[$titleColumnIndex]), strtolower($keywordNegative));
                                    if (false !== $negativeKeywordPosition) {

                                        if ($negativeKeywordPosition < $positiveKeywordPosition) {
                                            $keywordMatches = false;
                                        }
                                    }
                                }

                                if (true == $keywordMatches) {
                                    break 2;
                                }
                            }
                        }
                    }
                    if (false == $keywordMatches) {
                        $keepRow = false;
                        $row['purgedReason'] = 'Prospect department';
                        $row['hardPurge']    = false;
                        goto placeIntoBucket;
                    }
                }
            }

            // states
            if (array_key_exists('state', $columns)) {

                $stateCode = array_search(trim($row[$columns['state']]), $states);
                if (false !== $stateCode) {
                    $row[$columns['state']]  = $stateCode;
                } else {
                    if (!array_key_exists(trim($row[$columns['state']]), $states)) {
                        $row[$columns['state']]  = '';
                    } else {
                        $row[$columns['state']]  = trim($row[$columns['state']]);
                    }
                }

                if (count($statesToKeep) > 0 && !in_array($row[$columns['state']], $statesToKeep)) {
                    $keepRow = false;
                    $row['purgedReason'] = 'Prospect state';
                    $row['hardPurge']    = false;
                    goto placeIntoBucket;
                }
            }
            
            placeIntoBucket:
            if (true == $keepRow) {
                $rowsToKeep[]   = ['row' => serialize($row), 'sortOrder' => $sortOrder, 'company' => $company];
            } else {
                $rowsFiltered[] = ['row' => serialize($row), 'sortOrder' => $sortOrder, 'company' => $company];
            }
        }
        fclose($file);

        // sort rows to keep
        $sortOrderArr = [];

        foreach ($rowsToKeep as $key => $row) {
            $sortOrderArr[$key] = $row['sortOrder'];
        }

        array_multisort($sortOrderArr, SORT_ASC, SORT_NUMERIC, $rowsToKeep);

        // unpack rows
        foreach ($rowsToKeep as $i => $rowToKeep) {
            $rowsToKeep[$i]['row'] = unserialize($rowToKeep['row']);
        }
        foreach ($rowsFiltered as $i => $rowFiltered) {
            $rowsFiltered[$i]['row'] = unserialize($rowFiltered['row']);
        }

        // # of prospects
        if ($prospects > 0 && 'total' == $data['prospectScope']) {
            $newRowsToKeep = [];
            $i             = 1;

            foreach ($rowsToKeep as $row) {
                if ($i <= $prospects) {
                    $newRowsToKeep[] = $row;
                } else {
                    $row['row']['purgedReason'] = 'Prospect limit reached';
                    $row['row']['hardPurge']    = false;
                    $rowsFiltered[]             = $row;
                }
                $i++;
            }
            $rowsToKeep = $newRowsToKeep;
        }

        // geo target rows
        if (array_key_exists('city', $columns) && array_key_exists('state', $columns)) {
            $locations = [];
            foreach ($rowsToKeep as $i => $row) {
                $rowData     = $row['row'];
                $locations[] = [
                    'index' => $i,
                    'city'  => $rowData[$columns['city']],
                    'state' => $rowData[$columns['state']],
                ];

                if ((100 == count($locations) || count($rowsToKeep) == $i+1) && 1 == Settings::get('geo-encoding') && $geoEncode) {
                    $geocodes = \Sapper\Api\Geocode::convert($locations);
                    
                    if (is_array($geocodes)) {
                        foreach ($geocodes as $geocode) {
                            if (array_key_exists('geolocated', $geocode)) {
                                $rowsToKeep[$geocode['index']]['geolocated'] = array_key_exists('geolocated', $geocode) ? $geocode['geolocated'] : false;
                                $rowsToKeep[$geocode['index']]['lat']        = array_key_exists('lat', $geocode) ? $geocode['lat'] : null;
                                $rowsToKeep[$geocode['index']]['lng']        = array_key_exists('lng', $geocode) ? $geocode['lng'] : null;
                            } else {
                                $rowsToKeep[$geocode['index']]['geolocated'] = false;
                                $rowsToKeep[$geocode['index']]['lat']        = null;
                                $rowsToKeep[$geocode['index']]['lng']        = null;
                            }
                        }
                    }

                    $locations = [];
                }
            }
            $locations = [];
            
            foreach ($rowsFiltered as $i => $row) {
                $rowData     = $row['row'];
                $locations[] = [
                    'index' => $i,
                    'city'  => $rowData[$columns['city']],
                    'state' => $rowData[$columns['state']],
                ];

                if ((100 == count($locations) || count($rowsFiltered) == $i+1) && 1 == Settings::get('geo-encoding') && $geoEncode) {
                    $geocodes = \Sapper\Api\Geocode::convert($locations);
                    
                    if (is_array($geocodes)) {
                        foreach ($geocodes as $geocode) {
                            if (array_key_exists('geolocated', $geocode)) {
                                $rowsFiltered[$geocode['index']]['geolocated'] = array_key_exists('geolocated', $geocode) ? $geocode['geolocated'] : false;
                                $rowsFiltered[$geocode['index']]['lat']        = array_key_exists('lat', $geocode) ? $geocode['lat'] : null;
                                $rowsFiltered[$geocode['index']]['lng']        = array_key_exists('lng', $geocode) ? $geocode['lng'] : null;
                            }
                        }
                    }
                    $locations = [];
                }
            }
        } else {
            foreach ($rowsToKeep as $i => $row) {
                $rowsToKeep[$i]['geolocated'] = false;
                $rowsToKeep[$i]['lat']        = null;
                $rowsToKeep[$i]['lng']        = null;
            }
            foreach ($rowsFiltered as $i => $row) {
                $rowsFiltered[$i]['geolocated'] = false;
                $rowsFiltered[$i]['lat']        = null;
                $rowsFiltered[$i]['lng']        = null;
            }
        }

        function distance($lat1, $lng1, $lat2, $lng2) {
            $lat1 = deg2rad($lat1);
            $lng1 = deg2rad($lng1);
            $lat2 = deg2rad($lat2);
            $lng2 = deg2rad($lng2);

            $distance = acos(sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($lng1 - $lng2));
    
            return 3959 * $distance;
        }

        // filter by geotaret
        if (!empty($data['geotarget']) &&  1 == Settings::get('geo-encoding') && $geoEncode) {
            $radius = !empty($data['radius']) ? $data['radius'] : 50;

            $geocode = \Sapper\Api\Geocode::convertOne($data['geotarget']);

            if (true == $geocode['geolocated']) {
                foreach ($rowsToKeep as $i => $rowToKeep) {
                    if (false == $rowToKeep['geolocated']) {
                        unset($rowsToKeep[$i]);
                        $rowToKeep['row']['purgedReason'] = 'Unable to geolocate';
                        $rowToKeep['row']['hardPurge']    = false;
                        $rowsFiltered[]                   = $rowToKeep;
                    } else {
                        $miles = distance($geocode['lat'], $geocode['lng'], $rowToKeep['lat'], $rowToKeep['lng']);

                        if ($miles > $radius) {
                            unset($rowsToKeep[$i]);
                            $rowToKeep['row']['purgedReason'] = 'Location outside geotarget radius';
                            $rowToKeep['row']['hardPurge']    = false;
                            $rowsFiltered[]                   = $rowToKeep;
                        }
                    }
                }
            }
        }

        // group by company
        $company = [];
        foreach ($rowsToKeep as $i => $row) {
            if (!array_key_exists($row['company'], $company)) {
                $company[$row['company']] = [];
            }

            if ($prospects > 0 && 'perCompany' == $data['prospectScope'] && '-' !== $row['company'] && $prospects == count($company[$row['company']])) {
                unset($rowsToKeep[$i]);
                $row['row']['purgedReason'] = 'Prospect limit reached';
                $row['row']['hardPurge']    = false;
                $rowsFiltered[]             = $row;
            } else {
                $company[$row['company']][] = $row;
            }
        }

        ksort($company, SORT_STRING);

        // set dir & filenames
        $path = APP_ROOT_PATH . '/upload/' . date('Y-m-d');
        if (!is_dir($path)) {
            mkdir($path);
        }

        $filename         = pathinfo($filename, PATHINFO_FILENAME);
        $filteredSuffix   = ' (Filtered).csv';
        $purgedSuffix     = ' (Purged).csv';

        if (!file_exists($path . '/' . $filename . $filteredSuffix)) {
            $filteredFile = $filename . $filteredSuffix;
        } else {
            $i = 1;
            while (file_exists($path . '/' . $filename . " ($i) " . $filteredSuffix)) {
                $i++;
            }
            $filteredFile = $filename . " ($i) " . $filteredSuffix;
        }

        if (!file_exists($path . '/' . $filename . $purgedSuffix)) {
            $purgedFile = $filename . $purgedSuffix;
        } else {
            $i = 1;
            while (file_exists($path . '/' . $filename . " ($i) " . $purgedSuffix)) {
                $i++;
            }
            $purgedFile = $filename . " ($i) " . $purgedSuffix;
        }

        $outputHeaders = [
            'First Name', 'Last Name', 'Email', 'Title', 'Account',
            'Company', 'Work Phone', 'Mobile Phone','Website',
            'Address', 'City', 'State', 'Zip', 'Country', 'Revenue',
            'Employees', 'Company Industry', 'Source', 'Sapper Client Segment'
        ];

        // filtered output
        $output = fopen($path . '/' . $filteredFile, 'w');
        fputcsv($output, $outputHeaders);

        foreach ($company as $companyRows) {
            foreach ($companyRows as $rowData) {
                $row = $rowData['row'];

                fputcsv(
                    $output,
                    [
                        isset($columns['first name'])     ? $row[$columns['first name']]   : '',
                        isset($columns['last name'])      ? $row[$columns['last name']]    : '',
                        isset($columns['email'])          ? $row[$columns['email']]        : '',
                        isset($columns['title'][0])       ? $row[$columns['title'][0]]     : '',
                        isset($columns['account'])        ? $row[$columns['account']]      : '',
                        isset($columns['company'])        ? $row[$columns['company']]      : '',
                        isset($columns['work phone'])     ? $row[$columns['work phone']]   : '',
                        isset($columns['mobile phone'])   ? $row[$columns['mobile phone']] : '',
                        isset($columns['website'])        ? $row[$columns['website']]      : '',
                        isset($columns['address'])        ? $row[$columns['address']]      : '',
                        isset($columns['city'])           ? $row[$columns['city']]         : '',
                        isset($columns['state'])          ? $row[$columns['state']]        : '',
                        isset($columns['zip'])            ? $row[$columns['zip']]          : '',
                        isset($columns['country'])        ? $row[$columns['country']]      : '',
                        isset($columns['revenue'])        ? $row[$columns['revenue']]      : '',
                        isset($columns['employees'])      ? $row[$columns['employees']]    : '',
                        isset($columns['industry'])       ? $row[$columns['industry']]     : '',
                        isset($columns['source'])         ? $row[$columns['source']]       : '',
                        $clientName
                    ]
                );
            }
        }
        fclose($output);

        // purged output
        $outputHeaders[] = 'Purged Reason';

        $output = fopen($path . '/' . $purgedFile, 'w');
        fputcsv($output, $outputHeaders);

        foreach ($rowsFiltered as $rowData) {
            $row = $rowData['row'];

            fputcsv(
                $output,
                [
                    isset($columns['first name'])     ? $row[$columns['first name']]   : '',
                    isset($columns['last name'])      ? $row[$columns['last name']]    : '',
                    isset($columns['email'])          ? $row[$columns['email']]        : '',
                    isset($columns['title'][0])       ? $row[$columns['title'][0]]     : '',
                    isset($columns['account'])        ? $row[$columns['account']]      : '',
                    isset($columns['company'])        ? $row[$columns['company']]      : '',
                    isset($columns['work phone'])     ? $row[$columns['work phone']]   : '',
                    isset($columns['mobile phone'])   ? $row[$columns['mobile phone']] : '',
                    isset($columns['website'])        ? $row[$columns['website']]      : '',
                    isset($columns['address'])        ? $row[$columns['address']]      : '',
                    isset($columns['city'])           ? $row[$columns['city']]         : '',
                    isset($columns['state'])          ? $row[$columns['state']]        : '',
                    isset($columns['zip'])            ? $row[$columns['zip']]          : '',
                    isset($columns['country'])        ? $row[$columns['country']]      : '',
                    isset($columns['revenue'])        ? $row[$columns['revenue']]      : '',
                    isset($columns['employees'])      ? $row[$columns['employees']]    : '',
                    isset($columns['industry'])       ? $row[$columns['industry']]     : '',
                    isset($columns['source'])         ? $row[$columns['source']]       : '',
                    $clientName,
                    $row['purgedReason']
                ]
            );
        }
        fclose($output);

        $listRequestId = array_key_exists('list_request_id', $data) ? $data['list_request_id'] : null;

        try {
            // if the user deleted the list request card before the background job completed,
            // this will throw an exception, which we'll suppress and end this job
            $id = Db::insert(
                'INSERT INTO `sap_download`
                    (`list_request_id`, `created_on`, `filename`, `row_count`, `filtered`, `filtered_count`,
                     `purged`, `purged_count`, `saved_to_db`, `uploaded_to_outreach`)
              VALUES (:list_request_id, :created_on, :filename, :row_count, :filtered, :filtered_count,
                      :purged, :purged_count, :saved_to_db, :uploaded_to_outreach)',
                [
                    'list_request_id'      => $listRequestId,
                    'created_on'           => date('Y-m-d'),
                    'filename'             => $filename,
                    'row_count'            => $rowCount,
                    'filtered'             => $filteredFile,
                    'filtered_count'       => count($rowsToKeep),
                    'purged'               => $purgedFile,
                    'purged_count'         => count($rowsFiltered),
                    'saved_to_db'          => $persistProspects ? 1 : 0,
                    'uploaded_to_outreach' => $persistProspects ? 1 : 0
                ]
            );
        } catch (\Exception $e) {
            if (false !== strpos($e->getMessage(), '1452 Cannot add or update a child row')) {

                $jobs = Db::fetchAll('SELECT * FROM `sap_background_job` WHERE `status` = "processing"');

                foreach ($jobs as $job) {
                    $data = json_decode($job['data'], true);

                    if ($data['list_request_id'] == $listRequestId && !empty($data['list_request_id'])) {
                        Db::query(
                            'UPDATE `sap_background_job` SET `status` = "deleted" WHERE `id` = :id',
                            ['id' => $job['id']]
                        );
                    }
                }
                exit;
            } else {
                throw $e;
            }
        }


        $prospectIds = [];
        if (true == $persistProspects) {

            function getProspectId($row, $columns) {
                $prospectId = Db::fetchColumn(
                    'SELECT * FROM `sap_prospect` WHERE `email` = :email',
                    ['email' => $row[$columns['email']]],
                    'id'
                );

                if ($prospectId > 0) {
                    return $prospectId;
                } else {
                    $cols = ['email' => trim($row[$columns['email']])];

                    if (isset($columns['first name']) && !empty($row[$columns['first name']])) {
                        $cols['first_name'] = trim($row[$columns['first name']]);
                    }

                    if (isset($columns['last name']) && !empty($row[$columns['last name']])) {
                        $cols['last_name'] = trim($row[$columns['last name']]);
                    }

                    if (isset($columns['title'][0]) && !empty($row[$columns['title'][0]])) {
                        $cols['title'] = trim($row[$columns['title'][0]]);
                    }

                    if (isset($columns['company']) && !empty($row[$columns['company']])) {
                        $cols['company_id'] = Util::prospectAttributeId('prospect_company', $row[$columns['company']]);
                    }

                    if (isset($columns['work phone']) && !empty($row[$columns['work phone']])) {
                        $cols['phone_work'] = trim($row[$columns['work phone']]);
                    }

                    if (isset($columns['mobile phone']) && !empty($row[$columns['mobile phone']])) {
                        $cols['phone_personal'] = trim($row[$columns['mobile phone']]);
                    }

                    if (isset($columns['address']) && !empty($row[$columns['address']])) {
                        $cols['address'] = trim($row[$columns['address']]);
                    }

                    if (isset($columns['city']) && !empty($row[$columns['city']])) {
                        $cols['city_id'] = Util::prospectAttributeId('prospect_city', $row[$columns['city']]);
                    }

                    if (isset($columns['state']) && !empty($row[$columns['state']])) {
                        $states  = Model::get('states');
                        $stateCode        = array_search(trim($row[$columns['state']]), $states);
                        $cols['state_id'] = Util::prospectAttributeId('prospect_state', $stateCode);
                    }

                    if (isset($columns['zip']) && !empty($row[$columns['zip']])) {
                        $cols['zip'] = trim((string) $row[$columns['zip']]);
                    }

                    if (isset($columns['country']) && !empty($row[$columns['country']])) {
                        $cols['country_id'] = Util::prospectAttributeId('prospect_country', $row[$columns['country']]);
                    }

                    if (!empty($row['lat'])) {
                        $cols['lat'] = trim($row['lat']);
                    }

                    if (!empty($row['lng'])) {
                        $cols['lng'] = trim($row[$columns['lng']]);
                    }

                    if (isset($columns['revenue']) && !empty($row[$columns['revenue']])) {
                        $cols['company_revenue'] = trim($row[$columns['revenue']]);
                    }

                    if (isset($columns['employees']) && !empty($row[$columns['employees']])) {
                        $cols['company_employees'] = trim($row[$columns['employees']]);
                    }

                    if (isset($columns['industry']) && !empty($row[$columns['industry']])) {
                        $cols['industry_id'] = Util::prospectAttributeId('prospect_industry', $row[$columns['industry']]);
                    }

                    if (isset($columns['source']) && !empty($row[$columns['source']])) {
                        $cols['source_id'] = Util::prospectAttributeId('prospect_source', $row[$columns['source']]);
                    }

                    $query = 'INSERT INTO `sap_prospect` (';

                    foreach ($cols as $key => $val) {
                        $query .= '`' . $key . '`,';
                    }

                    $query = substr($query, 0, -1) . ') VALUES (';

                    foreach ($cols as $key => $val) {
                        $query .= ':' . $key . ',';
                    }

                    $query = substr($query, 0, -1) . ')';

                    return Db::insert($query, $cols);
                }
            }

            foreach ($rowsToKeep as $rowData) {
                if (!array_key_exists('hardPurge', $rowData['row']) || false == $rowData['row']['hardPurge']) {
                    $prospectIds[getProspectId($rowData['row'], $columns)] = true;
                }
            }

            foreach ($rowsFiltered as $rowData) {
                if (!array_key_exists('hardPurge', $rowData['row']) || false == $rowData['row']['hardPurge']) {
                    $prospectIds[getProspectId($rowData['row'], $columns)] = false;
                }
            }
        }

        return [
            'row_count'      => $rowCount,
            'filtered_count' => count($rowsToKeep),
            'purged_count'   => count($rowsFiltered),
            'download_id'    => $id,
            'prospect_ids'   => $prospectIds
        ];
    }
}