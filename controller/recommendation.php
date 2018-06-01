<?php

use Sapper\Route;
use Sapper\Db;
use Sapper\GmailEvent;

if ($action = Route::uriParam('action')) {
    switch ($action) {

        case 'get-client-attributes':
            $data = Db::fetch(
                'SELECT p.*, LOWER(`state`) AS `state`
                   FROM `sap_client` c
              LEFT JOIN `sap_client_prosperworks` p ON c.`prosperworks_id` = p.`id`
                  WHERE c.`id` = :client_id',
                ['client_id' => $_POST['clientId']]
            );

            jsonSuccess($data);
            break;

        case 'check-sufficient-data':
            /*
             * here we are checking for sufficient similar companies & converted prospects
             * if there is sufficient, we return success and form submits to "generate" action
             * if insufficient, we return failure and user can adjust form selections & retry
             */

            // reconstruct $_POST data
            parse_str($_POST['data'], $_POST);

            $data       = findSimilarCompanies();
            $companyIds = $data['companyIds'];

            if (count($companyIds) < 3) {
                jsonError();
            }

            $availableProspects = findConvertedProspects($companyIds, true);

            if ($availableProspects < 10) {
                jsonError();
            }

            jsonSuccess();
            break;

        case 'generate':
            $data       = findSimilarCompanies();
            $companyIds = $data['companyIds'];
            $confidence = $data['confidence'];

            $outreachProspectIds = findConvertedProspects($companyIds, false);

            /** generate stats */

            // average response time
            $avgResponseTime = Db::fetchColumn(
                sprintf(
                    'SELECT ROUND(AVG(`response_time_days`),1) AS `average_response_time`
                     FROM `sap_outreach_prospect_mailing` WHERE outreach_prospect_id IN (%s)',
                    implode(',', $outreachProspectIds)
                ), [], 'average_response_time'
            );

            // average cycle time
            /*$totalCycleTime = 0;
            foreach ($companyIds as $companyId) {
                $totalCycleTime += Db::fetchColumn(
                    sprintf(
                        'SELECT DATEDIFF(`launch_date`,
                        (SELECT DATE_FORMAT(e.`created_at`, "%s")
                           FROM `sap_gmail_events` e
                      LEFT JOIN `sap_gmail_event_colors` ec ON e.`event_color_id` = ec.`id`
                      LEFT JOIN `sap_client_account_gmail` g ON e.`account_id` = g.`id`
                          WHERE g.`client_id` = %d
            //// add point about Jan 1 2018
                            AND ec.`background_color` IN (%s)
                       ORDER BY e.`created_at` ASC LIMIT 1)
                      ) AS `cycle_time`
                      FROM `sap_client`
                     WHERE `id` = %d',
                        '%Y-%m-%d',
                        $companyId,
                        implode(',', array_map(function($val){ return "'". $val ."'"; }, GmailEvent::getEligibleColors())),
                        $companyId
                    ), [], 'cycle_time'
                );
            }
            $avgCycleTime = floor($totalCycleTime/count($companyIds));*/

            // average monthly meetings
            $totalMonthlyMeetings = 0;
            $monthlyMeetingCounts = Db::fetchAll(
                sprintf(
                    'SELECT g.`client_id`, COUNT(*) AS `count`, YEAR(e.`created_at`), MONTH(e.`created_at`)
                       FROM `sap_gmail_events` e
                  LEFT JOIN `sap_gmail_event_colors` ec ON e.`event_color_id` = ec.`id`
                  LEFT JOIN `sap_client_account_gmail` g ON e.`account_id` = g.`id`
                      WHERE g.`client_id` IN (%s)
                        AND ec.`background_color` IN (%s)
                        AND e.`created_at` >= "2018-01-01 00:00:00"
                   GROUP BY g.`client_id`, YEAR(e.`created_at`), MONTH(e.`created_at`)',
                    implode(',', $companyIds),
                    implode(',', array_map(function($val){ return "'". $val ."'"; }, GmailEvent::getEligibleColors()))
                )
            );

            foreach ($monthlyMeetingCounts as $monthlyMeetingCount) {
                $totalMonthlyMeetings += $monthlyMeetingCount['count'];
            }

            $avgMonthlyMeetings = floor($totalMonthlyMeetings / count($companyIds));

            $idealCompanySize = Db::fetchColumn(
                sprintf(
                    'SELECT r.`display_name` AS `range`
                       FROM `sap_outreach_prospect` op
                  LEFT JOIN `sap_prospect` p ON op.`prospect_id` = p.`id`
                  LEFT JOIN `sap_prospect_company` pc ON p.`company_id` = pc.`id`
                  LEFT JOIN `sap_employee_range` r ON pc.`employees_range` = r.`employees_range`
                      WHERE p.`company_id` IS NOT NULL
                        AND pc.`employees_range` IS NOT NULL
                        AND op.`id` IN (%s)
                   GROUP BY r.`employees_range`
                   ORDER BY COUNT(*) DESC
                      LIMIT 1',
                    implode(',', $outreachProspectIds)
                ), [], 'range'
            );

            $idealCompanyRevenue = Db::fetchColumn(
                sprintf(
                    'SELECT r.`display_name` AS `range`
                       FROM `sap_outreach_prospect` op
                  LEFT JOIN `sap_prospect` p ON op.`prospect_id` = p.`id`
                  LEFT JOIN `sap_prospect_company` pc ON p.`company_id` = pc.`id`
                  LEFT JOIN `sap_revenue_range` r ON pc.`revenue_range` = r.`revenue_range`
                      WHERE p.`company_id` IS NOT NULL
                        AND pc.`revenue_range` IS NOT NULL
                        AND op.`id` IN (%s)
                   GROUP BY r.`revenue_range`
                   ORDER BY COUNT(*) DESC
                      LIMIT 1',
                    implode(',', $outreachProspectIds)
                ), [], 'range'
            );

            /** Determine Top Titles */
            $titleDistributionRows = Db::fetchAll(
                sprintf(
                    'SELECT COUNT(*) AS `count`, t.`name`, p.`title`
                       FROM `sap_outreach_prospect` op
                  LEFT JOIN `sap_prospect` p ON op.`prospect_id` = p.`id`
                  LEFT JOIN `sap_group_title` t ON p.`group_title_id` = t.`id`
                      WHERE p.`group_title_id` IS NOT NULL
                        AND op.`id` IN (%s)
                   GROUP BY t.`name`
                   ORDER BY COUNT(*) DESC',
                    implode(',', $outreachProspectIds)
                )
            );
            
            $totalTitles = 0;
            foreach ($titleDistributionRows as $titleDistributionRow) {
                $totalTitles += $titleDistributionRow['count'];
            }
            
            $topTitles = [];
            
            for ($i = 0; $i <= 3; $i++) {
                if (!array_key_exists($i, $titleDistributionRows)) {
                    break;
                }

                $topTitles[$titleDistributionRows[$i]['title']] = $titleDistributionRows[$i]['count'];
            }

            populateRelativeMaxFillPercents($topTitles, $totalTitles);

            /** Determine Top Industries */
            $industryDistributionRows = Db::fetchAll(
                sprintf(
                    'SELECT COUNT(*) AS `count`, pic.`name`
                       FROM `sap_outreach_prospect` op
                  LEFT JOIN `sap_prospect` p ON op.`prospect_id` = p.`id`
                  LEFT JOIN `sap_prospect_industry` pi ON p.`industry_id` = pi.`id`
                  LEFT JOIN `sap_prospect_industry_condensed` pic ON pi.`condensed_id` = pic.`id`
                      WHERE p.`industry_id` IS NOT NULL
                        AND op.`id` IN (%s)
                   GROUP BY pic.`name`
                   ORDER BY COUNT(*) DESC',
                    implode(',', $outreachProspectIds)
                )
            );

            $totalIndustries = 0;
            foreach ($industryDistributionRows as $industryDistributionRow) {
                $totalIndustries += $industryDistributionRow['count'];
            }

            $topIndustries = [];

            for ($i = 0; $i <= 3; $i++) {
                if (!array_key_exists($i, $industryDistributionRows)) {
                    break;
                }

                $topIndustries[$industryDistributionRows[$i]['name']] = $industryDistributionRows[$i]['count'];
            }

            populateRelativeMaxFillPercents($topIndustries, $totalIndustries);

            /** Top Email Template */
            $topEmailTemplate = Db::fetch(
                sprintf(
                    'SELECT t.*
                       FROM `sap_gmail_events` e
                  LEFT JOIN `sap_gmail_event_colors` ec ON e.`event_color_id` = ec.`id`
                  LEFT JOIN `sap_client_account_gmail` g ON e.`account_id` = g.`id`
                  LEFT JOIN `sap_prospect` p ON e.`prospect_id` = p.`id`
                  LEFT JOIN `sap_outreach_prospect` op ON op.`prospect_id` = p.`id`
                  LEFT JOIN `sap_outreach_template` t ON op.`outreach_account_id` = t.`outreach_account_id` AND t.`template_id` = e.`template_id`
                      WHERE ec.`background_color` IN (%s)
                        AND op.`id` IN (%s)
                        AND e.`template_id` IS NOT NULL
                        AND t.`subject` IS NOT NULL
                        AND e.`created_at` >= "2018-01-01 00:00:00"
                   GROUP BY t.`id`
                   ORDER BY COUNT(*) DESC
                      LIMIT 1',
                    implode(',', array_map(function($val){ return "'". $val ."'"; }, GmailEvent::getEligibleColors())),
                    implode(',', $outreachProspectIds)
                )
            );

            /** Location distribution */
            $locationRows = Db::fetchAll(
                sprintf(
                    'SELECT COUNT(*) AS `count`, `name` AS `state`
                       FROM `sap_outreach_prospect` op
                  LEFT JOIN `sap_prospect` p ON op.`prospect_id` = p.`id`
                  LEFT JOIN `sap_prospect_state` ps ON p.`state_id` = ps.`id`
                      WHERE op.`id` IN (%s)
                        AND p.`state_id` IS NOT NULL
                   GROUP BY ps.`id`
                   ORDER BY ps.`name` ASC',
                    implode(',', $outreachProspectIds)
                )
            );

            $prospectsWithStates = array_sum(array_map(function($item) {
                return $item['count'];
            }, $locationRows));

            // convert counts into %s
            $locations = [];

            foreach ($locationRows as $locationRow){
                $locations[] = [
                    'code'   => $locationRow['state'],
                    'value'  => ceil(($locationRow['count'] / $prospectsWithStates)*100)
                ];
            }

            sapperView(
                'recommendation-result',
                [
                    'avgResponseTime'     => $avgResponseTime,
                    //'avgCycleTime'        => $avgCycleTime,
                    'avgMonthlyMeetings'  => $avgMonthlyMeetings,
                    'idealCompanySize'    => $idealCompanySize,
                    'idealCompanyRevenue' => $idealCompanyRevenue,

                    'topTitles'     => $topTitles,
                    'topIndustries' => $topIndustries,

                    'topEmailTemplate'    => $topEmailTemplate,
                    'locations'           => $locations,

                    'generationStats'        => [
                        'similarCompanies'   => count($companyIds),
                        'convertedProspects' => count($outreachProspectIds),
                        'confidence'         => $confidence
                    ]
                ]
            );
            break;
    }
}

