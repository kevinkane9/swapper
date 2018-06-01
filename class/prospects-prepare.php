<?php

namespace Sapper;

class ProspectsFilter {
    const NOT_IN_DB = '1';
    const IN_DB_NOT_OUTREACH = '2';
    const IN_DB_IN_OUTREACH = '3';
    
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

        if (array_key_exists('client_id', $data) && $data['client_id'] > 0) {
            $clientId   = $data['client_id'];
            $downloadId   = $data['download_id'];
            $clientName = Db::fetchColumn(
                'SELECT * FROM `sap_client` WHERE `id` = :client_id',
                ['client_id' => $clientId],
                'name'
            );
        } else {
            $clientId    = null;
            $clientName  = null;
        }
        
        if (!empty($data)) {
            unset($data['client_id']);
            $search_criteria = json_encode($data);
        } else {
            $search_criteria = '';
        }

        // file header
        $file = fopen($file, 'r');

        // identify columns of header row
        $columns     = [];
        $fileColumns = fgetcsv($file);
        
        $tempheaders = [];
        $colheaders = [];
        foreach ($fileColumns as $fileColumn) {
            $tempheaders[] = strtolower(str_replace(' ', '-', trim($fileColumn)));
            $colheaders[] = trim($fileColumn);
        }
        
        $columns = array_flip($tempheaders);

        if (count($columns) != 21) {
            print('Invalid CSV file format . ' . count($columns));
            die;
        }
        
        if (!array_key_exists('zoom-individual-id', $columns)) {
            print('Missing email column');
            die;
        }

        // filter rows
        $rows             = [];
        $rowCount         = 0;
        $notInDB            = [];
        $inDBNotOutreach    = [];
        $inDBInOutreach     = [];

        while ($row = fgetcsv($file)) {
            $rows[] = $row;
        }
        
