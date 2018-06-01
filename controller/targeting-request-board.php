<?php

use Sapper\Route,
 Sapper\Util,
    Sapper\Db;

switch (Route::uriParam('action')) {
    case 'view':  
        $client_id = !empty($_SESSION['client_id']) ? $_SESSION['client_id'] : '';
        $status = !empty($_SESSION['status']) ? $_SESSION['status'] : '';
        $sort_by_created_date = !empty($_SESSION['sort_by_created_date']) ? true : false;

        unset($_SESSION['client_id']);
        unset($_SESSION['status']);
        unset($_SESSION['sort_by_created_date']);
        
        $sql = "SELECT r.*, c.id as client_id, c.name as client_name, CONCAT(u.first_name,' ',u.last_name) AS user_name  FROM `sap_client_targeting_requests` r 
        LEFT JOIN sap_client c 
        ON r.client_id = c.id
        LEFT JOIN sap_user u 
        ON r.created_by = u.id";

        $sql .= " WHERE '' = ''";

        if (!empty($client_id)) {
            $sql .= " AND client_id = $client_id ";
        }

        if (!empty($status)) {
            $sql .= " AND r.`status` = '$status' ";
        }
        
        if (!empty($sort_by_created_date)) {
            $sql .= " ORDER BY `created_at` DESC ";
        }

        $requests = Db::fetchAll($sql);


        $sql = "SELECT r.*, c.id as client_id, c.name as client_name, CONCAT(u.first_name,' ',u.last_name) AS user_name  FROM `sap_client_targeting_requests` r 
        LEFT JOIN sap_client c 
        ON r.client_id = c.id
        LEFT JOIN sap_user u 
        ON r.created_by = u.id";

        $client_requests = Db::fetchAll($sql);
        $newRequestClients = [];
        if (!empty($client_requests)) {
            foreach ($client_requests as $request) {
                $newRequestClients[$request['client_id']] = $request['client_name'];
            }
        }


        $requests_arr = [];

        foreach ($requests as $request) {
            $request['comments'] = Db::fetchAll(
                'SELECT lrc.*, u.`first_name`, u.`last_name`
                   FROM     `sap_targeting_request_comment` lrc
              LEFT JOIN     `sap_user` u ON lrc.`created_by` = u.`id`
                  WHERE lrc.`list_request_id` = :list_request_id
               ORDER BY lrc.`created_at` DESC',
                ['list_request_id' => $request['request_id']]);

                $request['num_comments'] = count($request['comments']);                 

                $requests_arr[] = $request;
        }       

        sapperView(
            'targeting-request-board',
            [
                'status' => $status,
                'client_id' => $client_id,
                'sort_by_created_date' => $sort_by_created_date,
                'requests' => $requests_arr,
                'newRequestClients' => $newRequestClients,
            ]
        );
        break;

    case 'ajax-set-session-data':
        $_SESSION['client_id'] = !empty($_POST['client_id']) ? $_POST['client_id'] : '';
        $_SESSION['status'] = !empty($_POST['status']) ? $_POST['status'] : '';
        $_SESSION['sort_by_created_date'] = !empty($_POST['sort_by_created_date']) ? true : false;

        exit;
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

    case 'sort':
        Db::query(
            'UPDATE `sap_client_targeting_requests` SET `sort_order` = NULL WHERE `type` = :type',
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
    case 'update-status':
        Db::query(
            'UPDATE `sap_client_targeting_requests`
                SET `status` = :status, `updated_at` = NOW()
              WHERE `request_id` = :id',
            [
                'status' => $_POST['status'],
                'id' => $_POST['id']
            ]
        );
        jsonSuccess();
        break;

    case 'delete':
        Db::query(
            'DELETE FROM `sap_client_targeting_requests` WHERE `request_id` = :id',
            ['id' => $_POST['id']]
        );
        jsonSuccess();
        break;      

    case 'success':
        sapperView('board-success');
        break;

    default:
        throw new Exception('Unknown action');
        break;
}
