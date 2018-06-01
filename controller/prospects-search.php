<?php

use Sapper\Db,
    Sapper\User,
    Sapper\Route;

// permissions
if (!User::can('search-prospects')) {
    sapperView('error', ['title' => 'Oops!', 'message' => 'You do not have permission to access this feature.']);
}
$action = Route::uriParam('action');

if (false !== ($action = Route::uriParam('action')) && 'list-request' !== $action) {
    switch ($action) {
        case 'get-client-profiles':
            $clientId = Db::fetchColumn(
                'SELECT `client_id` FROM `sap_client_account_outreach` WHERE `id` = :id',
                ['id' => $_POST['outreachAccountId']],
                'client_id'
            );
            
            $searchProfiles = Db::fetchAll(
                'SELECT * FROM `sap_client_profile` WHERE `client_id` = :client_id',
                ['client_id' => $clientId]
            );

            jsonSuccess($searchProfiles);
            break;

        case 'find-source':
            $sources = Db::fetchAll(
                'SELECT `id`, `name` AS `text`
                   FROM `sap_prospect_source`
                  WHERE `name` LIKE :term',
                ['term' => '%' . $_POST['term'] . '%']
            );
            jsonSuccess($sources);
            break;

        case 'find-company':
            $sources = Db::fetchAll(
                'SELECT `id`, `name` AS `text`
                   FROM `sap_prospect_company`
                  WHERE `name` LIKE :term',
                ['term' => '%' . $_POST['term'] . '%']
            );
            jsonSuccess($sources);
            break;

        case 'find-industry':
            $sources = Db::fetchAll(
                'SELECT `id`, `name` AS `text`
                   FROM `sap_prospect_industry`
                  WHERE `name` LIKE :term',
                ['term' => '%' . $_POST['term'] . '%']
            );
            jsonSuccess($sources);
            break;

        default:
            throw new Exception('Unknown action: ' . $action);
            break;
    }
}

/** ******************************************************************************************/

