<?php

use Sapper\Route,
 Sapper\Util,
    Sapper\Db;

switch (Route::uriParam('action')) {
    case 'view':
        
        
//        $filtered_download = Db::fetchAll(
//            'SELECT DISTINCT prospect_id FROM `sap_download_filtered_prospect`'
//        ); 
//
//
//        foreach ($filtered_download as $filtered) {
//            $prospect_id = $filtered['prospect_id'];
// 
//            $prs[] = $prospect_id;
//        }
//        echo implode(',',$prs);
//        
//        die;
        
        $query = [];
        $query['new'] = $query['recycled'] = '
           SELECT  r.*, u1.`first_name` AS `created_by_first_name`, 
                  u1.`last_name` AS `created_by_last_name`,
                  u2.`first_name` AS `fulfilled_by_first_name`, 
                  u2.`last_name` AS `fulfilled_by_last_name`,
                  u3.`first_name` AS `closed_by_first_name`, 
                  u3.`last_name` AS `closed_by_last_name`,
                  u4.`first_name` AS `assigned_to_first_name`, 
                  u4.`last_name` AS `assigned_to_last_name`,
                   c.`name` AS `client`,
                   c.`id` AS `client_id`
             FROM    `sap_list_request` r
        LEFT JOIN    `sap_user` u1 ON u1.`id` = r.`created_by`
        LEFT JOIN    `sap_user` u2 ON u2.`id` = r.`fulfilled_by`
        LEFT JOIN    `sap_user` u3 ON u3.`id` = r.`closed_by`
        LEFT JOIN    `sap_user` u4 ON u4.`id` = r.`assigned_to`
        LEFT JOIN    `sap_client_account_outreach` cao ON cao.`id` = r.`outreach_account_id`
        LEFT JOIN    `sap_client` c ON c.`id` = cao.`client_id`
            WHERE  r.`type` = :type';

        $params = ['new' => ['type' => 'new'], 'recycled' => ['type' => 'recycled']];

        foreach (['new', 'recycled'] as $type) {
            foreach (
                ['status' => 'r.`status`', 'assigned_to' => 'r.`assigned_to`', 'client_id' => 'c.`id`']
                as $key => $column
            ) {
                if (!empty($_POST[$type][$key])) {
                    $params[$type][$key] = $_POST[$type][$key];
                    $query[$type] .= sprintf(' AND %s = :%s', $column, $key);
                }
            }

            if (empty($_POST[$type]['status'])) {
                $params[$type]['status'] = 'new';
                $query[$type] .= ' AND r.`status` = :status';
            }

            if (empty($_POST[$type]['show_archived'])) {
                $query[$type] .= ' AND r.`created_at` >= DATE_SUB(DATE(NOW()),INTERVAL 7 DAY)';
            }

            if (!empty($_POST[$type]['sort_by_due_date'])) {
                $query[$type] .= ' ORDER BY r.`due_date` DESC';
            } else {
                $query[$type] .= ' ORDER BY r.`sort_order` ASC';
            }
        }

        $newRequestClients = [];
        $newRequests = [];
        foreach (Db::fetchAll($query['new'], $params['new']) as $newRequest) {
            $newRequests[] = Sapper\ProspectList::populateData($newRequest);

            if (!array_key_exists($newRequest['client_id'], $newRequestClients)) {
                $newRequestClients[$newRequest['client_id']] = $newRequest['client'];
            }
        }

        $recycledRequestClients = [];
        $recycledRequests = [];
        foreach (Db::fetchAll($query['recycled'], $params['recycled']) as $recycledRequest) {
            $recycledRequest['comments'] = Db::fetchAll(
                'SELECT lrc.*, u.`first_name`, u.`last_name`
                   FROM     `sap_list_request_comment` lrc
              LEFT JOIN     `sap_user` u ON lrc.`created_by` = u.`id`
                  WHERE lrc.`list_request_id` = :list_request_id
               ORDER BY lrc.`created_at` DESC',
                ['list_request_id' => $recycledRequest['id']]
            );

            $recycledRequest['num_prospects'] = Db::fetchColumn(
                'SELECT COUNT(*) AS `count` FROM `sap_list_request_prospect` WHERE `list_request_id` = :list_request_id',
                ['list_request_id' => $recycledRequest['id']],
                'count'
            );

            $recycledRequest['num_comments'] = Db::fetchColumn(
                'SELECT COUNT(*) AS `count` FROM `sap_list_request_comment` WHERE `list_request_id` = :list_request_id',
                ['list_request_id' => $recycledRequest['id']],
                'count'
            );

            $recycledRequests[] = $recycledRequest;

            if (!array_key_exists($recycledRequest['client_id'], $recycledRequestClients)) {
                $recycledRequestClients[$recycledRequest['client_id']] = $recycledRequest['client'];
            }
        }

        $assignableUsers = Db::fetchAll('SELECT * FROM `sap_user` WHERE `permissions` LIKE "%fulfill-list-requests%"');

        sapperView(
            'board',
            [
                'assignableUsers' => $assignableUsers,

                'newRequests' => $newRequests,
                'newRequestClients' => $newRequestClients,

                'recycledRequests' => $recycledRequests,
                'recycledRequestClients' => $recycledRequestClients
            ]
        );
        break;

    case 'sort':
        Db::query(
            'UPDATE `sap_list_request` SET `sort_order` = NULL WHERE `type` = :type',
            ['type' => $_POST['type']]
        );

        for ($i = 1; $i <= count($_POST['sortOrder']); $i++) {
            Db::query(
                'UPDATE `sap_list_request` SET `sort_order` = :sort_order WHERE `id` = :id',
                ['sort_order' => $i, 'id' => $_POST['sortOrder'][$i - 1]]
            );
        }
        jsonSuccess();
        break;

    case 'close':
        Db::query(
            'UPDATE `sap_list_request`
                SET `sort_order` = null, `status` = "closed", `closed_by` = :closed_by, `closed_at` = NOW()
              WHERE `id` = :id',
            [
                'closed_by' => Sapper\Auth::token('userId'),
                'id' => $_POST['id']
            ]
        );
        jsonSuccess();
        break;

    case 'delete':
        Db::query(
            'DELETE FROM `sap_list_request` WHERE `id` = :id',
            ['id' => $_POST['id']]
        );

        // check if any processing background jobs are for this card
        $jobs = Db::fetchAll('SELECT * FROM `sap_background_job` WHERE `status` = "processing"');

        foreach ($jobs as $job) {
            $data = json_decode($job['data'], true);

            if ($data['list_request_id'] == $_POST['id'] && !empty($data['list_request_id'])) {
                Db::query(
                    'UPDATE `sap_background_job` SET `status` = "deleted" WHERE `id` = :id',
                    ['id' => $job['id']]
                );
            }
        }

        jsonSuccess();
        break;

    case 'fulfill':
        $path = APP_ROOT_PATH . '/upload/' . date('Y-m-d');

        if (!is_dir($path)) {
            mkdir($path);
        }

        $filename = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);

        while (file_exists($path . '/' . $filename . '.csv')) {
            $filename .= 1;
        }

        move_uploaded_file($_FILES['file']['tmp_name'], $path . '/' . $filename . '.csv');

        Db::query(
            'UPDATE `sap_list_request` SET `status` = :status WHERE `id` = :id',
            [
                'status' => 'new',
                'id' => $_POST['list_request_id']
            ]
        );

        Db::insert(
            'INSERT INTO `sap_background_job` (`data`) VALUES (:data)',
            [
                'data' => json_encode(
                    [
                        'type' => 'list_request',
                        'list_request_id' => $_POST['list_request_id'],
                        'filename' => date('Y-m-d') . '/' . $filename . '.csv'
                    ],
                    JSON_UNESCAPED_SLASHES
                )
            ]
        );

        exec($GLOBALS['sapper-env']['PATH_TO_PHP'] . 'php ' . APP_ROOT_PATH . '/cron/process-request.php > /dev/null 2>&1 &');

        header('Location: /board/success');
        exit;
        break;
        
    case 'fulfill-filtered':         
        $list_request_id = !empty($_POST['list_request_id']) ? $_POST['list_request_id'] : '';
        $download_filtered_id = !empty($_POST['download_filtered_id']) ? $_POST['download_filtered_id'] : '';
        $client_id = !empty($_POST['client_id']) ? $_POST['client_id'] : '';

        $filtered_download = Db::fetch(
            'SELECT * FROM `sap_download_filtered` WHERE `id` = :id',
            ['id' => $download_filtered_id]
        );
        
        $list_request = Db::fetch(
            'SELECT * FROM `sap_list_request` WHERE `id` = :id',
            ['id' => $list_request_id]
        );
        
        $prospectIds = [];
        $prospect_ids_master = [];
        $prospect_ids_master['in_db_not_in_outreach'] = [];
        $prospect_ids_master['new_prospects'] = [];

        if (!empty($filtered_download)) {
            $file = $filtered_download['idbnor'];
            $full_file_path = 'upload/' . $filtered_download['created_on'] . '/' . $file;

            if (file_exists($full_file_path)) {
                ## echo "file exists";
                $idb_prospects = array_map('str_getcsv', file($full_file_path));
                if(!empty($idb_prospects)) {
                    foreach($idb_prospects as $k=>$idb_prospect) {
                        if ($k = 0 || empty($idb_prospect[4])) {
                            continue;
                        }

                        $prospect  = Db::fetch(
                            "SELECT * FROM `sap_prospect` WHERE `email` = :email",
                            ['email'=>trim($idb_prospect[4])]
                        );

                        if ($prospect) {
                            $prospect_ids_master['in_db_not_in_outreach'][] = $prospect;
                            $prospectIds[] = $prospect['id'];
                        }
                        
                    }
                }
            } else {
                ## echo "File not found";
                ## die;
            }
        } 
        
        $new_prospect_ids = [];
        $not_insert_ids = [];
        $new_prospects = [];  
        
        if (!empty($_FILES['file']['tmp_name'])) {

            $file = $_FILES['file']['tmp_name'];
            $new_import_prospects = array_map('str_getcsv', file($file));
            unset($new_import_prospects[0]);
            
            $new_import_prospects_arr = [];
            foreach ($new_import_prospects as $new_import_prospect) {
                $new_import_prospects_arr[$new_import_prospect[0]] = $new_import_prospect;
            }
            
//            echo "<pre>";
//            print_r($new_import_prospects_arr);
//            exit();
            
            $file = $filtered_download['nidb'];
            $full_file_path = 'upload/' . $filtered_download['created_on'] . '/' . $file;            
            $notindb_prospects = array_map('str_getcsv', file($full_file_path));
            unset($notindb_prospects[0]);
            
//            echo "Not In DB  <br><br>";
//            
//            echo "<pre>";
//            print_R($notindb_prospects);
//            die;
            
            foreach ($notindb_prospects as $notindb_prospect) {
                if (!empty($new_import_prospects_arr[$notindb_prospect[1]])) {
                    $row = $new_import_prospects_arr[$notindb_prospect[1]];
        //            //[0] => Zoom Individual ID
        //            //[20] => Zoom company ID
        //            
        //            //[2] => First Name
        //            //[1] => Last Name
        //            //[12] => Email
        //            //[6] => Title
        //
        //            //[21] => Company
        //            //[23] => Work Phone
        //            //[11] => Mobile Phone
        //
        //            //[24] => Address
        //            //[25] => City
        //            //[26] => State
        //            //[27] => Zip
        //            //[28] => Country
        //            //[33] => Revenue
        //            //[35] => Employees
        //            //[29] => Company Industry
        //            //[48] => Source
        //            //
        //            //
        //            //
        //            //[8] => Website
        //            //[4] => Account
        //            //[18] => Sapper Client Segment
        //
                    ## If email column is empty, jump to next iteration
                    if (empty($row[12])) {
                        continue;
                    }     

                    // TODO: A prospect can never be found in the database at this stage because we only going through prospects that are not in the db, what is the right thing to do?
                    $prospect  = Db::fetch(
                        "SELECT * FROM `sap_prospect` WHERE `email` = :email",
                        ['email'=>trim($row[12])]
                    );

                    if (!empty($prospect)) {
                        if ($prospect['zoominfo_company_id'] != trim($row[20]) || $prospect['zoominfo_id'] != trim($row[0])) {
                            $prospectId = $prospect['id'];

                            $data = Util::getProspectDataFromCsvRow($row);

                            DB::updateRowById('prospect', $prospectId, $data);
                        }
                    } else {
                        $data = Util::getProspectDataFromCsvRow($row);

                        $prospectId = DB::createRow('prospect', $data);
                    }

                    if (!empty($prospectId) AND !in_array($prospectId, $prospectIds)  ) {
                        $prospectIds[] = $prospectId;
                        $new_prospect_ids[] = $prospectId;
                        $new_prospects[] = Db::fetch('SELECT * FROM `sap_prospect` WHERE `id` = :id', ['id' => $prospectId]);                                
                    }
                }
            }
            
            if(!empty($prospectIds)) {
                foreach ($prospectIds as $prospectId) {
                    try {
                        $insert = Db::insert(
                            'INSERT INTO `sap_download_filtered_prospect` (`download_id`, `prospect_id`)
                                      VALUES (:download_id, :prospect_id)',
                            [
                                'download_id' => $download_filtered_id,
                                'prospect_id' => $prospectId
                            ]
                        );
                    } catch (\Exception $e) {
                        //throw $e;
                    }
                }
            }

            Db::query(
                'UPDATE `sap_list_request` '
                    . 'SET `saved_to_db` = 1,'
                    . '`status` = :status,'
                    . '`saved_to_db_count` = :saved_to_db_count,'
                    . '`saved_to_db` = :saved_to_db,'
                    . '`saved_to_db_ids` = :saved_to_db_ids '
                    . 'WHERE `id` = :id',
                [
                    'id' => $list_request_id,
                    'status' => 'QA Check',
                    'saved_to_db' => true,
                    'saved_to_db_count' => count($new_prospect_ids),
                    'saved_to_db_ids' => json_encode($new_prospect_ids)
                ]
            ); 
        } else {
            $saved_to_db_ids = Db::fetchColumn(
                'SELECT `saved_to_db_ids` AS `new_prospects` FROM `sap_list_request` WHERE `id` = :list_request_id AND saved_to_db = 1',
                ['list_request_id' =>$list_request_id],
                'new_prospects'
            );
            
            if (!empty($saved_to_db_ids)) {
                $new_prospects_arr = json_decode($saved_to_db_ids);
                
                $new_prospects = [];
                if (!empty($new_prospects_arr)) {
                    foreach ($new_prospects_arr as $pid) {
                        $new_prospects[] = Db::fetch('SELECT * FROM `sap_prospect` WHERE `id` = :id', ['id' => $pid]);
                    }
                }
            }
        }

        $prospect_ids_master['new_prospects'] = $new_prospects;

        $combined_prospects = array_merge($prospect_ids_master['in_db_not_in_outreach'], $prospect_ids_master['new_prospects']);

        sapperView(
            'fulfill-filtered',
            [
                'bucket' => $prospect_ids_master,
                'bucket_combined' => $combined_prospects,
                'list_request_id' => $list_request_id,
                'list_request' => $list_request,
                'download_filtered_id' => $download_filtered_id,
                'outreach_account_id' => $list_request['outreach_account_id'],
                'client_id' => $client_id,
            ]
        );
        break;
    case 'prospects-save':
        if (!empty($_POST['prospect'])) {
            
            $sql_params = [];
            
            foreach ($_POST['prospect'] as $prospectId=>$prospect) {               
                try {
                    $sql  = 'UPDATE `sap_prospect` SET ';

                    if (!empty($prospect['first_name'])) {
                        $sql  .= '`first_name` = :first_name, ';
                        $sql_params['first_name'] = $prospect['first_name'];
                    }     

                    if (!empty($prospect['first_name'])) {
                        $sql  .= '`last_name` = :last_name, ';
                        $sql_params['last_name'] = $prospect['last_name'];
                    }

                    $sql  .= '`updated_at` = :updated_at ';
                    $sql_params['updated_at'] = date('Y-m-d H:i:s');
                    
                    $sql  .= ' WHERE `id` = :id ';
                    $sql_params['id'] = $prospectId;

                    Db::query($sql,$sql_params);
                    
//                    echo $prospectId . " Prospect updated. \n\n";
                    echo $sql . "\n\n\n";
                    
                } catch (\Exception $exc) {
                   echo $exc->getMessage() . '\n\n\n';
                }                           
                
            }
            
            $json['status'] = 'success';
        } else {
            $json['status'] = 'error';
        }
        
        echo json_encode($json);
        exit();
        break;

    case 'approve':
        Db::query(
            'UPDATE `sap_list_request` SET `status` = :status WHERE `id` = :id',
            [
                'status' => 'new',
                'id' => $_POST['list_request_id']
            ]
        );

        Db::insert(
            'INSERT INTO `sap_background_job` (`data`) VALUES (:data)',
            ['data' => json_encode(['type' => 'list_request', 'list_request_id' => $_POST['list_request_id']])]
        );

        exec($GLOBALS['sapper-env']['PATH_TO_PHP'] . 'php ' . APP_ROOT_PATH . '/cron/process-request.php > /dev/null 2>&1 &');

        header('Location: /board/success');
        exit;
        break;

    case 'reprocess':
        Db::query(
            'UPDATE `sap_list_request` SET `status` = :status WHERE `id` = :id',
            [
                'status' => 'new',
                'id' => $_POST['list_request_id']
            ]
        );

        Db::insert(
            'INSERT INTO `sap_background_job` (`data`) VALUES (:data)',
            ['data' => json_encode(['list_request_id' => $_POST['list_request_id']])]
        );

        exec($GLOBALS['sapper-env']['PATH_TO_PHP'] . 'php ' . APP_ROOT_PATH . '/cron/process-request.php > /dev/null 2>&1 &');

        header('Location: /board/success');
        exit;
        break;

    case 'upload-to-outreach':
        $prospects = [];
        if (!empty($_POST['hdn-prospects'])) {
            parse_str(urldecode($_POST['hdn-prospects']), $prospects);
        }
        
        Db::query(
            'UPDATE `sap_list_request` SET `status` = :status,`uploaded_to_outreach` = :uploaded_to_outreach WHERE `id` = :id',
            [
                'status' => 'processing',
                'uploaded_to_outreach' => 1,
                'id' => $_POST['list_request_id']
            ]
        );
        
        $list_request = Db::fetch(
            'SELECT * FROM `sap_list_request` WHERE `id` = :id',
            ['id' => $_POST['list_request_id']]
        ); 
        
        $list_request_title = !empty($list_request['title']) ? $list_request['title'] : '';
        
        $data_job['tag'] = trim($list_request_title);
        $data_job['type'] = 'upload-normalized-csv-filtered';
        $data_job['list_request_id'] = $_POST['list_request_id'];
        $data_job['download_filtered_id'] = $_POST['download_filtered_id'];
        $data_job['outreach_account_id'] = $_POST['outreach_account_id'];
        $data_job['client_id'] = $_POST['client_id'];
        $data_job['prospect_ids'] = !empty($prospects['prospects']) ? $prospects['prospects'] : $_POST['prospects'];

        // check if tag exists at all (previously we checked only tags from this client
        $dbTagId = Db::fetchColumn(
            'SELECT * FROM `sap_prospect_tag` WHERE `name` = :name',
            ['name' => trim($list_request_title)],
            'id'
        );

        if (null == $dbTagId) {
            $dbTagId = Db::insert(
                'INSERT INTO `sap_prospect_tag` (`name`) VALUES (:name)', ['name' => trim($list_request_title)]
            );
        }       

        Db::insert(
            'INSERT INTO `sap_background_job` (`data`) VALUES (:data)',
            ['data' => json_encode($data_job)]
        );

        exec($GLOBALS['sapper-env']['PATH_TO_PHP'] . 'php ' . APP_ROOT_PATH . '/cron/process-request.php > /dev/null 2>&1 &');

        header('Location: /board/success');
        exit;
        break;

    case 'export':
        $list_request_id = !empty($_POST['list_request_id']) ? $_POST['list_request_id'] : '';
        $download_filtered_id = !empty($_POST['download_filtered_id']) ? $_POST['download_filtered_id'] : '';
        $client_id = !empty($_POST['client_id']) ? $_POST['client_id'] : '';
        
        try {
            $filtered_download = Db::fetch(
                'SELECT * FROM `sap_download_filtered` WHERE `id` = :id',
                ['id' => $download_filtered_id]
            );

            $list_request = Db::fetch(
                'SELECT * FROM `sap_list_request` WHERE `id` = :id',
                ['id' => $list_request_id]
            );

            $prospectIds = [];
            $prospect_ids_master = [];

            if (!empty($filtered_download)) {
                $filename = $filtered_download['filename'];

                $file = $filtered_download['idbnor'];
                $full_file_path = 'upload/' . $filtered_download['created_on'] . '/' . $file;

                if (file_exists($full_file_path)) {
                    ## echo "file exists";
                    $idb_prospects = array_map('str_getcsv', file($full_file_path));
                    $outputHeaders = $idb_prospects[0];

                    unset($idb_prospects[0]);
                    if(!empty($idb_prospects)) {
                        $prospect_ids_master['in_db_not_in_outreach'] = $idb_prospects;

    //                    foreach($idb_prospects as $idb_prospect) {
    //                        if (empty($idb_prospect[4])) {
    //                            continue;
    //                        }
    //                        $prospect  = Db::fetch(
    //                            "SELECT * FROM `sap_prospect` WHERE `email` = '" . trim($idb_prospect[4]) . "'"
    //                        );
    //
    //                        if ($prospect) {
    //                            $prospect_ids_master['in_db_not_in_outreach'][] = $prospect;
    //                            $prospectIds[] = $prospect['id'];
    //                        }
    //
    //                    }
                    }
                }
            } 

            $new_prospect_ids = [];
            $not_insert_ids = [];
            $new_prospects = []; 

            $saved_to_db_ids = Db::fetchColumn(
                'SELECT `saved_to_db_ids` AS `new_prospects` FROM `sap_list_request` WHERE `id` = :list_request_id AND saved_to_db = 1',
                ['list_request_id' =>$list_request_id],
                'new_prospects'
            );

            if (!empty($saved_to_db_ids)) {
                $new_prospects_arr = json_decode($saved_to_db_ids);

                $new_prospects = [];
                if (!empty($new_prospects_arr)) {
                    foreach ($new_prospects_arr as $pid) {
                        $new_prospects[] =  Db::fetch(
                            'SELECT  p.*, pc.`name` AS `company`, pi.`name` AS `industry`,
                                     pci.`name` AS `city`, pst.`label` AS `state`, ps.`name` AS `source`
                               FROM `sap_prospect` p
                          LEFT JOIN `sap_prospect_company` pc ON p.`company_id` = pc.`id`
                          LEFT JOIN `sap_prospect_industry` pi ON p.`industry_id` = pi.`id`
                          LEFT JOIN `sap_prospect_city` pci ON p.`city_id` = pci.`id`
                          LEFT JOIN `sap_prospect_state` pst ON p.`state_id` = pst.`id`
                          LEFT JOIN `sap_prospect_source` ps ON p.`source_id` = ps.`id`
                              WHERE p.`id` = :prospect_id',
                            ['prospect_id' => $pid]
                        );
                    }
                }
            }  

            $prospect_ids_master['new_prospects'] = $new_prospects;


            $combined_prospects = array_merge($prospect_ids_master['in_db_not_in_outreach'], $prospect_ids_master['new_prospects']);

            // set dir & filenames
            $path = APP_ROOT_PATH . '/upload/export';
            if (!is_dir($path)) {
                mkdir($path);
            }            

            $exportSuffix = " (Combined-export)";
            $exportFile = $filename . $exportSuffix . '.csv';

            ## Creating CSV ##
            $output = fopen($path . '/' . $exportFile, 'w');

            fputcsv($output, $outputHeaders);

            foreach ($idb_prospects as $rowData) {
                fputcsv(
                    $output,
                    $rowData
                );
            }

            foreach ($new_prospects as $row) {
                fputcsv(
                    $output,                           
                    [
                        isset($row['zoominfo_id'])     ? $row['zoominfo_id']   : '',
                        isset($row['zoominfo_company_id'])     ? $row['zoominfo_company_id']   : '',
                        isset($row['first_name'])     ? $row['first_name']   : '',
                        isset($row['last_name'])     ? $row['last_name']   : '',
                        isset($row['email'])     ? $row['email']   : '',
                        isset($row['title'])     ? $row['title']   : '',
                        isset($row['account'])     ? $row['account']   : '',
                        isset($row['company'])     ? $row['company']   : '',
                        isset($row['phone_work'])     ? $row['phone_work']   : '',
                        isset($row['phone_personal'])     ? $row['phone_personal']   : '',
                        isset($row['website'])     ? $row['website']   : '',
                        isset($row['address'])     ? $row['address']   : '',
                        isset($row['city'])     ? $row['city']   : '',
                        isset($row['state'])     ? $row['state']   : '',
                        isset($row['zip'])     ? $row['zip']   : '',
                        isset($row['country'])     ? $row['country']   : 'United States',
                        isset($row['company_revenue']) ? $row['company_revenue'] : '',
                        isset($row['company_employees'])     ? $row['company_employees']   : '',
                        isset($row['industry'])     ? $row['industry']   : '',
                        isset($row['source'])     ? $row['source']   : '',
                        isset($row['sapper_client_Segment'])     ? $row['sapper_client_Segment']   : '',
                    ]
                );
            }            
            fclose($output);            
            ## Creating CSV ##


            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename=' . str_replace(',', '', $exportFile));
            header('Pragma: no-cache');
            readfile(APP_ROOT_PATH . '/upload/export' . '/' . $exportFile);
        } catch (\Exception $e) {
           echo $e->getMessage() . '<br><br><br>';
           echo $e->getTraceAsString() . '<br><br><br>';           
        }

        exit;
        break;        

    case 'success':
        sapperView('board-success');
        break;

    default:
        throw new Exception('Unknown action');
        break;
}
