<?php

use Sapper\Db,
    Sapper\User,
    Sapper\Auth,
    Sapper\Route;

// permissions
if (!User::can('search-prospects')) {
    sapperView('error', ['title' => 'Oops!', 'message' => 'You do not have permission to access this feature.']);
}
$action = Route::uriParam('action');

if (false !== ($action = Route::uriParam('action'))) {
    switch ($action) {
        case 'list-requests':
            $requests = Db::fetchAll(
                "SELECT r.*, c.*, CONCAT(u.first_name,' ',u.last_name) AS user_name  FROM `sap_client_targeting_requests` r 
                LEFT JOIN sap_client c 
                ON r.client_id = c.id
                LEFT JOIN sap_user u 
                ON r.created_by = u.id"
            );

            sapperView(
                'targeting-requests-list',
                [
                    'requests' => $requests
                ]
            );
            break;          
        case 'ajax-load-targeting-profile':
            $profile_data = Db::fetch(
                'SELECT *
                   FROM `sap_client_targeting_profiles`
                  WHERE `client_id` = :client_id',
                ['client_id' => $_POST['client_id']]
            );

            $requests_data = Db::fetchAll(
                'SELECT *
                   FROM `sap_client_targeting_requests`
                  WHERE `client_id` = :client_id',
                ['client_id' => $_POST['client_id']]
            );

            $client = Db::fetch(
                'SELECT *
                   FROM `sap_client`
                  WHERE `id` = :client_id',
                ['client_id' => $_POST['client_id']]
            );

            if (!empty($requests_data)) {
                $requestIndex = count($requests_data) + 1;
            } else {
                $requestIndex = 1;
            }  
            
            $listRequestTitle = $client['name'] . ' ' . $requestIndex . ' () ' . date('mdy');            

            if (empty($profile_data)) {
                jsonResponse(['data'=>['listRequestTitle'=>$listRequestTitle]]);
            }


            $_SESSION['listRequestTitle'] = $listRequestTitle;
            $_SESSION['profile_data'] = $profile_data;
            $_SESSION['client_id'] = $_POST['client_id'];

            jsonSuccess(['listRequestTitle'=>$listRequestTitle]);
            break;

            case 'comment':
            $commentId = Db::insert(
                'INSERT INTO `sap_targeting_request_comment` (`list_request_id`, `comment`, `created_by`)
                      VALUES (:list_request_id, :comment, :created_by)',
                [
                    'list_request_id' => $_POST['listRequestId'],
                    'comment'         => $_POST['comment'],
                    'created_by'      => Sapper\Auth::token('userId')
                ]
            );
    
            $comment = Db::fetch(
                'SELECT lrc.*, u.`first_name`, u.`last_name`
                       FROM     `sap_targeting_request_comment` lrc
                  LEFT JOIN     `sap_user` u ON lrc.`created_by` = u.`id`
                      WHERE lrc.`id` = :id',
                ['id' => $commentId]
            );
    
            $comment['created_at'] = date('M j, Y h:ia', strtotime($comment['created_at']));
            $comment['comment']    = str_replace("\n", '<br>', $comment['comment']);
    
            jsonSuccess($comment);
            break;            
        case 'save-meta':
            $request_id = $_POST['request_id'];
            $build_to = $_POST['build_to'];

            try {
                Db::query(
                    'UPDATE `sap_client_targeting_requests`
                        SET `build_to` = :build_to
                      WHERE `request_id` = :request_id',
                    [
                        'build_to' => !empty($_POST['build_to']) ? $_POST['build_to']: '',
                        'request_id' => !empty($_POST['request_id']) ? $_POST['request_id'] : ''
                    ]
                );
            } catch (Exception $e) {
                Route::setFlash('danger', $e->getMessage());
                header("Location: /targeting-request/edit/$request_id");
                exit;
            }

            if (empty($request_id)) {
                Route::setFlash('danger', 'No Requests Found');
                header("Location: /targeting-request/edit/$request_id");
                exit;
            }

            Route::setFlash('success', 'Build to value saved.');
            header("Location: /targeting-request/edit/$request_id");
            break;            
        case 'edit':
            $id = Route::uriParam('id');

            $request = Db::fetch(
                "SELECT r.*, c.*, CONCAT(u.first_name,' ',u.last_name) AS user_name  FROM `sap_client_targeting_requests` r 
                LEFT JOIN sap_client c 
                ON r.client_id = c.id
                LEFT JOIN sap_user u 
                ON r.created_by = u.id
                WHERE request_id = :id",
                ['id'=>$id]
            );

            $client_id = !empty($_SESSION['client_id']) ? $_SESSION['client_id'] : '';
            $profile_data = !empty($_SESSION['profile_data']) ? $_SESSION['profile_data'] : '';
        
            unset($_SESSION['client_id']);
            unset($_SESSION['profile_data']);
        
            if (empty($profile_data)) {
                $client_id = '';
                $profile_data['title'] = '';
                $profile_data['titles'] = '';
                $profile_data['countries'] = '';
                $profile_data['industries'] = '';
                $profile_data['industry_keywords'] = '';
                $profile_data['naics'] = '';
                $profile_data['departments'] = '';
                $profile_data['employee_size_from'] = '';
                $profile_data['employee_size_to'] = '';
                $profile_data['revenue_from'] = '';
                $profile_data['revenue_to'] = '';
                $profile_data['company_attr'] = '';
                $profile_data['company_attr_txt'] = '';
                $profile_data['company_att_value'] = '';
                $profile_data['prospect_management_level'] = '';
                $profile_data['titles_keywords'] = '';
                $profile_data['city'] = '';
                $profile_data['states'] = '';
                $profile_data['countries'] = '';
                $profile_data['geotarget'] = '';
                $profile_data['geotarget_lat'] = '';
                $profile_data['geotarget_lng'] = '';
                $profile_data['radius'] = '';
                $profile_data['link_notes'] = '';
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
            $clients      = Db::fetchAll('SELECT * FROM `sap_client` ORDER BY `name` ASC');
            $industries = Db::fetchAll(
                'SELECT * FROM `sap_prospect_industry` ORDER BY `name` ASC'
            );    
            
            if (empty($profile_data['profile_id'])) {
                $profile_data = $request;
                if (empty($client_id)) {
                    $client_id = $request['client_id'];
                }
            }

            sapperView(
                'targeting-request-view',
                [
                    'client_id'           => $client_id,
                    'clients'           => $clients,                    
                    'titles'           => $titles,
                    'departments'      => $departments,           
                    'industries'      => $industries,    
                    'profile' => $profile_data,                                     
                ]
            );
            break;
        default:
            throw new Exception('Unknown action: ' . $action);
            break;
    }
}

/** ******************************************************************************************/
if (!empty($_POST)) {
    try {
        $id = Db::insert(
            'INSERT INTO `sap_client_targeting_requests`
                    (`client_id`, 
                    `title`, 
                    `industries`, 
                    `industry_keywords`, 
                    `naics`, 
                    `departments`, 
                    `employee_size_from`,
                    `employee_size_to`, 
                    `revenue_from`,
                    `revenue_to`, 
                    `company_attr`,
                    `company_attr_txt`,
                    `prospect_management_level`, 
                    `titles`,
                    `titles_keywords`,
                    `city`, 
                    `states`, 
                    `countries`, 
                    `geotarget`,
                    `geotarget_lat`,
                    `geotarget_lng`,
                    `radius`,
                    `link_notes`,
                    `status`,
                    `created_by`,
                    `created_at`
                     )
              VALUES (:client_id, 
                :title, 
                :industries, 
                :industry_keywords, 
                :naics, 
                :departments, 
                :employee_size_from,
                :employee_size_to, 
                :revenue_from,
                :revenue_to, 
                :company_attr,
                :company_attr_txt,
                :prospect_management_level, 
                :titles,
                :titles_keywords,
                :city, 
                :states, 
                :countries, 
                :geotarget,
                :geotarget_lat,
                :geotarget_lng,
                :radius,
                :link_notes,
                :status,
                :created_by,NOW())',
            [
                'client_id' => $_POST['client_id'],
                'title' => !empty($_POST['title']) ? $_POST['title'] : '',
                'industries' => !empty($_POST['industries']) ? implode(',', $_POST['industries']): '',
                'industry_keywords' => !empty($_POST['industry_keywords']) ? implode(',', $_POST['industry_keywords']): '',
                'naics' => !empty($_POST['naics']) ? $_POST['naics'] : '',
                'departments' => !empty($_POST['departments']) ? implode(',', $_POST['departments']): '',
                'employee_size_from' => !empty($_POST['employee_size_from']) ? $_POST['employee_size_from'] : '',
                'employee_size_to' => !empty($_POST['employee_size_to']) ? $_POST['employee_size_to'] : '',
                'revenue_from' => !empty($_POST['revenue_from']) ? $_POST['revenue_from'] : '',
                'revenue_to' => !empty($_POST['revenue_to']) ? $_POST['revenue_to'] : '',
                'company_attr' => !empty($_POST['company_attr']) ? $_POST['company_attr'] : '',
                'company_attr_txt' => !empty($_POST['company_attr_txt']) ? $_POST['company_attr_txt'] : '',
                'prospect_management_level' => !empty($_POST['prospect_management_level']) ? implode(',', $_POST['prospect_management_level']): '',
                'titles' => !empty($_POST['titles']) ? implode(',', $_POST['titles']): '',
                'titles_keywords' => !empty($_POST['titles_keywords']) ? implode(',', $_POST['titles_keywords']): '',
                'city' => !empty($_POST['city']) ? $_POST['city'] : '',
                'states' => !empty($_POST['states']) ? implode(',', $_POST['states']): '',
                'countries' => !empty($_POST['countries']) ? implode(',', $_POST['countries']): '',
                'geotarget' => !empty($_POST['geotarget']) ? $_POST['geotarget'] : '',
                'geotarget_lat' => !empty($_POST['geotarget_lat']) ? $_POST['geotarget_lat'] : '',
                'geotarget_lng' => !empty($_POST['geotarget_lng']) ? $_POST['geotarget_lng'] : '',
                'radius' => !empty($_POST['radius']) ? $_POST['radius'] : 0,
                'link_notes' => !empty($_POST['link_notes']) ? $_POST['link_notes'] : '',
                'status' => 'upcoming',
                'created_by' => Auth::token('userId')
            ]
        );

        if (!empty($_POST['save_profile']) AND $_POST['save_profile'] == 'yes') {
            $profile  = Db::fetch('SELECT * FROM `sap_client_targeting_profiles` WHERE `client_id` = :client_id', ['client_id'=>$_POST['client_id']]);

            if (!empty($profile)) {
                // Update
                try {
                    Db::query(
                        'UPDATE `sap_client_targeting_profiles`
                            SET `industries` = :industries, `industry_keywords` = :industry_keywords, `naics` = :naics,
                                `departments` = :departments, `employee_size_from` = :employee_size_from,  `employee_size_to` = :employee_size_to, 
                                `revenue_from` = :revenue_from,`revenue_to` = :revenue_to, `company_attr` = :company_attr, 
                                `company_attr_txt` = :company_attr_txt, `prospect_management_level` = :prospect_management_level,
                                `titles` = :titles,`titles_keywords` = :titles_keywords, `city` = :city, `states` = :states, `countries` = :countries,
                                `geotarget` = :geotarget, `geotarget_lat` = :geotarget_lat, `geotarget_lng` = :geotarget_lng, 
                                `radius` = :radius, `link_notes` = :link_notes,
                                `updated_at` = NOW()
                          WHERE `client_id` = :client_id',
                        [
                            'industries' => !empty($_POST['industries']) ? implode(',', $_POST['industries']): '',
                            'industry_keywords' => !empty($_POST['industry_keywords']) ? implode(',', $_POST['industry_keywords']): '',
                            'naics' => !empty($_POST['naics']) ? $_POST['naics'] : '',
                            'departments' => !empty($_POST['departments']) ? implode(',', $_POST['departments']): '',
                            'employee_size_from' => !empty($_POST['employee_size_from']) ? $_POST['employee_size_from'] : '',
                            'employee_size_to' => !empty($_POST['employee_size_to']) ? $_POST['employee_size_to'] : '',
                            'revenue_from' => !empty($_POST['revenue_from']) ? $_POST['revenue_from'] : '',
                            'revenue_to' => !empty($_POST['revenue_to']) ? $_POST['revenue_to'] : '',
                            'company_attr' => !empty($_POST['company_attr']) ? $_POST['company_attr'] : '',
                            'company_attr_txt' => !empty($_POST['company_attr_txt']) ? $_POST['company_attr_txt'] : '',
                            'prospect_management_level' => !empty($_POST['prospect_management_level']) ? implode(',', $_POST['prospect_management_level']): '',
                            'titles' => !empty($_POST['titles']) ? implode(',', $_POST['titles']): '',
                            'titles_keywords' => !empty($_POST['titles_keywords']) ? implode(',', $_POST['titles_keywords']): '',
                            'city' => !empty($_POST['city']) ? $_POST['city'] : '',
                            'states' => !empty($_POST['states']) ? implode(',', $_POST['states']): '',
                            'countries' => !empty($_POST['countries']) ? implode(',', $_POST['countries']): '',
                            'geotarget' => !empty($_POST['geotarget']) ? $_POST['geotarget'] : '',
                            'geotarget_lat' => !empty($_POST['geotarget_lat']) ? $_POST['geotarget_lat'] : '',
                            'geotarget_lng' => !empty($_POST['geotarget_lng']) ? $_POST['geotarget_lng'] : '',
                            'radius' => !empty($_POST['radius']) ? $_POST['radius'] : '',
                            'link_notes' => !empty($_POST['link_notes']) ? $_POST['link_notes'] : '',
                            'client_id' => !empty($_POST['client_id']) ? $_POST['client_id'] : ''
                        ]
                    );
                } catch (Exception $e) {
                    // if (false !== strpos($e->getMessage(), 'Duplicate')) {
                    //     Route::setFlash('danger', 'Email address already in use');
                    // } else {
                    //     Route::setFlash('danger', $e->getMessage());
                    // }
                    Route::setFlash('danger', $e->getMessage());
                    header('Location: /targeting-request');
                    exit;
                }
            } else {
                // Insert
                try {
                    $id = Db::insert(
                        'INSERT INTO `sap_client_targeting_profiles`
                                (`client_id`, 
                                `title`, 
                                `industries`, 
                                `industry_keywords`, 
                                `naics`, 
                                `departments`, 
                                `employee_size_from`,
                                `employee_size_to`, 
                                `revenue_from`,
                                `revenue_to`, 
                                `company_attr`,
                                `company_attr_txt`,
                                `prospect_management_level`, 
                                `titles`,
                                `titles_keywords`,
                                `city`, 
                                `states`, 
                                `countries`, 
                                `geotarget`,
                                `geotarget_lat`,
                                `geotarget_lng`,
                                `radius`,
                                `link_notes`,
                                `created_by`,
                                `created_at`
                                )
                        VALUES (:client_id, 
                            :title, 
                            :industries, 
                            :industry_keywords, 
                            :naics, 
                            :departments, 
                            :employee_size_from,
                            :employee_size_to, 
                            :revenue_from,
                            :revenue_to, 
                            :company_attr,
                            :company_attr_txt,
                            :prospect_management_level, 
                            :titles,
                            :titles_keywords,
                            :city, 
                            :states, 
                            :countries, 
                            :geotarget,
                            :geotarget_lat,
                            :geotarget_lng,
                            :radius,
                            :link_notes,
                            :created_by,NOW())',
                        [
                            'client_id' => $_POST['client_id'],
                            'title' => !empty($_POST['title']) ? $_POST['title'] : '',
                            'industries' => !empty($_POST['industries']) ? implode(',', $_POST['industries']): '',
                            'industry_keywords' => !empty($_POST['industry_keywords']) ? implode(',', $_POST['industry_keywords']): '',
                            'naics' => !empty($_POST['naics']) ? $_POST['naics'] : '',
                            'departments' => !empty($_POST['departments']) ? implode(',', $_POST['departments']): '',
                            'employee_size_from' => !empty($_POST['employee_size_from']) ? $_POST['employee_size_from'] : '',
                            'employee_size_to' => !empty($_POST['employee_size_to']) ? $_POST['employee_size_to'] : '',
                            'revenue_from' => !empty($_POST['revenue_from']) ? $_POST['revenue_from'] : '',
                            'revenue_to' => !empty($_POST['revenue_to']) ? $_POST['revenue_to'] : '',
                            'company_attr' => !empty($_POST['company_attr']) ? $_POST['company_attr'] : '',
                            'company_attr_txt' => !empty($_POST['company_attr_txt']) ? $_POST['company_attr_txt'] : '',
                            'prospect_management_level' => !empty($_POST['prospect_management_level']) ? implode(',', $_POST['prospect_management_level']): '',
                            'titles' => !empty($_POST['titles']) ? implode(',', $_POST['titles']): '',
                            'titles_keywords' => !empty($_POST['titles_keywords']) ? implode(',', $_POST['titles_keywords']): '',
                            'city' => !empty($_POST['city']) ? $_POST['city'] : '',
                            'states' => !empty($_POST['states']) ? implode(',', $_POST['states']): '',
                            'countries' => !empty($_POST['countries']) ? implode(',', $_POST['countries']): '',
                            'geotarget' => !empty($_POST['geotarget']) ? $_POST['geotarget'] : '',
                            'geotarget_lat' => !empty($_POST['geotarget_lat']) ? $_POST['geotarget_lat'] : '',
                            'geotarget_lng' => !empty($_POST['geotarget_lng']) ? $_POST['geotarget_lng'] : '',
                            'radius' => !empty($_POST['radius']) ? $_POST['radius'] : '',
                            'link_notes' => !empty($_POST['link_notes']) ? $_POST['link_notes'] : '',
                            'created_by' => Auth::token('userId'),
                        ]
                    );
                } catch (\Exception $e) {
                    echo $e->getMessage();
                    die;
                }
            }
        }

    } catch (\Exception $e) {
        echo $e->getMessage();
        die;
    }
    
    Route::setFlash('success', 'Targeting request added successfully');
    header('Location: /targeting-request');
    exit;    
} else {
    $client_id = !empty($_SESSION['client_id']) ? $_SESSION['client_id'] : '';
    $profile_data = !empty($_SESSION['profile_data']) ? $_SESSION['profile_data'] : '';
    $listRequestTitle = !empty($_SESSION['listRequestTitle']) ? $_SESSION['listRequestTitle'] : '';

    unset($_SESSION['listRequestTitle']);
    unset($_SESSION['client_id']);
    unset($_SESSION['profile_data']);

    if (empty($profile_data)) {
        $client_id = '';
        $profile_data['titles'] = '';
        $profile_data['countries'] = '';
        $profile_data['industries'] = '';
        $profile_data['industry_keywords'] = '';
        $profile_data['naics'] = '';
        $profile_data['departments'] = '';
        $profile_data['employee_size_from'] = '';
        $profile_data['employee_size_to'] = '';
        $profile_data['revenue_from'] = '';
        $profile_data['revenue_to'] = '';
        $profile_data['company_attr'] = '';
        $profile_data['company_attr_txt'] = '';
        $profile_data['company_att_value'] = '';
        $profile_data['prospect_management_level'] = '';
        $profile_data['titles_keywords'] = '';
        $profile_data['city'] = '';
        $profile_data['states'] = '';
        $profile_data['countries'] = '';
        $profile_data['geotarget'] = '';
        $profile_data['geotarget_lat'] = '';
        $profile_data['geotarget_lng'] = '';
        $profile_data['radius'] = '';
        $profile_data['link_notes'] = '';
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
    $clients      = Db::fetchAll('SELECT * FROM `sap_client` ORDER BY `name` ASC');
    $industries = Db::fetchAll(
        'SELECT * FROM `sap_prospect_industry` ORDER BY `name` ASC'
    );
    
    sapperView(
        'targeting-request',
        [
            'listRequestTitle'           => $listRequestTitle,
            'client_id'           => $client_id,
            'clients'           => $clients,
            'titles'           => $titles,
            'departments'      => $departments,           
            'industries'      => $industries,           
            'profile' => $profile_data,            
        ]
    );
}