// show results?
if ('POST' == $_SERVER['REQUEST_METHOD'] || 'list-request' == Route::uriParam('action')) {

    if ('POST' == $_SERVER['REQUEST_METHOD']) {
        $outreachAccountId = $_POST['outreach_account_id'];

        $params = [
            'outreach_account_id3' => $outreachAccountId,
            'outreach_account_id4' => $outreachAccountId
        ];

        $select = 'SELECT p.*, pc.`name` AS `company`, pi.`name` AS `industry`,
                              pci.`name` AS `city`, pst.`name` AS `state`, ps.`name` AS `source`,
                          EXISTS(
                           SELECT 1
                             FROM `sap_client_dne` cd
                        LEFT JOIN `sap_client` c ON cd.`client_id` = c.`id`
                        LEFT JOIN `sap_client_account_outreach` cao ON cao.`client_id` = c.`id`
                            WHERE cao.`id` = :outreach_account_id3
                              AND cd.`domain` = right(p.`email`, length(p.`email`)-(INSTR(p.`email`, "@"))+1)
                          ) AS `dne`';

        $from = 'FROM `sap_prospect` p';

        $join = 'LEFT JOIN `sap_prospect_company` pc ON p.`company_id` = pc.`id`
                       LEFT JOIN `sap_prospect_industry` pi ON p.`industry_id` = pi.`id`
                       LEFT JOIN `sap_prospect_city` pci ON p.`city_id` = pci.`id`
                       LEFT JOIN `sap_prospect_state` pst ON p.`state_id` = pst.`id`
                       LEFT JOIN `sap_prospect_source` ps ON p.`source_id` = ps.`id`';

        $where = 'WHERE 1';

        // email, first/last name
        foreach (['email', 'first_name', 'last_name'] as $field) {
            if (!empty($_POST[$field])) {
                $where .= " AND `$field` LIKE :$field";
                $params[$field] = '%' . $_POST[$field] . '%';
            }
        }

        // list source
        if (!empty($_POST['source_id'])) {
            $where .= ' AND p.`source_id` = :source_id';
            $params['source_id'] = $_POST['source_id'];
        }

        // company
        if (!empty($_POST['company_id'])) {
            $where .= ' AND p.`company_id` = :company_id';
            $params['company_id'] = $_POST['company_id'];
        }

        // industries
        if (!empty($_POST['industries'])) {
            $industryIds = [];
            foreach ($_POST['industries'] as $industryId) {
                if (0 !== strpos($industryId, '!')) {
                    $industryIds[] = $industryId;
                }
            }
            if (count($industryIds) > 0) {
                $where .= ' AND p.`industry_id` IN (:industry_ids)';
                $params['industry_ids'] = implode(',', $industryIds);
            }
        }

        // countries
        if (!empty($_POST['countries'])) {
            $where .= " AND (p.`email` LIKE '%.com'";
            for ($i = 0; $i < count($_POST['countries']); $i++) {
                $where .= " OR p.`email` LIKE :country$i";
                $params['country' . $i] = '%' . $_POST['countries'][$i];
            }
            $where .= ')';
        }

        // states
        if (!empty($_POST['states'])) {
            $states = '';
            foreach ($_POST['states'] as $state) {
                $states .= "'" . $state . "',";
            }
            $states = substr($states, 0, -1);
            $where .= sprintf(' AND pst.`name` IN (%s)', $states);
        }

        // geotarget
        if (!empty($_POST['geotarget_lat']) && !empty($_POST['geotarget_lng'])) {
            $select .= sprintf(
                ", (3959 * acos(cos(radians('%F')) * cos(radians(`lat`)) * cos(radians(`lng`) - radians('%F')) + sin(radians('%F')) * sin(radians(`lat`)))) AS `distance`",
                $_POST['geotarget_lat'], $_POST['geotarget_lng'], $_POST['geotarget_lat']
            );

            $where .= sprintf(
                " HAVING distance < '%d'",
                $_POST['radius'] ?: 50
            );
        }

        // existing prospects
        switch ($_POST['prospect_scope']) {
            case 'this_account':
                $where .= ' AND (
                           SELECT COUNT(*)
                             FROM `sap_outreach_prospect`
                            WHERE `prospect_id` = p.`id`
                              AND `outreach_account_id` = :outreach_account_id4
                          ) = 1';
                break;

            case 'other_accounts':
                $where .= ' AND (
                           SELECT COUNT(*)
                             FROM `sap_outreach_prospect`
                            WHERE `prospect_id` = p.`id`
                              AND `outreach_account_id` = :outreach_account_id4
                          ) = 0';
                break;

            case 'all_accounts':
                $where .= ' AND (
                           SELECT COUNT(*)
                             FROM `sap_outreach_prospect`
                            WHERE `prospect_id` = p.`id`
                              AND `outreach_account_id` = :outreach_account_id4
                          ) IN (0,1)';
                break;
        }
    } else {
        $listRequestId     = Route::uriParam('id');
        $outreachAccountId = Db::fetchColumn(
            'SELECT * FROM `sap_list_request` WHERE `id` = :id',
            ['id' => $listRequestId],
            'outreach_account_id'
        );

        $params = [
            'outreach_account_id3' => $outreachAccountId,
            'list_request_id'      => $listRequestId
        ];

        $select = 'SELECT p.*, pc.`name` AS `company`, pi.`name` AS `industry`,
                              pci.`name` AS `city`, pst.`name` AS `state`, ps.`name` AS `source`,
                          EXISTS(
                           SELECT 1
                             FROM `sap_client_dne` cd
                        LEFT JOIN `sap_client` c ON cd.`client_id` = c.`id`
                        LEFT JOIN `sap_client_account_outreach` cao ON cao.`client_id` = c.`id`
                            WHERE cao.`id` = :outreach_account_id3
                              AND cd.`domain` = right(p.`email`, length(p.`email`)-(INSTR(p.`email`, "@"))+1)
                          ) AS `dne`';

        $from = 'FROM `sap_prospect` p';

        $join = 'LEFT JOIN `sap_prospect_company` pc ON p.`company_id` = pc.`id`
                 LEFT JOIN `sap_prospect_industry` pi ON p.`industry_id` = pi.`id`
                 LEFT JOIN `sap_prospect_city` pci ON p.`city_id` = pci.`id`
                 LEFT JOIN `sap_prospect_state` pst ON p.`state_id` = pst.`id`
                 LEFT JOIN `sap_prospect_source` ps ON p.`source_id` = ps.`id`
                 LEFT JOIN `sap_list_request_prospect` lrp ON lrp.`prospect_id` = p.`id` AND lrp.`list_request_id` = :list_request_id';

        $where = 'WHERE lrp.`id` IS NOT NULL';
    }

    ///////////////////////////////////
    // Process results
    ///////////////////////////////////

    $query     = "$select $from $join $where LIMIT 2000";
    $prospects = Db::fetchAll($query, $params);

    // titles
    if (!empty($_POST['titles'])) {
        $titles   = [];
        $titlesDb = Db::fetchAll(
            'SELECT * FROM `sap_group_title` WHERE `id` IN (:titleIds)',
            ['titleIds' => implode(',', $_POST['titles'])]
        );

        foreach ($titlesDb as $title) {
            $titles[$title['id']] = ['title' => $title['name'], 'variations' => [], 'negatives' => []];

            // variations
            $variations = Db::fetchAll(
                'SELECT * FROM `sap_group_title_variation` WHERE `group_title_id` = :group_title_id',
                ['group_title_id' => $title['id']]
            );

            foreach ($variations as $variation) {
                $titles[$title['id']]['variations'][] = $variation['name'];
            }

            // negatives
            $negatives = Db::fetchAll(
                'SELECT * FROM `sap_group_title_negative` WHERE `group_title_id` = :group_title_id',
                ['group_title_id' => $title['id']]
            );

            foreach ($negatives as $negative) {
                $titles[$title['id']]['negatives'][] = $negative['keyword'];
            }
        }
    }

    // departments
    if (!empty($_POST['departments'])) {

        // positive keywords
        $keywords = [];
        foreach ($_POST['departments'] as $departmentId) {
            foreach (Db::fetchAll(
                'SELECT * FROM `sap_department_keyword` WHERE `department_id` = :department_id',
                ['department_id' => $departmentId]
            ) as $department) {
                $keywords[] = $department['keyword'];
            }
        }

        // negative keywords
        $negativeKeywords = [];
        foreach (Db::fetchAll(
            'SELECT * FROM `sap_department_keyword` WHERE `department_id` NOT IN (:department_ids)',
            ['department_ids' => implode(',', $_POST['departments'])]
        ) as $department) {
            $negativeKeywords[] = $department['keyword'];
        }
    }

    // clean up & bucket results
    $bucket = [
        'never_contacted' => [],
        'last_30_days'    => [],
        'last_60_days'    => [],
        'last_90_days'    => [],
        '90plus_days'     => [],
        'skipped'         => [],
        'all'             => []
    ];

    foreach ($prospects as $i => $prospect) {
        // titles
        if (!empty($_POST['titles'])) {
            $titleMatches = false;

            foreach ($titles as $titleData) {
                // test title
                if (false !== strpos(strtolower($prospect['title']), strtolower($titleData['title']))) {
                    $titleMatches = true;
                }

                // test variations
                if (false == $titleMatches) {
                    foreach ($titleData['variations'] as $variation) {
                        if (false !== strpos(strtolower($prospect['title']), strtolower($variation))) {
                            $titleMatches = true;
                            break;
                        }
                    }
                }

                // test negatives
                if (true == $titleMatches) {
                    foreach ($titleData['negatives'] as $negative) {
                        if (false !== strpos(strtolower($prospect['title']), strtolower($negative))) {
                            $titleMatches = false;
                            break;
                        }
                    }

                    if (true == $titleMatches) {
                        break;
                    }
                }
            }
            if (false == $titleMatches) {
                continue;
            }
        }

        // departments
        if (!empty($_POST['departments'])) {
            $keywordMatches = false;

            foreach ($keywords as $keyword) {
                if (false !== strpos(strtolower($prospect['title']), strtolower($keyword))) {
                    $keywordMatches = true;
                    break;
                }
            }

            if (true == $keywordMatches) {
                foreach ($keywords as $keyword) {
                    $positiveKeywordPosition = strpos(strtolower($prospect['title']), strtolower($keyword));

                    if (false !== $positiveKeywordPosition) {

                        $keywordMatches = true;

                        // test against negative keywords
                        foreach ($negativeKeywords as $keywordNegative) {
                            $negativeKeywordPosition = strpos(strtolower($prospect['title']), strtolower($keywordNegative));
                            if (false !== $negativeKeywordPosition) {

                                if ($negativeKeywordPosition < $positiveKeywordPosition) {
                                    $keywordMatches = false;
                                }
                            }
                        }

                        if (true == $keywordMatches) {
                            break;
                        }
                    }
                }
            }
            if (false == $keywordMatches) {
                continue;
            }
        }

        // place into bucket
        $bucket['all'][] = $prospect;

        // skipped
        if (1 == $prospect['bounced'] || 1 == $prospect['dne']) {
            $bucket['skipped'][] = $prospect;
        } else {
            if (empty($prospect['last_emailed_at'])) {
                $bucket['never_contacted'][] = $prospect;
            } else {
                $contactedDaysAgo = ceil((time() - strtotime($prospect['last_emailed_at'])) / 86400);

                if ($contactedDaysAgo <= 30) {
                    $bucket['last_30_days'][] = $prospect;
                } elseif ($contactedDaysAgo > 30 && $contactedDaysAgo <= 60) {
                    $bucket['last_60_days'][] = $prospect;
                } elseif ($contactedDaysAgo > 60 && $contactedDaysAgo <= 90) {
                    $bucket['last_90_days'][] = $prospect;
                } elseif ($contactedDaysAgo > 90) {
                    $bucket['90plus_days'][] = $prospect;
                }
            }
        }
    }

    /** prepare list request title **/
    $client = Db::fetch(
        'SELECT c.*
           FROM `sap_client` c
      LEFT JOIN `sap_client_account_outreach` cao ON cao.`client_id` = c.`id`
          WHERE cao.`id` = :id',
        ['id' => $outreachAccountId]
    );

    $requestIndex = Db::fetchColumn(
        'SELECT * FROM `sap_client_account_outreach` WHERE `id` = :id',
        ['id' => $outreachAccountId],
        'request_index'
    );

    if (!is_int($requestIndex) || !($requestIndex > 0)) {
        $requestCount = (int) Db::fetchColumn(
                'SELECT COUNT(*) AS `count`
           FROM `sap_list_request`
          WHERE `outreach_account_id` = :outreach_account_id',
                ['outreach_account_id' => $outreachAccountId],
                'count'
            ) + 1;

        Db::query(
            'UPDATE `sap_client_account_outreach` SET `request_index` = :request_count WHERE `id` = :id',
            [
                'request_count' => $requestCount,
                'id'            => $outreachAccountId
            ]
        );

        $requestIndex = $requestCount;
    }

    $listRequestTitle = $client['name'] . ' ' . $requestIndex . ' () ' . date('mdy');
    
    /** prepopulate Ajax selects with selections **/

    // search profiles
    $searchProfiles = Db::fetchAll(
        'SELECT cp.*
           FROM `sap_client_profile` cp
      LEFT JOIN `sap_client_account_outreach` cao ON cao.`client_id` = cp.`client_id`
          WHERE cao.`id` = :id',
        ['id' => $outreachAccountId]
    );

    $_POST['searchProfiles'] = $searchProfiles;

    // source
    if (!empty($_POST['source_id'])) {
        $source = Db::fetch(
            'SELECT * FROM `sap_prospect_source` WHERE `id` = :id',
            ['id' => $_POST['source_id']]
        );

        $_POST['source_selected'] = ['id' => $_POST['source_id'], 'name' => $source['name']];
    }

    // company
    if (!empty($_POST['company_id'])) {
        $company = Db::fetch(
            'SELECT * FROM `sap_prospect_company` WHERE `id` = :id',
            ['id' => $_POST['company_id']]
        );

        $_POST['company_selected'] = ['id' => $_POST['company_id'], 'name' => $company['name']];
    }

    // industries
    if (!empty($_POST['industries'])) {
        $industries = [];

        foreach ($_POST['industries'] as $industryId) {
            if (0 === strpos($industryId, '!')) {
                $industries[$industryId] = substr($industryId, 1);
            } else {
                $industry = Db::fetch(
                    'SELECT *
                       FROM `sap_prospect_industry`
                      WHERE `id` = :industry_id',
                    ['industry_id' => $industryId]
                );
                $industries[$industry['id']] = $industry['name'];
            }
        }

        $_POST['industries_selected'] = $industries;
    }

    $formData = $_POST;
} else {
    $formData         = [];
    $bucket           = [];
    $listRequestTitle = null;
}

