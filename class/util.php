<?php

namespace Sapper;

class Util {

    public static function val($haystack, $path) {
        for ($i=0; $i < count($path); $i++) {
            $root = $haystack;
            foreach(range(0, $i) as $j) {
                if ($j == $i) {
                    break;
                } else {
                    $root = $root[$path[$j]];
                }
            }
            if (!array_key_exists($path[$i], $root) || empty($root[$path[$i]])) {
                return null;
            }
        }
        return ('string' == gettype($root[$path[$i-1]])) ? trim($root[$path[$i-1]]) : $root[$path[$i-1]];
    }

    public static function getProspectDataFromCsvRow($row)
    {
        $companyId = self::prospectAttributeIdFix(
            'company',
            [
                'name'            => trim($row[21]),
                'division_name'   => trim($row[10]),
                'sic1'            => trim($row[37]),
                'sic2'            => trim($row[38]),
                'naics1'          => trim($row[39]),
                'naics2'          => trim($row[40]),
                'domain_name'     => trim($row[22]),
                'phone_number'    => trim($row[23]),
                'street_address'  => trim($row[24]),
                'city_id'         => self::prospectAttributeIdFix('city', ['name' => trim($row[25])]),
                'state_id'        => self::prospectAttributeIdFix('state', ['label' => trim($row[26])]),
                'zip'             => trim($row[27]),
                'country_id'      => self::prospectAttributeIdFix('country', ['name' => trim($row[28])]),
                'revenue'         => trim($row[33]),
                'revenue_range'   => trim($row[34]),
                'employees'       => trim($row[35]),
                'employees_range' => trim($row[36]),
            ]
        );

        $industryId = self::prospectAttributeIdFix(
            'industry',
            [
                'name' => trim($row[29]),
                'hierarchical_category' => trim($row[30]),
                'second_industry_label' => trim($row[31]),
                'second_industry_hierarchical_category' => trim($row[32]),
            ]
        );

        $data = [
            'email'                      => trim($row[12]),
            'first_name'                 => trim($row[2]),
            'middle_name'                => trim($row[3]),
            'last_name'                  => trim($row[1]),
            'suffix'                     => trim($row[4]),
            'title'                      => trim($row[6]),
            'title_code'                 => trim($row[41]),
            'title_hierarchy_level'      => trim($row[7]),
            'job_function'               => trim($row[8]),
            'management_level'           => trim($row[9]),
            'source_count'               => trim($row[10]),
            'highest_level_job_function' => trim($row[42]),
            'person_pro_url'             => trim($row[43]),
            'encrypted_email_address'    => trim($row[44]),
            'email_domain'               => trim($row[45]),
            'company_id'                 => $companyId,
            'phone_work'                 => trim($row[23]),
            'phone_personal'             => trim($row[11]),
            'address'                    => trim($row[13]),
            'city_id'                    => self::prospectAttributeIdFix('city', ['name' => trim($row[14])]),
            'state_id'                   => self::prospectAttributeIdFix('state', ['label' => trim($row[15])]),
            'zip'                        => trim($row[16]),
            'country_id'                 => self::prospectAttributeIdFix('country', ['name' => trim($row[17])]),
            'company_revenue'            => trim($row[33]),
            'company_employees'          => trim($row[35]),
            'industry_id'                => $industryId,
            'source_id'                  => self::prospectAttributeIdFix('source', ['name' => trim($row[48])]),
            'zoominfo_id'                => trim($row[0]),
            'zoominfo_company_id'        => trim($row[20]),
        ];

        return $data;
    }

    public static function prospectAttributeId($entity, $name) {
        try {
            if (!empty($name)) {

                $id = Db::fetchColumn(
                    sprintf('SELECT `id` FROM `sap_%s` WHERE `name` = :name', $entity),
                    ['name' => $name],
                    'id'
                );

                if (!($id>0)) {
                    $id = Db::insert(
                        sprintf('INSERT INTO `sap_%s` (`name`) VALUES (:name)', $entity),
                        ['name' => $name]
                    );
                }

                return $id;
            } else {
                return null;
            }
        } catch (\Exception $exc) {
            return null;
        }
    }

