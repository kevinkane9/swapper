<?php

use Sapper\Route,
    Sapper\Db,
    Sapper\Auth,
    Sapper\Util,
    Sapper\Mail;

switch (Route::uriParam('action')) {
    case 'create':
        try {
            $userId = Auth::token('userId');
            
                    $maxAssignments = 1000; //Sapper\Settings::get('max-requests-per-day');
            
                    if (!empty($_POST['assignedTo']) && !empty($_POST['dueDate'])) {
                        $assignments = Db::fetchColumn(
                            'SELECT COUNT(*) as `count`
                               FROM `sap_list_request`
                              WHERE `assigned_to` = :assigned_to AND `due_date` = :due_date',
                            [
                                'assigned_to' => $_POST['assignedTo'],
                                'due_date'    => Util::convertDate($_POST['dueDate'])
                            ],
                            'count'
                        );
            
                        if ($assignments >= $maxAssignments) {
                            jsonError(
                                ['message' => 'User has reached the maximum allowed # of list requests for that date']
                            );
                        }
                    }
            
                    $clientName = Db::fetchColumn(
                        'SELECT c.*
                               FROM `sap_client` c
                          LEFT JOIN `sap_client_account_outreach` cao ON cao.`client_id` = c.`id`
                              WHERE cao.`id` = :id',
                        ['id' => $_POST['outreachAccountId']],
                        'name'
                    );
            
                    $title = ltrim(str_replace($clientName, '', $_POST['title']));
            
                    $matches = [];
                    if (1 == preg_match('/([^\(]*)\s\(/', $title, $matches)) {
                        Db::query(
                            'UPDATE `sap_client_account_outreach` SET `request_index` = :request_index WHERE `id` = :id',
                            [
                                'request_index' => $matches[1] + 1,
                                'id'            => $_POST['outreachAccountId']
                            ]
                        );
                    }
            
                    switch($_POST['type']) {
                        case 'new':                
                            if (isset($_POST['searchCriteria'])) {
                                $search_criteria = $_POST['searchCriteria'];
                            } else {
                                $search_criteria = json_encode([
                                                        'sourceId'    => $_POST['sourceId'],
                                                        'companyId'   => $_POST['companyId'],
                                                        'industries'  => $_POST['industries'],
                                                        'titles'      => $_POST['titles'],
                                                        'departments' => $_POST['departments'],
                                                        'countries'   => $_POST['countries'],
                                                        'geotarget'   => $_POST['geotarget'],
                                                        'radius'      => $_POST['radius'] ?: 50,
                                                        'states'      => $_POST['states']
                                                    ]);
                            }
                                
                            $requestId = Db::insert(
                                'INSERT INTO `sap_list_request` (`type`, `status`, `created_by`,
                                              `title`, `assigned_to`, `outreach_account_id`, `due_date`, `description`, `data`)
                                      VALUES ("new", :status, :created_by, :title, :assigned_to, :outreach_account_id, :due_date, :description, :data)',
                                [
                                    'status'              => !empty($_POST['status']) ? $_POST['status'] : 'new',
                                    'created_by'          => $userId,
                                    'title'               => !empty($_POST['title']) ? $_POST['title'] : null,
                                    'assigned_to'         => !empty($_POST['assignedTo']) ? $_POST['assignedTo'] : null,
                                    'outreach_account_id' => $_POST['outreachAccountId'],
                                    'due_date'            => !empty($_POST['dueDate']) ? Util::convertDate($_POST['dueDate']) : null,
                                    'description'         => !empty($_POST['description']) ? $_POST['description'] : null,
                                    'data'                => $search_criteria
                                ]
                            );
                            
                            if (!empty($requestId) AND !empty($_POST['downloadFilteredId'])) {
                                Db::query(
                                    'UPDATE `sap_list_request` SET `status` = :status, `download_filtered_id` = :download_filtered_id WHERE `id` = :id',
                                    [
                                        'status'            => 'awaiting import',
                                        'download_filtered_id'            => $_POST['downloadFilteredId'],
                                        'id'            => $requestId,
                                    ]
                                );
                                
                                Db::query(
                                    'UPDATE `sap_download_filtered` SET `list_request_id` = :list_request_id WHERE `id` = :id',
                                    [
                                        'list_request_id'            => $requestId,
                                        'id'            => $_POST['downloadFilteredId'],
                                    ]
                                );
                            }
                            
                            break;
            
                        case 'recycled':
                            $requestId = Db::insert(
                                'INSERT INTO `sap_list_request` (`type`, `created_by`,
                                             `title`, `assigned_to`, `outreach_account_id`, `due_date`, `description`)
                                      VALUES ("recycled", :created_by, :title, :assigned_to, :outreach_account_id, :due_date, :description)',
                                [
                                    'created_by'          => $userId,
                                    'title'               => !empty($_POST['title']) ? $_POST['title'] : null,
                                    'assigned_to'         => !empty($_POST['assignedTo']) ? $_POST['assignedTo'] : null,
                                    'outreach_account_id' => $_POST['outreachAccountId'],
                                    'due_date'            => !empty($_POST['dueDate']) ? Util::convertDate($_POST['dueDate']) : null,
                                    'description'         => !empty($_POST['description']) ? $_POST['description'] : null,
                                ]
                            );
            
                            foreach ($_POST['prospectIds'] as $prospectId) {
                                Db::insert(
                                    'INSERT INTO `sap_list_request_prospect` (`list_request_id`, `prospect_id`)
                                          VALUES (:list_request_id, :prospect_id)',
                                    [
                                        'list_request_id' => $requestId,
                                        'prospect_id'     => $prospectId
                                    ]
                                );
                            }
                            break;
                    }
            
                    if (!empty($_POST['assignedTo'])) {
                        $assignedBy = Db::fetch(
                            'SELECT * FROM `sap_user` WHERE `id` = :id',
                            ['id' => $userId]
                        );
            
                        $assignedTo = Db::fetch(
                            'SELECT * FROM `sap_user` WHERE `id` = :id',
                            ['id' => $_POST['assignedTo']]
                        );
            
                        $params = [
                            'assignedBy'  => $assignedBy['first_name'] . ' ' . $assignedBy['last_name'],
                            'type'        => ucwords($_POST['type']),
                            'requestName' => $_POST['title'] ?: null,
                            'firstName'   => $assignedTo['first_name'] ?: $assignedTo['email'],
                            'clientName'  => $clientName
                        ];
            
                        if (!empty($_POST['dueDate'])) {
                            $params['dueDate'] = $_POST['dueDate'];
                        }
            
                        if (!empty($_POST['description'])) {
                            $params['description'] = $_POST['description'];
                        }
            
                        Mail::send(
                            'assigned-list-request',
                            ['noreply@sappersuite.com', 'Sapper Suite'],
                            [$assignedTo['email'], $assignedTo['first_name'] . ' ' . $assignedTo['last_name']],
                            'List Request assigned to you',
                            $params
                        );
                    }
                    jsonSuccess();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        break;

    case 'comment':
        $commentId = Db::insert(
            'INSERT INTO `sap_list_request_comment` (`list_request_id`, `comment`, `created_by`)
                  VALUES (:list_request_id, :comment, :created_by)',
            [
                'list_request_id' => $_POST['listRequestId'],
                'comment'         => $_POST['comment'],
                'created_by'      => Sapper\Auth::token('userId')
            ]
        );

        $comment = Db::fetch(
            'SELECT lrc.*, u.`first_name`, u.`last_name`
                   FROM     `sap_list_request_comment` lrc
              LEFT JOIN     `sap_user` u ON lrc.`created_by` = u.`id`
                  WHERE lrc.`id` = :id',
            ['id' => $commentId]
        );

        $comment['created_at'] = date('M j, Y h:ia', strtotime($comment['created_at']));
        $comment['comment']    = str_replace("\n", '<br>', $comment['comment']);

        jsonSuccess($comment);
        break;

    case 'success':
        sapperView('list-request-success');
        break;
}