$accounts = [];
foreach (
    Db::fetchAll(
        'SELECT a.*, c.`name`
           FROM `sap_client_account_outreach` a
      LEFT JOIN `sap_client` c ON a.`client_id` = c.`id`
       ORDER BY c.`name` ASC, a.`email` ASC'
    ) as $account
) {
    if (!array_key_exists($account['name'], $accounts)) {
        $accounts[$account['name']] = [];
    }
    $accounts[$account['name']][] = $account;
}

$titles       = [];
$titlesDB     = Db::fetchAll(
    'SELECT t.*, g.name AS `group`
       FROM `sap_group_title` t
  LEFT JOIN `sap_group` g ON t.`group_id` = g.`id`
   ORDER BY g.`sort_order` ASC, t.`sort_order` ASC'
);

foreach ($titlesDB as $titleDB) {
    if (!array_key_exists($titleDB['group'], $titles)) {
        $titles[$titleDB['group']] = [];
    }
    $titles[$titleDB['group']][$titleDB['id']] = $titleDB['name'];
}

$departments     = Db::fetchAll('SELECT * FROM `sap_department` ORDER BY `department` ASC');
$assignableUsers = Db::fetchAll('SELECT * FROM `sap_user` WHERE `permissions` LIKE "%fulfill-list-requests%"');

sapperView(
    'prospects-search',
    [
        'companyAccounts'  => $accounts,
        'titles'           => $titles,
        'departments'      => $departments,
        'assignableUsers'  => $assignableUsers,

        'formData'         => $formData,
        'bucket'           => $bucket,
        'listRequestTitle' => $listRequestTitle
    ]
);