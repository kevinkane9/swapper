<?php  

require_once(__DIR__ . '/class/mail.php');
require_once(__DIR__ . '/class/db.php');
require_once(__DIR__ . '/class/settings.php');

set_exception_handler(function($e){

    $exception = "Error : " . $e->getMessage();
    $exception .= '<br>';
    $exception .= "Error Trace: " . $e->getTraceAsString();

    $emails = explode(',', Sapper\Settings::get('email-notifications'));

    if (1 == Sapper\Settings::get('exception-notifications')) {
        foreach ($emails as $email) {
            Sapper\Mail::send(
                'admin-notification',
                ['noreply@sappersuite.com', 'Sapper Suite'],
                [$email, 'Sapper Suite Admin'],
                'Uncaught Exception',
                [
                    'context'   => 'Uncaught Exception',
                    'pid'       => getmypid(),
                    'exception' => $exception
                ]
            );
        }
    }

    if (array_key_exists('DEBUG', $GLOBALS['sapper-env']) && true == $GLOBALS['sapper-env']['DEBUG']) {
        throw $e;
    }
});