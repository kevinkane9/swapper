<?php

use Sapper\Route,
    Sapper\Db,
    Sapper\Api\Outreach;

switch (Route::uriParam('action')) {

    case 'link-account':
        try {
            $clientId = Route::uriParam('client_id');

            Db::insert(
                'INSERT INTO `sap_client_account_outreach` (`client_id`, `email`) VALUES (:client_id, :email)',
                [$clientId, $_POST['email']]
            );
            Route::setFlash('success', 'Account successfully linked');
        } catch (Exception $e) {
            if (false !== strpos($e->getMessage(), 'Duplicate')) {
                Route::setFlash('danger', 'Account already linked');
            }
        }

        header('Location: /clients/edit/' . $clientId);
        break;

    case 'pre-oauth':
        $accountId = Route::uriParam('accountId');
        if (empty($accountId)) {
            throw new \Exception('Missing accountId');
        }
        header('Location: ' . Outreach::getAuthUrl($accountId));
        exit;
        break;

    case 'oauth':
        $code = Route::uriParam('code');
        if (empty($code)) {
            throw new \Exception('Missing Authorization code');
        }
        
        $accountId = Route::uriParam('account_id');
        $response  = Outreach::getAccessToken($code);

        if ('success' == $response['status']) {

            $info = Outreach::call('info', [], $response['data']['access_token'], 'get');
            
            if ('success' == $info['status']) {

                $account = Db::fetch(
                    'SELECT * FROM `sap_client_account_outreach` WHERE `id` = :id',
                    ['id' => $accountId]
                );
                if (strtolower($info['data']['meta']['user']['email']) == strtolower($account['email'])) {
                    Db::query(
                        'UPDATE `sap_client_account_outreach`
                    SET `access_token` = :access_token, `refresh_token` = :refresh_token,
                        `token_expires` = :token_expires, `status` = "connected", `status_v2` = "connected",
                        `disconnect_reason` = null
                  WHERE `id` = :id',
                        [
                            'access_token'  => $response['data']['access_token'],
                            'refresh_token' => $response['data']['refresh_token'],
                            'token_expires' => time() + $response['data']['expires_in'],
                            'id'            => $accountId
                        ]
                    );
                    Route::setFlash('success', 'Outreach account successfully authorized');
                } else {
                    Route::setFlash('danger', 'You were not logged into the correct Outreach account');
                }
            } else {
                Route::setFlash('danger', 'An error occurred: ' . $info['error']);
            }
        } else {
            Route::setFlash('danger', 'An error occurred: ' . $response['error']);
        }

        //redirect back to client edit
        $clientId = Db::fetchColumn(
            'SELECT `client_id` FROM `sap_client_account_outreach` WHERE `id` = :id',
            ['id' => $accountId],
            'client_id'
        );
        header('Location: /clients/edit/' . $clientId);
        exit;
        break;

    case 'sync':
        $accountId = Route::uriParam('accountId');
        $account   = Db::fetch(
            'SELECT * FROM `sap_client_account_outreach` WHERE `id` = :id',
            ['id' => $accountId]
        );

        exec($GLOBALS['sapper-env']['PATH_TO_PHP'] . 'php ' . APP_ROOT_PATH . '/cron/sync-prospects.php ' . $accountId . '  > /dev/null 2>&1 &');

        header('Location: /clients/edit/' . $account['client_id']);
        break;

    case 'delete':
        $accountId = Route::uriParam('accountId');
        $account   = Db::fetch(
            'SELECT * FROM `sap_client_account_outreach` WHERE `id` = :id',
            ['id' => $accountId]
        );

        try {
            Db::query(
                'DELETE FROM `sap_client_account_outreach` WHERE `id` = :id',
                ['id' => $accountId]
            );
            Route::setFlash('success', 'Outreach account ' . $account['email'] . ' deleted');
        } catch (\Exception $e) {
            Route::setFlash('danger', 'An error occurred: ' . $e->getMessage());
        }

        header('Location: /clients/edit/' . $account['client_id']);
        break;

    default:
        throw new \Exception('Unknown action: ' . Route::uriParam('action'));
        break;
}