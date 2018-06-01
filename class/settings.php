<?php

namespace Sapper;

class Settings {

    private $settings = [];
    private static $instance;

    /**
     * Settings constructor.
     */
    protected function __construct()
    {
        $this->updateData();
    }

    private function updateData() {
        $this->settings = [
            'external' => json_decode(
                Db::fetchColumn('SELECT * FROM `sap_settings` WHERE `id` = 1', [], 'settings'),
                true
            ),
            'internal' => json_decode(
                Db::fetchColumn('SELECT * FROM `sap_settings` WHERE `id` = 2', [], 'settings'),
                true
            )
        ];
    }

    /**
     * @param $setting
     * @param string $scope
     * @return mixed
     * @throws \Exception
     * @internal param $settings
     */
    public static function get($setting, $scope = 'external', $forceUpdate = false) {
        $instance = self::getInstance();

        if ($forceUpdate) {
            $instance->updateData();
        }

        if (!array_key_exists($setting, $instance->settings[$scope])) {
            throw new \Exception('Unknown setting: ' . $setting);
        }
        return $instance->settings[$scope][$setting];
    }

    /**
     * @param $setting
     * @param $value
     * @param $scope
     * @throws \Exception
     */
    public static function update($setting, $value, $scope) {
        $instance = self::getInstance();

        if (!array_key_exists($setting, $instance->settings[$scope])) {
            throw new \Exception('Unknown setting: ' . $setting);
        }

        $instance->settings[$scope][$setting] = $value;

        Db::query(
            'UPDATE `sap_settings` SET `settings` = :settings WHERE `id` = :id',
            [
                'settings' => json_encode($instance->settings[$scope], JSON_UNESCAPED_SLASHES),
                'id'       => 'external' == $scope ? 1 : 2
            ]
        );
    }

    /**
     * @return  Settings Singleton instance
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