    public static function prospectAttributeIdFix($entity, $data) {
        try {
            $key = $entity === 'state' ? 'label' : 'name';

            if (empty($data[$key]) ) {
                return null;
            }

            $id = Db::fetchColumn(
                sprintf('SELECT `id` FROM `sap_prospect_%s` WHERE `%s` = :%s', $entity, $key, $key),
                [$key => $data[$key]],
                'id'
            );

            if (!($id>0)) {
                $id = DB::createRow('prospect_' . $entity, $data);
            }

            return $id;
        } catch (\Exception $exc) {
            echo '<pre>';
            var_dump($exc);
            exit;
        }
    }

    public static function collapseSidebar($state) {
        $_SESSION['sidebar_collapsed']  = 'true' == $state ? true : false;
    }

    public static function convertDate($date, $inputFormat = 'm/d/Y', $outputFormat = 'Y-m-d') {
        switch ($inputFormat) {
            case 'm/d/Y':
                $time = strtotime(substr($date, 6, 4) . '-' . substr($date, 0, 2) . '-' . substr($date, 3, 2));
                break;

            case 'Y-m-d':
                $time = strtotime($date);
                break;
        }

        return date($outputFormat, $time);
    }

    public static function numberToPercent($number = 0) {
        $formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);

        return $formatter->format($number);
    }

    public static function get($array, $key, $default = NULL)
    {
        if ($array instanceof ArrayObject) {
            // This is a workaround for inconsistent implementation of isset between PHP and HHVM
            // See https://github.com/facebook/hhvm/issues/3437
            return $array->offsetExists($key) ? $array->offsetGet($key) : $default;
        } else {
            return isset($array[$key]) ? $array[$key] : $default;
        }
    }

    public static function calculateHealthScore($hsData = array()) {  
        $deal_closed = (int)self::get($hsData, 'deal_closed', 0);      
        $deal_closed_av = (int)self::get($hsData, 'deal_closed_av', 0);    
        $weeks_ago = (int)self::get($hsData, 'weeks_ago', 0);    
        $weeks_ago_av = (int)self::get($hsData, 'weeks_ago_av', 0);    
        $contract_meetings = (int)self::get($hsData, 'contract_meetings', 0);    
        $contract_meetings_av = (int)self::get($hsData, 'contract_meetings_av', 0);    
        $total_meetings = (int)self::get($hsData, 'total_meetings', 0);    
        $total_meetings_av = (int)self::get($hsData, 'total_meetings_av', 0);    
        $total_weeks = (int)self::get($hsData, 'total_weeks', 0);    
        $total_weeks_av = (int)self::get($hsData, 'total_weeks_av', 0);  
          
        $opp_in_progress = (int)self::get($hsData, 'opp_in_progress', 0);    
        $opp_in_progress_av = (int)self::get($hsData, 'opp_in_progress_av', 0);    

        $right_prospect_noip = (int)self::get($hsData, 'right_prospect_noip', 0);    
        $right_prospect_noip_av = (int)self::get($hsData, 'right_prospect_noip_av', 0);  
          
        $wrong_prospect_oip = (int)self::get($hsData, 'wrong_prospect_oip', 0);    
        $wrong_prospect_oip_av = (int)self::get($hsData, 'wrong_prospect_oip_av', 0);    
          
        $wrong_prospect = (int)self::get($hsData, 'wrong_prospect', 0);    
        $wrong_prospect_av = (int)self::get($hsData, 'wrong_prospect_av', 0);    
          
        $no_prospect = (int)self::get($hsData, 'no_prospect', 0);    
        $no_prospect_av = (int)self::get($hsData, 'no_prospect_av', 0);    
          
        $total_meetings = (int)self::get($hsData, 'total_meetings', 0);    
        $total_meetings_av = (int)self::get($hsData, 'total_meetings_av', 0);    
          
        $weeks_last_meeting = (int)self::get($hsData, 'weeks_last_meeting', 0);    
        $weeks_last_meeting_av = (int)self::get($hsData, 'weeks_last_meeting_av', 0);    
        
        $impression_score = (int)self::get($hsData, 'impression_score', 0);    


        $c5 = $deal_closed + $deal_closed_av;
        $c6 = $weeks_ago + $weeks_ago_av;

        $b9 = $contract_meetings + $contract_meetings_av;
        
        if (!empty(($contract_meetings + $contract_meetings_av))) {
            $b10 = ($total_meetings + $total_meetings_av) / ($contract_meetings + $contract_meetings_av);
        } else {
            $b10 = 0;
        }
        
        $b13 = $total_weeks + $total_weeks_av;

        $c24 = $c19 = $opp_in_progress + $opp_in_progress_av;
        $c24 += $c20 = $right_prospect_noip + $right_prospect_noip_av;
        $c24 += $c21 = $wrong_prospect_oip + $wrong_prospect_oip_av;
        $c24 += $c22 = $wrong_prospect + $wrong_prospect_av;
        $c24 += $c23 = $no_prospect + $no_prospect_av;

        $c43 = $total_meetings + $total_meetings_av;

        $b14 = $weeks_last_meeting + $weeks_last_meeting_av;
        $b37 = $impression_score;

        $d19 = 100;
        $d20 = 75;
        $d21 = 50;
        $d22 = 25;
        $d23 = 0;
        $d24 = $c24 * 100;

        $d5 = $c5 * 1;

        if ($c6 > 26) {
            $d6 = 0.01;
        } else {
            $d6 = $d5;
        }

        $e14 = $b14 * 2;
        $b15 = $b13 + $e14;
        $b43 = $b9; 
        $e24 = $e19 = $c19 * $d19;
        $e24 += $e20 = $c20 * $d20;
        $e24 += $e21 = $c21 * $d21;
        $e24 += $e22 = $c22 * $d22;
        $e24 += $e23 = $c23 * $d23;
        $e43 = $b15;

        $f20 = !empty($c43) ? ($c24 / $c43) : 0;

        $f22 = (int)$c43 - $c24;
        $f24 = !empty($d24) ? round(($e24 / $d24) * 100) : 0;

        $b41 = !empty($e43) ? round((($c43 / $e43) / 1.5) * 100) : 0;
        $c41 = !empty($b43) ? ($c43 / $b43) * 100 : 0;
        $d41 = ($f24 + $d6);

        $d43 = $f20;

        $e41 = $b37;

        $c47 = 25;
        $d47 = 30;
        $e47 = 30;
        $f47 = 15;

        if ($b41 > 100) {
            $c48 = 100;
        } else {
            $c48 = $b41;
        }

        if ($c41 > 1) {
            $d48 = 1;
        } else {
            $d48 = $c41;
        }

        if ($d41 > 100) {
            $e48 = 1;
        } else {
            $e48 = $f24;
        }

        $f48 = $e41;

        $c51 = ($c48 * $c47) / 100;
        $d51 = $d48 * $d47;
        $e51 = round(($e48 * $e47) / 100);
        $f51 = ($f48 * $f47) / 100;

        $score = round($c51 + $d51 + $e51 + $f51);
        
        if (is_nan($score) OR !is_numeric($score)) {
            $score = 0;
        }
        
        return $score;
    }
    
    public static function calculateSurveyScore($hsData = array()) {        
        $c5 = (int)$hsData['deal_closed'] + (int)$hsData['deal_closed_av'];
        $c6 = (int)$hsData['weeks_ago'] + (int)$hsData['weeks_ago_av'];

        $b9 = (int)$hsData['contract_meetings'] + (int)$hsData['contract_meetings_av'];
        $b10 = ((int)$hsData['total_meetings'] + (int)$hsData['total_meetings_av']) / ((int)$hsData['contract_meetings'] + (int)$hsData['contract_meetings_av']);
        $b13 = (int)$hsData['total_weeks'] + (int)$hsData['total_weeks_av'];

        $c24 = $c19 = (int)$hsData['opp_in_progress'] + (int)$hsData['opp_in_progress_av'];
        $c24 += $c20 = (int)$hsData['right_prospect_noip'] + (int)$hsData['right_prospect_noip_av'];
        $c24 += $c21 = (int)$hsData['wrong_prospect_oip'] + (int)$hsData['wrong_prospect_oip_av'];
        $c24 += $c22 = (int)$hsData['wrong_prospect'] + (int)$hsData['wrong_prospect_av'];
        $c24 += $c23 = (int)$hsData['no_prospect'] + (int)$hsData['no_prospect_av'];

        $c43 = (int)$hsData['total_meetings'] + (int)$hsData['total_meetings_av'];

        $b14 = (int)$hsData['weeks_last_meeting'] + (int)$hsData['weeks_last_meeting_av'];
        $b37 = (int)$hsData['impression_score'];

        $d19 = 100;
        $d20 = 75;
        $d21 = 50;
        $d22 = 25;
        $d23 = 0;
        $d24 = $c24 * 100;

        $d5 = $c5 * 1;

        if ($c6 > 26) {
            $d6 = 0.01;
        } else {
            $d6 = $d5;
        }

        $e14 = $b14 * 2;
        $b15 = $b13 + $e14;
        $b43 = $b9; 
        $e24 = $e19 = $c19 * $d19;
        $e24 += $e20 = $c20 * $d20;
        $e24 += $e21 = $c21 * $d21;
        $e24 += $e22 = $c22 * $d22;
        $e24 += $e23 = $c23 * $d23;
        $e43 = $b15;

        $f20 = !empty($c43) ? $c24 / $c43 : 0;

        $f22 = (int)$c43 - $c24;
        $f24 = !empty($d24) ? round(($e24 / $d24) * 100) : 0;

        $b41 = !empty($e43) ? round((($c43 / $e43) / 1.5) * 100) : 0;
        $c41 = !empty($b43) ? ($c43 / $b43) * 100 : 0;
        $d41 = ($f24 + $d6);

        $d43 = $f20;

        $e41 = $b37;

        $c47 = 25;
        $d47 = 30;
        $e47 = 30;
        $f47 = 15;

        if ($b41 > 100) {
            $c48 = 100;
        } else {
            $c48 = $b41;
        }

        if ($c41 > 1) {
            $d48 = 1;
        } else {
            $d48 = $c41;
        }

        if ($d41 > 100) {
            $e48 = 1;
        } else {
            $e48 = $f24;
        }

        $f48 = $e41;

        $c51 = ($c48 * $c47) / 100;
        $d51 = $d48 * $d47;
        $e51 = round(($e48 * $e47) / 100);
        $f51 = ($f48 * $f47) / 100;

        $score = round($c51 + $d51 + $e51 + $f51);
        
        if (is_nan($f24) OR !is_numeric($f24)) {
            $f24 = 0;
        }
        
        return $f24;
    }
        
    public static function addLog ($log_data = '') {
        $log_file_path = APP_ROOT_PATH . '/var/logs/';
        
        $logger = new \Katzgrau\KLogger\Logger($log_file_path);
        $logger->info($log_data, ['pid' => $GLOBALS['pid']]);
    }

    public static function sendSurveyInvitation($event, $surveyInvitationEmails) {
        foreach ($surveyInvitationEmails as $email) {
            $email = trim($email);

            if (!empty($email) AND filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Mail::send(
                    'survey',
                    ['noreply@sappersuite.com', 'Sapper Consulting'],
                    [$email, $email],
                    'Post Meeting Survey',
                    [
                        'eventId'    => $event['event_id'],
                        'eventTitle' => $event['title'] ?: 'Meeting',
                        'eventDate'  => date('F j, Y', strtotime($event['ends_at'])),
                    ]
                );
            } else {
                Util::addLog('Send Surveys Process: Error: Invalid or Missing survey email address event id: ' . $event['event_id']);
            }
        }

        Db::query(
            'UPDATE `sap_gmail_events` SET `status` = "survey_sent" WHERE `event_id` = :event_id',
            ['event_id' => $event['event_id']]
        );
    }

    public static function getDomainFromEmail($email = '') {
        return strtolower(substr(strrchr($email, "@"), 1));
    }
}