        $uc=0;
        foreach ($rows as $row) {            
            $rowCount++;
            
            // email
            if (array_key_exists('zoom-individual-id', $columns)) {
                $zoominfo_id = trim($row[$columns['zoom-individual-id']]);
                $zoominfo_company_id = trim($row[$columns['zoom-company-id']]);

                $p_sql  ="SELECT p.* FROM `sap_prospect` p 
                    WHERE p.`zoominfo_id` = :zoominfo_id AND p.`zoominfo_company_id` = :zoominfo_company_id";
                $prospect = Db::fetch(
                    $p_sql,
                    ['zoominfo_id'=>$zoominfo_id,'zoominfo_company_id'=>$zoominfo_company_id]
                );             
                
                $outreach_accounts = Db::fetchAll(
                    'SELECT * FROM `sap_client_account_outreach` WHERE `client_id` = :client_id',
                    ['client_id' => $clientId]
                );  
                
                $outreach_account_ids = [];
                if (!empty($outreach_accounts)) {
                   foreach ($outreach_accounts as $outreach_account) {
                       $outreach_account_ids[] = $outreach_account['id'];
                   } 
                }

                if (count($outreach_account_ids)) {
                    $prospect_outreach = Db::fetch(
                        "SELECT p.email, op.* FROM `sap_prospect` p 
                    LEFT JOIN sap_outreach_prospect op ON p.id = op.prospect_id
                    WHERE p.`zoominfo_id` = :zoominfo_id AND p.`zoominfo_company_id` = :zoominfo_company_id AND op.outreach_id IN (" . implode(',',$outreach_account_ids) . ")",
                        ['zoominfo_id'=>$zoominfo_id,'zoominfo_company_id'=>$zoominfo_company_id]
                    );
                } else {
                    $prospect_outreach = null;
                }
                
                $row['first_name'] = !empty($prospect['first_name']) ? $prospect['first_name'] : '';
                $row['last_name'] = !empty($prospect['last_name']) ? $prospect['last_name'] : '';
                $row['email'] = !empty($prospect['email']) ? $prospect['email'] : '';
                $row['title'] = !empty($prospect['title']) ? $prospect['title'] : '';
                $row['account'] = !empty($prospect['account']) ? $prospect['account'] : '';
                $row['company'] = !empty($prospect['company_id']) ? $prospect['company_id'] : '';
                $row['work_phone'] = !empty($prospect['phone_work']) ? $prospect['phone_work'] : '';
                $row['mobile_phone'] = !empty($prospect['phone_personal']) ? $prospect['phone_personal'] : '';
                $row['website'] = !empty($prospect['website']) ? $prospect['website'] : '';
                $row['address'] = !empty($prospect['address']) ? $prospect['address'] : '';
                $row['city'] = !empty($prospect['city_id']) ? $prospect['city_id'] : '';
                $row['state'] = !empty($prospect['state_id']) ? $prospect['state_id'] : '';
                $row['zip'] = !empty($prospect['zip']) ? $prospect['zip'] : '';
                $row['revenue'] = !empty($prospect['company_revenue']) ? $prospect['company_revenue'] : '';
                $row['employees'] = !empty($prospect['company_employees']) ? $prospect['company_employees'] : '';
                $row['industry'] = !empty($prospect['industry_id']) ? $prospect['industry_id'] : '';
                $source = '';
                if (!empty($prospect['source_id'])) {
                    $source = Db::fetchColumn(
                        'SELECT * FROM `sap_prospect_source` WHERE `id` = :id',
                        ['id' => $prospect['source_id']],
                        'name'
                    );
                }
                
                $row['source'] = !empty($source) ? $source : '';
                $row['sapper_client_Segment'] = !empty($prospect['sapper_client_Segment']) ? $prospect['sapper_client_Segment'] : '';
                
                // Collection 1 : Not In DB
                if (empty($prospect)) {
                    $collection_type = ProspectsFilter::NOT_IN_DB;
                    
                    goto collect;
                }
                
                // Collection 2 : In DB Not In Outreach
                if (!empty($prospect) AND (is_null($prospect_outreach) || empty($prospect_outreach['outreach_id']))) {
                    $collection_type = ProspectsFilter::IN_DB_NOT_OUTREACH;
                    
                    goto collect;
                }
                
                // Collection 3 : In DB In Outreach
                if (!empty($prospect_outreach)) {
                    $collection_type = ProspectsFilter::IN_DB_IN_OUTREACH;
                    
                    goto collect;
                }
            }
            
            collect:
            if ($collection_type == ProspectsFilter::NOT_IN_DB) {
                $notInDB[] = ['row' => $row];
            }
            
            if ($collection_type == ProspectsFilter::IN_DB_NOT_OUTREACH) {
                $inDBNotOutreach[] = ['row' => $row];
            }
            
            if ($collection_type == ProspectsFilter::IN_DB_IN_OUTREACH) {
                $inDBInOutreach[] = ['row' => $row];
            }
        }
        fclose($file);

        // set dir & filenames
        $path = APP_ROOT_PATH . '/upload/' . date('Y-m-d');
        if (!is_dir($path)) {
            mkdir($path);
        }

        $filename = pathinfo($filename, PATHINFO_FILENAME);

        $notInDbSuffix   = ' (Not in DB).csv';
        $inDbNotOutreachSuffix     = ' (In DB Not Outreach).csv';
        $inDbInOutreachSuffix     = ' (In DB In Outreach).csv';
      
        #########
        if (!file_exists($path . '/' . $filename . $notInDbSuffix)) {
            $nidbFile = $filename . $notInDbSuffix;
        } else {
            $i = 1;
            while (file_exists($path . '/' . $filename . " ($i) " . $notInDbSuffix)) {
                $i++;
            }
            $nidbFile = $filename . " ($i) " . $notInDbSuffix;
        }
        
        
        if (!file_exists($path . '/' . $filename . $inDbNotOutreachSuffix)) {
            $idbnorFile = $filename . $inDbNotOutreachSuffix;
        } else {
            $i = 1;
            while (file_exists($path . '/' . $filename . " ($i) " . $inDbNotOutreachSuffix)) {
                $i++;
            }
            $idbnorFile = $filename . " ($i) " . $inDbNotOutreachSuffix;
        }
        
                
        
        if (!file_exists($path . '/' . $filename . $inDbInOutreachSuffix)) {
            $idbiorFile = $filename . $inDbInOutreachSuffix;
        } else {
            $i = 1;
            while (file_exists($path . '/' . $filename . " ($i) " . $inDbInOutreachSuffix)) {
                $i++;
            }
            $idbiorFile = $filename . " ($i) " . $inDbInOutreachSuffix;
        }

