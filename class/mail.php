<?php

namespace Sapper;

class Mail {

    public static function send($template, $from, $to, $subject, $params = [])
    {
        extract($params);

        ob_start();
        require(APP_ROOT_PATH . '/email/' . $template . '.php');
        $rendered = ob_get_contents();
        ob_end_clean();

        $connection = \Swift_SmtpTransport::newInstance('smtp.sendgrid.net', 465, 'ssl')
            ->setUsername('sapper-suite')
            ->setPassword('zqxTKx8hsrHpqUp*DVfC');

        // setup connection/content
        $mailer  = \Swift_Mailer::newInstance($connection);
        $message = \Swift_Message::newInstance()
            ->setContentType("text/html")
            ->setFrom($from[0], $from[1])
            ->setSubject($subject)
            ->setTo($to[0], $to[1])
            ->setBody($rendered);

        try {
            $mailer->send($message);
        } catch (\Exception $e) {

        }
    }
}