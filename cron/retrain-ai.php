<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

use Sapper\Db;
use Sapper\Settings;

require_once(__DIR__ . '/../init.php');

set_time_limit(0);

$inProgressFile = APP_ROOT_PATH . '/upload/.retrain-in-progress';

if (file_exists($inProgressFile)) {
    exit;
}

$admin_email = 'katie.mcaninch@sapperconsulting.com';
$admin_email2 = 'dani@koesterich.com';

$messages   = Db::fetchAll('SELECT * FROM `sap_gmail_retrain_queue`');
$messageIds = [];

if (0 == count($messages)) {
    exit;
}

touch($inProgressFile);

$awsS3 = new Aws\S3\S3Client([
    'version'     => 'latest',
    'region'      => 'us-east-1',
    'credentials' => [
        'key'    => 'AKIAID3DVZPJJY6AU7ZQ',
        'secret' => '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',
    ],
]);

$path = APP_ROOT_PATH . '/upload/' . date('Y-m-d');

if (!is_dir($path)) {
    mkdir($path);
}

$path .= '/a' . str_replace([' ', '.'], '', microtime());

if (!is_dir($path)) {
    mkdir($path);
}

$dataSourceKey = Settings::get('amazon-ml-data-source-key', 'internal');
$transfer      = new Aws\S3\Transfer(
    $awsS3,
    's3://sapper-suite-email-data/',
    $path
);

$transfer->transfer();

if (!file_exists($path . '/' . $dataSourceKey)) {
    throw new Exception ('Cannot find file: ' . $dataSourceKey);
}

$contents = file_get_contents($path . '/' . $dataSourceKey);

foreach ($messages as $message) {

    $messageIds[] = $message['id'];
    $account      = Db::fetch(
        'SELECT * FROM `sap_client_account_gmail` WHERE `id` = :id',
        ['id' => $message['gmail_account_id']]
    );

    $labelsMap = [
        'Scheduling in Progress' => $account['label_id_scheduling_in_progress'],
        'Reschedule/Cancel'      => $account['label_id_reschedule_cancel'],
        'Referral'               => $account['label_id_referral'],
        'Confused'               => $account['label_id_confused'],
        'Closed Lost'            => $account['label_id_closed_lost'],
        'Bad Email'              => $account['label_id_bad_email'],
        'Unknown'                => $account['label_id_unknown']
    ];

    $client = new Google_Client();
    $client->setApplicationName(GOOGLE_APP);
    $client->setAuthConfig(APP_ROOT_PATH . '/api/' . GOOGLE_JSON);
    $client->setAccessToken(json_decode($account['access_token'], true));

    if ($client->isAccessTokenExpired()) {
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        Db::query(
            'UPDATE `sap_client_account_gmail` SET `access_token` = :access_token WHERE `id` = :id',
            [
                'access_token' => json_encode($client->getAccessToken(), JSON_UNESCAPED_SLASHES),
                'id'           => $account['id']
            ]
        );
    }

    $gmail          = new Google_Service_Gmail($client);
    $messageService = $gmail->users_messages;

    $messageData = $messageService->get('me', $message['message_id'], ['format' => 'raw']);

    foreach ($messageData->labelIds as $labelId) {
        if (false !== ($label = array_search($labelId, $labelsMap))) {
            $rawData        = $messageData->raw;
            $sanitizedData  = strtr($rawData, '-_', '+/');
            $decodedMessage = base64_decode($sanitizedData);
            $sentAt         = date('Y-m-d H:i', substr($messageData->internalDate, 0, -3));

            $mailParser = new \ZBateson\MailMimeParser\MailMimeParser();
            $mail       = $mailParser->parse($decodedMessage);
            $to         = $mail->getHeaderValue('to');
            $from       = $mail->getHeaderValue('from');
            $subject    = $mail->getHeaderValue('subject');
            $body       = $mail->getTextContent();

            if (!empty($to) && !empty($from) && !empty($subject) && !empty($body)) {

                ob_start();
                $outstream = fopen("php://output", 'r+');
                fputcsv(
                    $outstream,
                    [
                        $from,
                        $to,
                        $sentAt,
                        $subject,
                        str_replace(["\r", "\n"], ['', ' '], $body),
                        $label
                    ]
                );
                fclose($outstream);
                $newData = ob_get_contents();
                ob_end_clean();

                $contents .= $newData;
            }
        }
    }
}

// upload new data to S3
$newDataSourceKey = str_replace([' ', '.'], '', microtime()) . '.csv';

$path .= '/' . 'upload';

if (!is_dir($path)) {
    mkdir($path);
}

$dataSourceFile   = $path . '/' . $newDataSourceKey;
$dataSourceFileRs = fopen($dataSourceFile, 'w');
fwrite($dataSourceFileRs, $contents);
fclose($dataSourceFileRs);

$transfer = new Aws\S3\Transfer(
    $awsS3,
    $path,
    's3://sapper-suite-email-data/'
);

$transfer->transfer();

// create data source
$awsML = new Aws\MachineLearning\MachineLearningClient([
    'version'     => 'latest',
    'region'      => 'us-east-1',
    'credentials' => [
        'key'     => 'AKIAID3DVZPJJY6AU7ZQ',
        'secret'  => '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',
    ],
]);

