<?php

namespace Sapper;

class Model {

    private $models = [];
    private static $instance;

    /**
     * Model constructor.
     */
    protected function __construct()
    {
        $modelsDir = opendir(APP_ROOT_PATH . '/model');

        while ($dir = readdir($modelsDir)) {
            if (in_array($dir, ['.', '..'])) {
                continue;
            }

            $model = pathinfo($dir, PATHINFO_FILENAME);

            $this->models[$model] = require(APP_ROOT_PATH . '/model/' . $model . '.php');
        }
    }

    /**
     * @param $model
     * @return array
     * @throws \Exception
     */
    public static function get($model) {
        $instance = self::getInstance();

        if (!array_key_exists($model, $instance->models)) {
            throw new \Exception('Unknown model: ' . $model);
        }
        return $instance->models[$model];
    }

    /**
     * @return  Model Singleton instance
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