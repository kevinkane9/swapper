<?php

use Sapper\Db,
    Sapper\User,
    Sapper\Model,
    Sapper\Route;

// permissions
if (!User::can('normalize-csv-files')) {
    sapperView('error', ['title' => 'Oops!', 'message' => 'You do not have permission to access this feature.']);
}

if ('POST' == $_SERVER['REQUEST_METHOD']) {

    switch (Route::uriParam('action')) {
        case 'get-client-profiles':
            $profiles = Db::fetchAll(
                'SELECT * FROM `sap_client_profile` WHERE `client_id` = :client_id',
                ['client_id' => $_POST['id']]
            );

            jsonSuccess($profiles);
            break;

        case 'get-profile-preferences':
            $profileId = $_POST['id'];
            $profile   = Db::fetch(
                'SELECT * FROM `sap_client_profile` WHERE `id` = :id',
                ['id' => $profileId]
            );

            $profile['states']    = empty($profile['states'])    ? [] : json_decode($profile['states']);
            $profile['countries'] = empty($profile['countries']) ? [] : json_decode($profile['countries']);

            $profileTitles   = [];
            $profileTitlesDB = Db::fetchAll(
                'SELECT * FROM `sap_client_profile_title` WHERE `client_profile_id` = :profile_id',
                ['profile_id' => $profileId]
            );

            foreach ($profileTitlesDB as $profileTitleDB) {
                $profileTitles[] = $profileTitleDB['title_id'];
            }

            $profileDepartments   = [];
            $profileDepartmentsDB = Db::fetchAll(
                'SELECT * FROM `sap_client_profile_department` WHERE `client_profile_id` = :profile_id',
                ['profile_id' => $profileId]
            );

            foreach ($profileDepartmentsDB as $profileDepartmentDB) {
                $profileDepartments[] = $profileDepartmentDB['department_id'];
            }

            jsonSuccess(
              [
                  'profile'            => $profile,
                  'profileTitles'      => $profileTitles,
                  'profileDepartments' => $profileDepartments
              ]
            );

            break;

        case 'process':
            if (!empty($_POST) AND !empty($_FILES['file']['name'])) {
                $clientId   = $_POST['client_id'];
                $clientName = Db::fetchColumn(
                    'SELECT * FROM `sap_client` WHERE `id` = :client_id',
                    ['client_id' => $clientId],
                    'name'
                );
                
                if (!empty($_FILES['file']['name'])) {
                    $path = APP_ROOT_PATH . '/upload/temp';

                    if (!is_dir($path)) {
                        mkdir($path);
                    }

                    $filename = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);
                    $file_abs_path = $path . '/' . $filename . '.csv';
                    
                    unlink($file_abs_path); 
                    
//                    $i=0;
//                    
//                    $files = glob($file_abs_path);
//                    
//                    if (!empty($files)) {
//                        $file_count = count($files);
//                        $filename .= "(" . $file_count . ")";
//                    }
//                    
//                    echo $filename;
//                    die;

//                    while (file_exists($file_abs_path)) {
//                        $filename .= 1;
//                        
//                        $i++;
//                        
//                        if ($i == 10) {
//                            echo $filename; die;
//                        }
//                    }
// die();
                    move_uploaded_file($_FILES['file']['tmp_name'], $file_abs_path); 
                } else {
                    echo "No File Submitted";
                    die();
                }

                try {
                    $id = Db::insert(
                        'INSERT INTO `sap_download_filtered`
                                (`list_request_id`, 
                                `created_on`, 
                                `filename`, 
                                `row_count`, 
                                `nidb`, 
                                `nidb_count`,
                                `idbnor`, 
                                `idbnor_count`,
                                `idbior`, 
                                `idbior_count`,
                                `filtered`, 
                                `filtered_count`,
                                 `purged`, `purged_count`, 
                                 `saved_to_db`, 
                                 `uploaded_to_outreach`,
                                 `client_id`,
                                 `client_name`,
                                 `search_criteria`
                                 )
                          VALUES (:list_request_id, :created_on, :filename, :row_count, 
                          :nidb, 
                          :nidb_count,
                          :idbnor, 
                          :idbnor_count,
                          :idbior, 
                          :idbior_count,
                          :filtered, 
                          :filtered_count,
                                  :purged, :purged_count, :saved_to_db, 
                                  :uploaded_to_outreach,
                                  :client_id,
                                  :client_name,
                                  :search_criteria)',
                        [
                            'list_request_id'      => null,
                            'created_on'           => date('Y-m-d'),
                            'filename'             => $filename,
                            'row_count'            => 0,
                            'nidb'             => '',
                            'nidb_count'       => 0,
                            'idbnor'             => '',
                            'idbnor_count'       => 0,
                            'idbior'             => '',
                            'idbior_count'       => 0,
                            'filtered'             => '',
                            'filtered_count'       => 0,
                            'purged'               => '',
                            'purged_count'         => 0,
                            'saved_to_db'          => 0,
                            'uploaded_to_outreach' => 0,
                            'client_id' => $clientId,
                            'client_name' => $clientName,
                            'search_criteria' => '',
                        ]
                    );               

                    $data_job['download_id'] = $id;
                    $data_job['type'] = 'normaliz-csv-filtered';
                    $data_job['post'] = $_POST;
                    $data_job['file'] = $file_abs_path;

                    Db::insert(
                        'INSERT INTO `sap_background_job` (`data`) VALUES (:data)',
                        ['data' => json_encode($data_job)]
                    );
                    
                    sleep(10);
                    
                    exec($GLOBALS['sapper-env']['PATH_TO_PHP'] . 'php ' . APP_ROOT_PATH . '/cron/process-request.php > /dev/null 2>&1 &');                    
                } catch (\Exception $exc) {
                    echo $exc->getMessage();
                }
            } else {
                echo "No form or file submitted.";
                exit();
            }

            header('Location: /process-filtered/');
            exit;
            break;

        default:
            throw new \Exception('Unknown action');
            break;
    }
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

$departments  = Db::fetchAll('SELECT * FROM `sap_department` ORDER BY `department` ASC');
$clients      = Db::fetchAll('SELECT * FROM `sap_client` ORDER BY `name` ASC');

sapperView(
    'process-filtered',
    [
        'titles'       => $titles,
        'departments'  => $departments,
        'clients'      => $clients
    ]
);