$result = $awsML->createDataSourceFromS3([
    'ComputeStatistics' => true,
    'DataSourceId'      => $newDataSourceKey,
    'DataSourceName'    => $newDataSourceKey,
    'DataSpec' => [
        'DataLocationS3' => 's3://sapper-suite-email-data/' . $newDataSourceKey,
        'DataSchema'     => '{
          "version" : "1.0",
          "rowId" : null,
          "rowWeight" : null,
          "targetAttributeName" : "Folder",
          "dataFormat" : "CSV",
          "dataFileContainsHeader" : true,
          "attributes" : [ {
            "attributeName" : "From",
            "attributeType" : "CATEGORICAL"
          }, {
            "attributeName" : "To",
            "attributeType" : "TEXT"
          }, {
            "attributeName" : "Timestamp",
            "attributeType" : "TEXT"
          }, {
            "attributeName" : "Subject",
            "attributeType" : "CATEGORICAL"
          }, {
            "attributeName" : "Message",
            "attributeType" : "TEXT"
          }, {
            "attributeName" : "Folder",
            "attributeType" : "CATEGORICAL"
          } ],
          "excludedAttributeNames" : [ ]
        }'
    ],
]);

if ($result['DataSourceId'] !== $newDataSourceKey) {
    throwException(new \Exception('Could not create data source'));
}

// build model
$result = $awsML->createMLModel([
    'MLModelId' => 'ml' . $newDataSourceKey,
    'MLModelName' => 'ml' . $newDataSourceKey,
    'MLModelType' => 'MULTICLASS',
    'TrainingDataSourceId' => $newDataSourceKey
]);

if ($result['MLModelId'] !== 'ml' . $newDataSourceKey) {
    throwException(new \Exception('Could not create ML model'));
}

$status = 'INPROGRESS';

do {
    sleep(10);
    $result = $awsML->getMLModel(['MLModelId' => 'ml' . $newDataSourceKey]);
    $status = $result['Status'];

} while (in_array($status, ['INPROGRESS', 'PENDING']));

if ('COMPLETED' !== $status) {
    throwException('ML Model ended with status: ' . $status);
}

// create endpoint
$result = $awsML->createRealtimeEndpoint([
    'MLModelId' => 'ml' . $newDataSourceKey
]);

if (!is_array($result) || !array_key_exists('RealtimeEndpointInfo', $result)) {
    if ($result['MLModelId'] !== 'ml' . $newDataSourceKey) {
        throwException(new \Exception('Could not create relatime endpoint'));
    }
}

// update data source key, model id & endpoint in settings
$oldDataSourceId = Settings::get('amazon-ml-data-source-id', 'internal');
$oldMLModelId    = Settings::get('amazon-ml-model-id', 'internal');

Settings::update('amazon-ml-data-source-key', $newDataSourceKey, 'internal');
Settings::update('amazon-ml-data-source-id', $newDataSourceKey, 'internal');
Settings::update('amazon-ml-model-id', 'ml' . $newDataSourceKey, 'internal');
Settings::update('amazon-ml-predict-endpoint', $result['RealtimeEndpointInfo']['EndpointUrl'], 'internal');
Settings::update('ai-last-trained', time() - (60*60*5), 'internal');


// delete realtime endpoint
$result = $awsML->deleteRealtimeEndpoint(['MLModelId' => $oldMLModelId]);

if ($result['MLModelId'] !== $oldMLModelId) {
    throwException(new \Exception('Could not delete old ML model realtime endpoint'));
}

// delete model
$result = $awsML->deleteMLModel(['MLModelId' => $oldMLModelId]);

if ($result['MLModelId'] !== $oldMLModelId) {
    throwException(new \Exception('Could not delete old ML model'));
}

// delete model data source
$result = $awsML->deleteDataSource(['DataSourceId' => $oldDataSourceId]);

if ($result['DataSourceId'] !== $oldDataSourceId) {
    throwException(new \Exception('Could not delete old data source'));
}

// delete data source file
$awsS3->deleteObject([
    'Bucket' => 'sapper-suite-email-data',
    'Key' => $oldDataSourceId,
]);

// delete retrain queue
Db::query(
    sprintf(
        'DELETE FROM `sap_gmail_retrain_queue` WHERE `id` IN (%s)',
        implode(',', $messageIds)
    )
);
unlink($inProgressFile);

function throwException(\Exception $exception) {
    $admin_emails = explode(',', \Sapper\Settings::get('email-notifications'));
        
    foreach ($admin_emails as $admin_email) {
        $email = trim($email);
        Sapper\Mail::send(
            'admin-notification',
            ['noreply@sappersuite.com', 'Sapper Suite'],
            [$admin_email, 'Admin Notification'],
            'Uncaught Exception',
            [
                'context'   => 'retrain-ai',
                'exception' => $exception->getTraceAsString()
            ]
        );
    }    

    unlink(APP_ROOT_PATH . '/upload/' . '.retrain-in-progress');

    throw $exception;
    exit;
}
