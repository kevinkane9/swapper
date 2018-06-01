<?php
/**
 * Get authentication code
 * https://api.outreach.io/oauth/authorize?client_id=af87bb90cbc49e042b60938929b7bf8ee872b71d9e1b4b03e9cb99e0398ab6f5&redirect_uri=https%3A%2F%2Fwww.sapper.local%2Foutreach-oauth.php&response_type=code&scope=create_prospects+read_prospects+update_prospects+read_sequences+update_sequences+read_tags+read_accounts+create_accounts+read_activities+read_mailings+read_mappings+read_plugins+read_users+create_calls+read_calls+read_call_purposes+read_call_dispositions
 * 
 */

$clientId     = 'af87bb90cbc49e042b60938929b7bf8ee872b71d9e1b4b03e9cb99e0398ab6f5';
$clientSecret = '7da10a83cefe59dcbcf2511c7faacef88c2c0339d0eaa90b0cf4cf9e6937b44e';
$redirectUri  = 'https://www.sapper.local/outreach-oauth.php';

if (isset($_GET['step']) && $_GET['step'] == 1) {

    $curl   = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $requestParams = [
        'client_id'     => $clientId,
        'client_secret' => $clientSecret,
        'redirect_uri'  => $redirectUri,
        'grant_type'    => 'authorization_code',
        'code'          => '1f8b67e4105a32af2a3c728acd0bdcc1e503245971e59e36587f8293e4546f0f'
    ];
    $params = '';

    foreach($requestParams as $key => $val)
    {
        switch (gettype($val)) {
            case 'integer':
            case 'string':
                $params .= $key . '=' . urlencode($val) . '&';
                break;
            case 'array':
                foreach ($val as $valVal) {
                    $params .= $key . '=' . urlencode($valVal) . '&';
                }
                break;
        }
    }

    curl_setopt($curl, CURLOPT_VERBOSE, 1);
    curl_setopt($curl, CURLOPT_HEADER, 1);
    curl_setopt($curl, CURLOPT_POST, count($requestParams));
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($requestParams));

    curl_setopt($curl, CURLOPT_URL, 'https://api.outreach.io/oauth/token');
    curl_setopt($curl, CURLINFO_HEADER_OUT, true);

    $response = curl_exec($curl);

    echo '<pre>', print_r($response, true); exit;
} elseif (isset($_GET['step']) && $_GET['step'] == 2) {
    $curl   = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $token = 'c2f4408e6582ca1af85e11338666290bf69c0a8d05d3d227c7aeb193d250c9a1';

    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token]);

    //curl_setopt($curl, CURLOPT_URL, 'https://api.outreach.io/1.0/prospects?page[size]=5&page[number]=500');
    curl_setopt($curl, CURLOPT_URL, 'https://api.outreach.io/1.0/activities?filter[prospect/id]=137&page[size]=5');
    //curl_setopt($curl, CURLOPT_URL, 'https://api.outreach.io/1.0/accounts?page[size]=10');
    //curl_setopt($curl, CURLOPT_URL, 'https://api.outreach.io/1.0/users');
    //curl_setopt($curl, CURLOPT_URL, 'https://api.outreach.io/1.0/sequences');
    curl_setopt($curl, CURLINFO_HEADER_OUT, true);

    $response = curl_exec($curl);

    $response = json_decode($response, true);

    echo '<pre>', print_r($response, true); exit;
}

// Db::query(
// 'UPDATE `sap_client_account_outreach`
// SET `access_token` = :access_token, `refresh_token` = :refresh_token,
        // `token_expires` = :token_expires, `status` = "connected", `disconnect_reason` = null
// WHERE `id` = :id',
        // [
                // 'access_token'  => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzYW5kYm94QHNhcHBlcmNvbnN1bHRpbmcuY29tIiwiaWF0IjoxNTA1NDEzNjAzLCJleHAiOjE1MDU0MjA4MDMsImJlbnRvIjoiYXBwMWIiLCJvcmdfdXNlcl9pZCI6OSwiYXVkIjoiU2FwcGVyIENvbnN1bHRpbmciLCJzY29wZXMiOiJjcmVhdGVfcHJvc3BlY3RzIHJlYWRfcHJvc3BlY3RzIHVwZGF0ZV9wcm9zcGVjdHMgcmVhZF9zZXF1ZW5jZXMgdXBkYXRlX3NlcXVlbmNlcyByZWFkX3RhZ3MgcmVhZF9hY2NvdW50cyBjcmVhdGVfYWNjb3VudHMgcmVhZF9hY3Rpdml0aWVzIHJlYWRfbWFpbGluZ3MgcmVhZF9tYXBwaW5ncyByZWFkX3BsdWdpbnMgcmVhZF91c2VycyBjcmVhdGVfY2FsbHMgcmVhZF9jYWxscyByZWFkX2NhbGxfcHVycG9zZXMgcmVhZF9jYWxsX2Rpc3Bvc2l0aW9ucyIsIm5vbmNlIjoiZmVjOWUzZTIifQ.fe3412fuojhFds1a5TKJDthur5_vdaepyosJR2wIgLM',
                // 'refresh_token' => 'ac6c9c22e0a19327888e72d44bba965fb303d12a8059604334181377859b1907',
                // 'token_expires' => time() + 7199,
                // 'id'            => 307
        // ]
// );
// die('done');