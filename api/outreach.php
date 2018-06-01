<?php

namespace Sapper\Api;

class Outreach {

    const CLIENT_ID   = 'af87bb90cbc49e042b60938929b7bf8ee872b71d9e1b4b03e9cb99e0398ab6f5',
        CLIENT_SECRET = '7da10a83cefe59dcbcf2511c7faacef88c2c0339d0eaa90b0cf4cf9e6937b44e',

        URL_AUTH      = 'https://api.outreach.io/oauth/token',
        URL_REST      = 'https://api.outreach.io/1.0/',
        URL_REST_v2      = 'https://api.outreach.io/api/v2/';

    private static function getLog($accountId) {
        if (!is_dir(__DIR__ . '/outreach_log/' . date('Y-m-d'))) {
            mkdir (__DIR__ . '/outreach_log/' . date('Y-m-d'));
        }

        $logFile = __DIR__ . '/outreach_log/' . date('Y-m-d') . '/' . $accountId . '.log';
        if (!file_exists($logFile)) {
            $fh = fopen($logFile, 'w');
            fputcsv(
                $fh,
                ['Timestamp', 'Account', 'Service', 'Type', 'Method', 'Code', 'Response', 'Rows Received', 'Total Rows']
            );
            return $fh;
        } else {
            return fopen($logFile, 'a');
        }
    }

    private static function getRedirectUri() {
        return APP_ROOT_URL . '/outreach/oauth';
    }

