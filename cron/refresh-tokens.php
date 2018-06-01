<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

use Sapper\Api\Outreach;
use Sapper\Db;
use Sapper\Mail;
use Sapper\Settings;

require_once(__DIR__ . '/../init.php');

// outreach accounts
if (array_key_exists(1, $argv)) {
    $accountId = $argv[1];
    $accounts = Db::fetchAll(
        'SELECT * FROM `sap_client_account_outreach` WHERE `id` = :id',
        ['id' => $accountId]
    );
} else {
    $accounts = Db::fetchAll(
        'SELECT * FROM `sap_client_account_outreach` WHERE (`status` != "disconnected" OR `disconnect_reason` IS NOT NULL) AND `token_expires` < :token_expires',
        ['token_expires' => time() + 3600]
    );
}

foreach ($accounts as $account) {
    $response  = Outreach::refreshAccessToken($account['refresh_token']);

    if ('success' == $response['status']) {
        Db::query(
            'UPDATE `sap_client_account_outreach`
                    SET `access_token` = :access_token, `refresh_token` = :refresh_token, `token_expires` = :token_expires
                  WHERE `id` = :id',
            [
                'access_token'  => $response['data']['access_token'],
                'refresh_token' => $response['data']['refresh_token'],
                'token_expires' => time() + $response['data']['expires_in'],
                'id'            => $account['id']
            ]
        );

        if ('disconnected' == $account['status']) {
            Db::query(
                'UPDATE `sap_client_account_outreach`
                            SET `status` = "connected", `disconnect_reason` = NULL
                          WHERE `id` = :id',
                ['id' => $account['id']]
            );
        }
    } else {

        // try a 2nd time
        $response  = Outreach::refreshAccessToken($account['refresh_token']);

        if ('success' == $response['status']) {
            Db::query(
                'UPDATE `sap_client_account_outreach`
                    SET `access_token` = :access_token, `refresh_token` = :refresh_token, `token_expires` = :token_expires
                  WHERE `id` = :id',
                [
                    'access_token'  => $response['data']['access_token'],
                    'refresh_token' => $response['data']['refresh_token'],
                    'token_expires' => time() + $response['data']['expires_in'],
                    'id'            => $account['id']
                ]
            );

            if ('disconnected' == $account['status']) {
                Db::query(
                    'UPDATE `sap_client_account_outreach`
                            SET `status` = "connected", `disconnect_reason` = NULL
                          WHERE `id` = :id',
                    ['id' => $account['id']]
                );
            }
        } else {

            // try a 3rd time
            $response  = Outreach::refreshAccessToken($account['refresh_token']);

            if ('success' == $response['status']) {
                Db::query(
                    'UPDATE `sap_client_account_outreach`
                    SET `access_token` = :access_token, `refresh_token` = :refresh_token, `token_expires` = :token_expires
                  WHERE `id` = :id',
                    [
                        'access_token'  => $response['data']['access_token'],
                        'refresh_token' => $response['data']['refresh_token'],
                        'token_expires' => time() + $response['data']['expires_in'],
                        'id'            => $account['id']
                    ]
                );

                if ('disconnected' == $account['status']) {
                    Db::query(
                        'UPDATE `sap_client_account_outreach`
                            SET `status` = "connected", `disconnect_reason` = NULL
                          WHERE `id` = :id',
                        ['id' => $account['id']]
                    );
                }
            } else {
                Db::query(
                    'UPDATE `sap_client_account_outreach`
                SET `status` = "disconnected", `disconnect_reason` = :disconnect_reason
              WHERE `id` = :id',
                    [
                        'disconnect_reason' => $response['error'],
                        'id' => $account['id']
                    ]
                );

                // send disconnection notification
                if ($account['token_expires'] < (time() - 60*60*2)) {
                    $client = Db::fetch(
                        'SELECT * FROM `sap_client` WHERE `id` = :id',
                        ['id' => $account['client_id']]
                    );

                    if (1 == Settings::get('disconnect-notifications')) {
                        $emails = explode(',', Settings::get('email-notifications'));

                        foreach ($emails as $email) {
                            $email = trim($email);

                            Mail::send(
                                'outreach-account-disconnected',
                                ['noreply@sappersuite.com', 'Sapper Suite'],
                                [$email, $email],
                                'Outreach Account Disconnected',
                                [
                                    'clientName'   => $client['name'],
                                    'accountEmail' => $account['email']
                                ]
                            );
                        }
                    }
                }
            }
        }
    }
}