/**
 * Find 5 similar companies using data in $_POST
 * @return array
 */
function findSimilarCompanies()
{
    // are we looking for all companies?
    if (empty($_POST['industry']) && empty($_POST['company_revenue']) && empty($_POST['number_of_employees'])) {
        $confidence = 100;
        $companies  = Db::fetchAll('SELECT `id` FROM `sap_client`');
    } else {
        // find similar clients
        $confidence = 100;
        $queryBase  = 'SELECT c.`id`
                         FROM `sap_client` c
                    LEFT JOIN `sap_client_prosperworks` p ON c.`prosperworks_id` = p.`id`
                        WHERE c.`prosperworks_id` IS NOT NULL ';

        $industryClause = !empty($_POST['industry'])            ? 'AND p.`industry` = :industry ' : '';
        $revenueClause  = !empty($_POST['company_revenue'])     ? 'AND p.`company_revenue` = :company_revenue ' : '';
        $employeeClause = !empty($_POST['number_of_employees']) ? 'AND p.`number_of_employees` = :number_of_employees ' : '';

        $params = [];

        if (!empty($_POST['industry'])) {
            $params['industry'] = $_POST['industry'];
        }

        if (!empty($_POST['company_revenue'])) {
            $params['company_revenue'] = $_POST['company_revenue'];
        }

        if (!empty($_POST['number_of_employees'])) {
            $params['number_of_employees'] = $_POST['number_of_employees'];
        }

        // attempt 1: 3 criteria
        $companies = Db::fetchAll(
            $queryBase.$industryClause.$revenueClause.$employeeClause,
            $params
        );

        // attempt 2: 2 criteria
        if (count($companies) < 5 && !empty($_POST['company_revenue'])) {
            unset($params['number_of_employees']);
            $companies = Db::fetchAll(
                $queryBase.$industryClause.$revenueClause,
                $params
            );

            $confidence = 80;
        }

        // attempt 3: 1 criteria
        if (count($companies) < 5 && !empty($_POST['industry'])) {
            unset($params['company_revenue']);
            $companies = Db::fetchAll(
                $queryBase.$industryClause,
                $params
            );

            $confidence = 60;
        }
    }

    $companyIds = [];
    foreach ($companies as $company) {
        $companyIds[] = $company['id'];
    }

    return [
        'companyIds' => $companyIds,
        'confidence' => $confidence
    ];
}