        $outputHeadersOthers = [
            'Zoom Individual ID','Zoominfo Company ID',
            'First Name', 'Last Name', 'Email', 'Title', 'Account',
            'Company', 'Work Phone', 'Mobile Phone', 'Website', 'Address',
            'City', 'State', 'Zip', 'Country', 'Revenue','Employees',
            'Company Industry','Source','Sapper Client Segment',            
        ];
        
        $outputHeaders = $colheaders;
        
        // Not In DB output
        $output = fopen($path . '/' . $nidbFile, 'w');
        fputcsv($output, $outputHeaders);

        foreach ($notInDB as $rowData) {
            $row = $rowData['row'];

            fputcsv(
                $output,
                [
                    isset($columns['include'])     ? $row[$columns['include']]   : '',
                    isset($columns['zoom-individual-id'])     ? $row[$columns['zoom-individual-id']]   : '',
                    isset($columns['has-direct-phone-number'])     ? $row[$columns['has-direct-phone-number']]   : '',
                    isset($columns['has-email'])     ? $row[$columns['has-email']]   : '',
                    isset($columns['job-title'])     ? $row[$columns['job-title']]   : '',
                    isset($columns['job-function'])     ? $row[$columns['job-function']]   : '',
                    isset($columns['management-level'])     ? $row[$columns['management-level']]   : '',
                    isset($columns['person-city'])     ? $row[$columns['person-city']]   : '',
                    isset($columns['person-state'])     ? $row[$columns['person-state']]   : '',
                    isset($columns['person-zip'])     ? $row[$columns['person-zip']]   : '',
                    isset($columns['country'])     ? $row[$columns['country']]   : '',
                    isset($columns['zoom-company-id'])     ? $row[$columns['zoom-company-id']]   : '',
                    isset($columns['company-name'])     ? $row[$columns['company-name']]   : '',
                    isset($columns['company-city'])     ? $row[$columns['company-city']]   : '',
                    isset($columns['company-state'])     ? $row[$columns['company-state']]   : '',
                    isset($columns['company-zip/postal-code'])     ? $row[$columns['company-zip/postal-code']]   : '',
                    isset($columns['company-country'])     ? $row[$columns['company-country']]   : '',
                    isset($columns['industry-label'])     ? $row[$columns['industry-label']]   : '',
                    isset($columns['industry-hierarchical-category'])     ? $row[$columns['industry-hierarchical-category']]   : '',
                    isset($columns['secondary-industry-label'])     ? $row[$columns['secondary-industry-label']]   : '',
                    isset($columns['secondary-industry-hierarchical-category'])     ? $row[$columns['secondary-industry-hierarchical-category']]   : '',

                ]
            );
        }
        fclose($output);
        
        // In DB Not Outreach output
        $output = fopen($path . '/' . $idbnorFile, 'w');
        fputcsv($output, $outputHeadersOthers);

        foreach ($inDBNotOutreach as $rowData) {
            $row = $rowData['row'];

            fputcsv(
                $output,
                [
                    isset($columns['zoom-individual-id'])     ? $row[$columns['zoom-individual-id']]   : '',
                    isset($columns['zoom-company-id'])     ? $row[$columns['zoom-company-id']]   : '',
                    isset($row['first_name'])     ? $row['first_name']   : '',
                    isset($row['last_name'])     ? $row['last_name']   : '',
                    isset($row['email'])     ? $row['email']   : '',
                    isset($row['title'])     ? $row['title']   : '',
                    isset($row['account'])     ? $row['account']   : '',
                    isset($columns['company-name'])     ? $row[$columns['company-name']]   : '',
                    isset($row['work_phone'])     ? $row['work_phone']   : '',
                    isset($row['mobile_phone'])     ? $row['mobile_phone']   : '',
                    isset($row['website'])     ? $row['website']   : '',
                    isset($row['address'])     ? $row['address']   : '',
                    isset($columns['person-city'])     ? $row[$columns['person-city']]   : '',
                    isset($columns['person-state'])     ? $row[$columns['person-state']]   : '',
                    isset($columns['company-zip/postal-code'])     ? $row[$columns['company-zip/postal-code']]   : '',
                    isset($columns['company-country'])     ? $row[$columns['company-country']]   : '',
                    isset($row['revenue'])     ? $row['revenue']   : '',
                    isset($row['employees'])     ? $row['employees']   : '',
                    isset($columns['industry-label'])     ? $row[$columns['industry-label']]   : '',
                    isset($row['source'])     ? $row['source']   : '',
                    isset($row['sapper_client_Segment'])     ? $row['sapper_client_Segment']   : '',
                ]
            );
        }
        fclose($output);
        
