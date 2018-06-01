<?php

use Sapper\Db,
    Sapper\Route;

if (Route::uriParam('action')) {
    switch (Route::uriParam('action')) {
        case 'kill':
            // For security reasons, we don't pass pid in the url, otherwise, people will be able to kill
            // whatever process they want in the server
            $id = Route::uriParam('id');
            $pid = Db::fetchColumn(
                'SELECT * FROM `sap_background_job` WHERE `id` = :id',
                ['id' => $id],
                'pid'
            );

            // The cron script `/cron/process-manager.php` will make the actual killing of the process
            // to avoid granting permission to www-data to kill a process
            touch (__DIR__. '/../upload/.kill-process-' . $pid);

            Db::query(
                'Update `sap_background_job` set `status` = "killed" WHERE `id` = :id',
                ['id' => $id]
            );

            Route::setFlash('success', 'Background job is killed');
            header('Location: /background-jobs');
            break;
    }
} else {
    // list of background jobs whose status is processing
    $jobs = Db::fetchAll('SELECT * FROM `sap_background_job` WHERE `status` = "processing"');

    foreach ($jobs as $key => $job) {
        $data = json_decode($job['data'], true);

        // Define default values to avoid php warning when the value is not needed for a specific type
        $jobs[$key]['title'] = '';
        $jobs[$key]['filename'] = '';
        $jobs[$key]['client'] = '';
        $jobs[$key]['type'] = $data['type'];

        switch ($data['type']) {
            case 'normaliz-csv-filtered':
                $jobs[$key]['filename'] = getFilename($data['download_id']);
                break;

            case 'list_request':
                $listRequest = getListRequest($data['list_request_id']);

                $jobs[$key]['title'] = $listRequest['title'];
                $jobs[$key]['client'] = $listRequest['name'];
                break;
            case 'upload-normalized-csv':
                $jobs[$key]['filename'] = getFilename($data['download_id']);
                $jobs[$key]['client'] = getClientName($data['outreach_account_id']);
                break;

            case 'upload-normalized-csv-filtered':
                $jobs[$key]['filename'] = getFilename($data['download_filtered_id']);
                $listRequest = getListRequest($data['list_request_id']);

                $jobs[$key]['title'] = $listRequest['title'];
                $jobs[$key]['client'] = $listRequest['name'];
                break;

            default:
                break;
        }
    }

    sapperView('background-jobs', ['jobs' => $jobs]);
}

function getFilename($download_id)
{
    $filename = Db::fetchColumn(
        'SELECT * FROM `sap_download_filtered` WHERE `id` = :id',
        ['id' => $download_id],
        'filename'
    );

    return $filename;
}

function getClientName($outreach_account_id)
{
    $clientName = Db::fetchColumn(
        'SELECT * FROM `sap_client` c
                     JOIN `sap_client_account_outreach` o ON  c.id = o.client_id
                     WHERE o.id = :id',
        ['id' => $outreach_account_id],
        'name'
    );

    return $clientName;
}

function getListRequest($list_request_id)
{
    $listRequest = Db::fetch(
        'SELECT * FROM `sap_client` c
         JOIN `sap_client_account_outreach` o ON  c.id = o.client_id
         JOIN `sap_list_request` r ON o.id = r.outreach_account_id
         WHERE r.id = :id',
        ['id' => $list_request_id]
    );

    return $listRequest;
}