/**
 * Find and filter converted prospects from similar companies
 * @return array
 */
function findConvertedProspects($companyIds, $countOnly)
{
    $prospectQuery = sprintf(
        'SELECT '. ($countOnly ? 'COUNT(p.`id`) AS `count` ' : 'op.`id` ') .
          'FROM `sap_gmail_events` e
      LEFT JOIN `sap_gmail_event_colors` ec ON e.`event_color_id` = ec.`id`
      LEFT JOIN `sap_prospect` p ON e.`prospect_id` = p.`id`
      LEFT JOIN `sap_group_title` t ON p.`group_title_id` = t.`id`
      LEFT JOIN `sap_prospect_industry` i ON p.`industry_id` = i.`id`
      LEFT JOIN `sap_prospect_industry_condensed` ic ON i.`condensed_id` = ic.`id`
      LEFT JOIN `sap_outreach_prospect` op ON op.`prospect_id` = p.`id`
      LEFT JOIN `sap_client_account_outreach` o ON op.`outreach_account_id` = o.`id`
          WHERE e.`prospect_id` IS NOT NULL
            AND e.`created_at` >= "2018-01-01 00:00:00"
            AND ec.`background_color` IN ('.
                implode(',', array_map(function($val){ return "'". $val ."'"; }, GmailEvent::getEligibleColors()))
            .')
            AND o.`client_id` IN (%s) ',
        implode(',', $companyIds)
    );

    // filter by approved industry IDs
    if (count($_POST['approved_industry_ids'])) {
        $prospectQuery .= sprintf(
            'AND ic.`id` IN (%s) ',
            implode(',',
                array_map(
                    function($val) {
                        return (int) $val;
                    }, $_POST['approved_industry_ids']
                )
            )
        );
    }

    // filter by approved title groups
    if (count($_POST['approved_title_group_ids'])) {
        $prospectQuery .= sprintf(
            'AND t.`group_id` IN (%s) ',
            implode(',',
                array_map(
                    function($val) {
                        return (int) $val;
                    }, $_POST['approved_title_group_ids']
                )
            )
        );
    }

    if ($countOnly) {
        return Db::fetchColumn(
            $prospectQuery, [], 'count'
        );
    } else {
        $outreachProspectIds = [];

        $rows = Db::fetchAll($prospectQuery);

        foreach ($rows as $row) {
            $outreachProspectIds[] = $row['id'];
        }

        return $outreachProspectIds;
    }
}

function populateRelativeMaxFillPercents(&$entries, $totalEntries)
{
    $relativeMax = max($entries) + ceil($totalEntries*.02);

    foreach ($entries as $key => $count) {
        $entries[$key] = [
            'display_percent' => ceil(($count/$totalEntries)*100),
            'fill_percent' => ceil(($count/$relativeMax)*100)
        ];
    }
}


// show initial form
$clients = Db::fetchAll('SELECT * FROM `sap_client` ORDER BY `name` ASC');

$employeeRanges = Db::fetchAll('SELECT * FROM `sap_employee_range` ORDER BY `index` ASC');
$revenueRanges  = Db::fetchAll('SELECT * FROM `sap_revenue_range` ORDER BY `index` ASC');
$titleGroups    = Db::fetchAll('SELECT * FROM `sap_group` ORDER BY `sort_order` ASC');

$prospectIndustries = Db::fetchAll(
    'SELECT ic.`id`, ic.`name`
       FROM `sap_gmail_events` e
  LEFT JOIN `sap_prospect` p ON e.`prospect_id` = p.`id`
  LEFT JOIN `sap_prospect_industry` i ON p.`industry_id` = i.`id`
  LEFT JOIN `sap_prospect_industry_condensed` ic ON i.`condensed_id` = ic.`id`
      WHERE e.`prospect_id` IS NOT NULL
        AND i.`id` IS NOT NULL
        AND ic.`id` IS NOT NULL
        AND e.`created_at` >= "2018-01-01 00:00:00"
   GROUP BY ic.`id`
   ORDER BY ic.`name` ASC'
);

sapperView(
    'recommendation',
    [
        'clients'            => $clients,
        'employeeRanges'     => $employeeRanges,
        'revenueRanges'      => $revenueRanges,
        'titleGroups'        => $titleGroups,
        'prospectIndustries' => $prospectIndustries
    ]
);