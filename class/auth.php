<?php

namespace Sapper;

use Illuminate\Encryption\Encrypter;

class Auth {

    const SAP_ENCRYPT_KEY = 'dyb_v;i]c>fVW6=J';
    const SAP_COOKIE_NAME = 'primary';

    private static $instance;
    private $encrypter, $sessionLife, $vars = [];

    public function __construct() {
        $this->encrypter   = new Encrypter(self::SAP_ENCRYPT_KEY);
        $this->sessionLife = 60*60*5;
    }

    /**
     * @param $email string
     * @param $password string
     * @return bool
     */
    public static function authenticate($email, $password) {
        $instance = self::getInstance();

        $user = Db::fetch(
            'SELECT u.*, r.`name` AS `role`
               FROM `sap_user` u
          LEFT JOIN `sap_role` r ON u.`role_id` = r.`id`
              WHERE u.`email` = :email
                AND u.`password` = MD5(CONCAT(:password, u.`salt`))',
            [
                'email'    => $email,
                'password' => $password
            ]
        );

        // lookup user in DB
        if ($user && 'active' == $user['status']) {

            // update last login stamp
            Db::query(
                'UPDATE sap_user SET last_login_at = NOW() WHERE id = ' . $user['id']
            );

            $token = json_encode(
                [
                    'expiration'    => time() + $instance->sessionLife,
                    'userId'        => $user['id'],
                    'firstName'     => $user['first_name'],
                    'lastName'      => $user['last_name'],
                    'role'          => $user['role'],
                    'permissions'   => json_decode($user['permissions'], true)
                ]
            );

            $encryptedToken = $instance->encrypter->encrypt($token);

            setcookie(self::SAP_COOKIE_NAME, $encryptedToken, time() + $instance->sessionLife, '/');

            $instance->vars = [
                'valid'       => true,
                'userId'      => $user['id'],
                'firstName'   => $user['first_name'],
                'lastName'    => $user['last_name'],
                'role'        => $user['role'],
                'permissions' => json_decode($user['permissions'], true)
            ];

            return true;
        } else {
            self::destroy();
            return false;
        }
    }

    public static function validate($extendCookieLife = true){
        if (!array_key_exists(self::SAP_COOKIE_NAME, $_COOKIE)) {
            self::destroy();
            return false;
        }

        $instance = self::getInstance();
        $token    = json_decode($instance->encrypter->decrypt($_COOKIE[self::SAP_COOKIE_NAME]), true);

        if (is_array($token) && $token['expiration'] >= time()) {
            if (true == $extendCookieLife) {
                $token['expiration'] = time() + $instance->sessionLife;
                $encryptedToken = $instance->encrypter->encrypt(json_encode($token));
                setcookie(self::SAP_COOKIE_NAME, $encryptedToken, time() + $instance->sessionLife, '/');
            }

            $instance->vars = [
                'valid'       => true,
                'userId'      => $token['userId'],
                'firstName'   => $token['firstName'],
                'lastName'    => $token['lastName'],
                'role'        => $token['role'],
                'permissions' => $token['permissions']
            ];

            return true;
        } else {
            $instance->destroy();
            return false;
        }
    }

    public static function destroy() {
        $instance = self::getInstance();

        $instance->vars = [];
        setcookie(self::SAP_COOKIE_NAME, '', time() - 1000, '/');
    }

    public static function token($var) {
        $instance = self::getInstance();

        return array_key_exists($var, $instance->vars) ? $instance->vars[$var] : false;
    }

    /**
     * @return  Auth Singleton instance
     */
    private static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Prevent cloning by making method private
     */
    private function __clone()
    {
    }

    /**
     * Prevent wakeup by making method private
     */
    private function __wakeup()
    {
    }
}