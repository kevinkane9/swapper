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
            $geoEncode = false;

            if (!empty($_POST['geotarget']) && !empty($_POST['geotarget_lat']) && !empty($_POST['geotarget_lng'])) {
                $geoEncode = true;
            }

            $results = Sapper\ProspectList::process(
                $_FILES['file']['tmp_name'],
                $_FILES['file']['name'],
                $_POST,
                false,
                false,
                $geoEncode
            );

            header('Location: /downloads/' . $results['download_id']);
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
    'process',
    [
        'titles'       => $titles,
        'departments'  => $departments,
        'clients'      => $clients
    ]
);