        // In DB In Outreach output
        $output = fopen($path . '/' . $idbiorFile, 'w');
        fputcsv($output, $outputHeadersOthers);

        foreach ($inDBInOutreach as $rowData) {
            $row = $rowData['row'];

            fputcsv(
                $output,
                [
                    isset($columns['zoom-individual-id'])     ? $row[$columns['zoom-individual-id']]   : '',
                    isset($columns['zoom-company-id'])     ? $row[$columns['zoom-company-id']]   : '',
                    isset($row['first_name'])     ? $row['first_name']   : '',
                    isset($row['last_name'])     ? $row['last_name']   : '',
                    isset($row['email'])     ? $row['email']   : '',
                    isset($row['title'])     ? $row['title']   : '',
                    isset($row['account'])     ? $row['account']   : '',
                    isset($row['company'])     ? $row['company']   : '',
                    isset($row['work_phone'])     ? $row['work_phone']   : '',
                    isset($row['mobile_phone'])     ? $row['mobile_phone']   : '',
                    isset($row['website'])     ? $row['website']   : '',
                    isset($row['address'])     ? $row['address']   : '',
                    isset($columns['person-city'])     ? $row[$columns['person-city']]   : '',
                    isset($columns['person-state'])     ? $row[$columns['person-state']]   : '',
                    isset($columns['company-zip/postal-code'])     ? $row[$columns['company-zip/postal-code']]   : '',
                    isset($columns['company-country'])     ? $row[$columns['company-country']]   : '',
                    isset($row['revenue'])     ? $row['revenue']   : '',
                    isset($row['employees'])     ? $row['employees']   : '',
                    isset($columns['industry-label'])     ? $row[$columns['industry-label']]   : '',
                    isset($row['source'])     ? $row['source']   : '',
                    isset($row['sapper_client_Segment'])     ? $row['sapper_client_Segment']   : '',
                ]
            );
        }
        fclose($output);

        $listRequestId = null;

        try {
            
            Db::query(
                        'UPDATE `sap_download_filtered` 
                            SET
                                `created_on` = :created_on, 
                                `filename` = :filename, 
                                `row_count` = :row_count, 
                                `nidb` = :nidb, 
                                `nidb_count` = :nidb_count,
                                `idbnor` = :idbnor, 
                                `idbnor_count` = :idbnor_count,
                                `idbior` = :idbior, 
                                `idbior_count` = :idbior_count,
                                `filtered` = :filtered, 
                                `filtered_count` = :filtered_count,
                                `purged` = :purged, 
                                `purged_count` = :purged_count, 
                                `saved_to_db` = :saved_to_db, 
                                `uploaded_to_outreach` = :uploaded_to_outreach,
                                `client_id` = :client_id,
                                `client_name` = :client_name,
                                `search_criteria` = :search_criteria 
                            WHERE `id` = :download_id',
                        [
                            'download_id'      => $downloadId,
                            'created_on'           => date('Y-m-d'),
                            'filename'             => $filename,
                            'row_count'            => $rowCount,
                            'nidb'             => $nidbFile,
                            'nidb_count'       => count($notInDB),
                            'idbnor'             => $idbnorFile,
                            'idbnor_count'       => count($inDBNotOutreach),
                            'idbior'             => $idbiorFile,
                            'idbior_count'       => count($inDBInOutreach),
                            'filtered'             => '',
                            'filtered_count'       => 0,
                            'purged'               => '',
                            'purged_count'         => 0,
                            'saved_to_db'          => 0,
                            'uploaded_to_outreach' => 0,
                            'client_id' => $clientId,
                            'client_name' => $clientName,
                            'search_criteria' => $search_criteria,
                        ]
                    );
           
        } catch (\Exception $exc) {
            echo $exc->getTraceAsString();
            echo "\n\n\n";
            echo $exc->getMessage();
        }

        return [
            'row_count'      => $rowCount,
            'download_id'    => $downloadId
        ];
    }
}