    public static function getAuthUrl($accountId) {
        return 'https://api.outreach.io/oauth/authorize?client_id=' . self::CLIENT_ID .'&redirect_uri=' .
            urlencode(self::getRedirectUri()) . '&response_type=code&scope=accounts.all+callDispositions.all+'
                      .'callPurposes.all+calls.all+customDuties.all+duties.all+events.all+mailboxes.all+mailings.all+personas.all+'
                      .'phoneNumbers.all+prospects.all+rulesets.all+sequenceStates.all+sequenceSteps.all+'
                      .'sequenceTemplates.all+sequences.all+snippets.all+stages.all+taskPriorities.all+'
                      .'tasks.all+teams.all+templates.all+users.all+webhooks.all'

                    // v1 scopes
                        .'+create_prospects+read_prospects' .
            '+update_prospects+read_sequences+update_sequences+read_tags+read_accounts+create_accounts+read_activities' .
            '+read_mailings+read_mappings+read_plugins+read_users+create_calls+read_calls+read_call_purposes' .
            '+read_call_dispositions'

            .'&state=' . $accountId;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public static function getAccessToken($authCode) {
        $requestParams = [
            'client_id'     => self::CLIENT_ID,
            'client_secret' => self::CLIENT_SECRET,
            'redirect_uri'  => self::getRedirectUri(),
            'grant_type'    => 'authorization_code',
            'code'          => $authCode
        ];

        return self::call(null, $requestParams, null, 'post', self::URL_AUTH);
    }

    public static function refreshAccessToken($refreshToken) {

        $requestParams = [
            'client_id'     => self::CLIENT_ID,
            'client_secret' => self::CLIENT_SECRET,
            'redirect_uri'  => self::getRedirectUri(),
            'grant_type'    => 'refresh_token',
            'refresh_token' => $refreshToken
        ];

        return self::call(null, $requestParams, null, 'post', self::URL_AUTH);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public static function call($service, $requestParams, $token, $method, $url = self::URL_REST, $rs = false) {
        if ($url == self::URL_REST_v2) {
            ### Outreach API V2 Call ###
            if (!in_array($method, ['get', 'post', 'patch'])) {
                throw new \Exception('Unknown HTTP method: ' . $method);
            } elseif (self::URL_AUTH !== $url && empty($token)) {
                throw new \Exception('Missing access token');
            }

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            curl_setopt($curl, CURLINFO_HEADER_OUT, true);

            switch ($method) {
                case 'get':
                    curl_setopt($curl, CURLOPT_POST, 0);
                    curl_setopt($curl, CURLOPT_HTTPGET, 1);
                    break;

                case 'post':
                    if (is_array($requestParams)) {
                        curl_setopt($curl, CURLOPT_POST, count($requestParams));
                        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($requestParams));
                    } elseif (is_string($requestParams)) {
                        curl_setopt($curl, CURLOPT_POST, true);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $requestParams);
                    } else {
                        throw new \Exception('Unacceptable request parameters format');
                    }
                    break;

                case 'patch':
                    if (is_array($requestParams)) {
                        curl_setopt($curl, CURLOPT_POST, count($requestParams));
                        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
                        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($requestParams));
                    } elseif (is_string($requestParams)) {
                        curl_setopt($curl, CURLOPT_POST, true);
                        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $requestParams);
                    } else {
                        throw new \Exception('Unacceptable request parameters format');
                    }
                    break;

                default:
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($method));
                    if (is_array($requestParams)) {
                        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($requestParams));
                    } elseif (is_string($requestParams)) {
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $requestParams);
                    }
                    break;
            }

            if (self::URL_REST_v2 == $url) {
                curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token, 'Content-Type: application/json']);

                $url .= $service;

                if ('get' == $method) {
                    $url .= '?' . http_build_query($requestParams);
                }
            }

            curl_setopt($curl, CURLOPT_URL, $url);

            if (null !== $token) {
                $accountId = \Sapper\Db::fetchColumn(
                    'SELECT * FROM `sap_client_account_outreach` WHERE `access_token` = :access_token',
                    ['access_token' => $token],
                    'id'
                );
                if ($accountId) {
                    $log = self::getLog($accountId);

                    fputcsv(
                        $log,
                        [
                            date('Y-m-d H:i:s'),
                            $accountId,
                            $service,
                            'Request',
                            $method,
                            '',
                            ''
                        ]
                    );
                }
            }

            $attempts = 0;

            doAttempt:
            $attempts++;

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if (504 == $httpCode&& $attempts < 3) {
                sleep(5);
                goto doAttempt;
            } elseif (2 == substr($httpCode, 0, 1)) {

                $response = json_decode($response, true);

                if (isset($log)) {
                    $page    = \Sapper\Util::val($response, ['meta', 'page', 'current']) ?: 1;
                    $entries = \Sapper\Util::val($response, ['meta', 'page', 'entries']) ?: 1;
                    $perPage = \Sapper\Util::val($response, ['meta', 'page', 'maximum']) ?: 1;
                    $rowsReceived  = ($perPage*($page-1)) + $entries ?: 0;
                    $totalRows     = \Sapper\Util::val($response, ['meta', 'results', 'total']) ?: 0;

                    fputcsv(
                        $log,
                        [
                            date('Y-m-d H:i:s'),
                            $accountId,
                            $service,
                            'Response',
                            $method,
                            $httpCode,
                            '', //$rawResponse,
                            $rowsReceived,
                            $totalRows
                        ]
                    );
                }
                $return = ['status' => 'success', 'data' => $response];
            } else {
                if (isset($log)) {
                    fputcsv(
                        $log,
                        [
                            date('Y-m-d H:i:s'),
                            $accountId,
                            $service,
                            'Response',
                            $method,
                            $httpCode,
                            $response,
                            '',
                            ''
                        ]
                    );
                }
                $return = ['status' => 'error', 'error' => $response];
            }

            if (isset($log)) {
                fclose($log);
            }
            return $return;
        } else {
            ### Outreach API V1 Call ###
            if (!in_array($method, ['get', 'post', 'patch'])) {
                throw new \Exception('Unknown HTTP method: ' . $method);
            } elseif (self::URL_AUTH !== $url && empty($token)) {
                throw new \Exception('Missing access token');
            }

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            switch ($method) {
                case 'get':
                    curl_setopt($curl, CURLOPT_POST, 0);
                    curl_setopt($curl, CURLOPT_HTTPGET, 1);
                    break;

                case 'post':
                    if (is_array($requestParams)) {
                        curl_setopt($curl, CURLOPT_POST, count($requestParams));
                        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($requestParams));
                    } elseif (is_string($requestParams)) {
                        curl_setopt($curl, CURLOPT_POST, true);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $requestParams);
                    } else {
                        throw new \Exception('Unacceptable request parameters format');
                    }
                    break;

                default:
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($method));
                    if (is_array($requestParams)) {
                        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($requestParams));
                    } elseif (is_string($requestParams)) {
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $requestParams);
                    }
                    break;
            }

            if (self::URL_REST == $url) {
                curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token, 'Content-Type: application/json']);

                $url .= $service;

                if ('get' == $method) {
                    $url .= '?' . http_build_query($requestParams);
                }
            }

            curl_setopt($curl, CURLOPT_URL, $url);

            if (null !== $token) {
                $accountId = \Sapper\Db::fetchColumn(
                    'SELECT * FROM `sap_client_account_outreach` WHERE `access_token` = :access_token',
                    ['access_token' => $token],
                    'id'
                );
                if ($accountId) {
                    $log = self::getLog($accountId);

                    fputcsv(
                        $log,
                        [
                            date('Y-m-d H:i:s'),
                            $accountId,
                            $service,
                            'Request',
                            $method,
                            '',
                            ''
                        ]
                    );
                }
            }

            $attempts = 0;

            doAttempt_v2:
            $attempts++;

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if (504 == $httpCode&& $attempts < 3) {
                goto doAttempt_v2;
            } elseif (200 == $httpCode) {

                if (!$rs) {
                    $response = json_decode($response, true);
                }

                if (isset($log)) {
                    $page    = \Sapper\Util::val($response, ['meta', 'page', 'current']) ?: 1;
                    $entries = \Sapper\Util::val($response, ['meta', 'page', 'entries']) ?: 1;
                    $perPage = \Sapper\Util::val($response, ['meta', 'page', 'maximum']) ?: 1;
                    $rowsReceived  = ($perPage*($page-1)) + $entries ?: 0;
                    $totalRows     = \Sapper\Util::val($response, ['meta', 'results', 'total']) ?: 0;

                    fputcsv(
                        $log,
                        [
                            date('Y-m-d H:i:s'),
                            $accountId,
                            $service,
                            'Response',
                            $method,
                            $httpCode,
                            '', //$rawResponse,
                            $rowsReceived,
                            $totalRows
                        ]
                    );
                }
                $return = ['status' => 'success', 'data' => $response];
            } else {
                if (isset($log)) {
                    fputcsv(
                        $log,
                        [
                            date('Y-m-d H:i:s'),
                            $accountId,
                            $service,
                            'Response',
                            $method,
                            $httpCode,
                            $response,
                            '',
                            ''
                        ]
                    );
                }
                $return = ['status' => 'error', 'error' => $response];
            }

            if (isset($log)) {
                fclose($log);
            }

            return $return;
        }
    }
}
