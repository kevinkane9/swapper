<?php

namespace Sapper;

class Db {

    CONST DEBUG_OFF = 'debug_off',
          DEBUG_ON = 'debug_on';

    public $dbh;
    private $debugMode;
    private static $instance;
    private static $debugModes = [
                        self::DEBUG_OFF,
                        self::DEBUG_ON
                    ];

    /**
     * Db constructor.
     */
    protected function __construct()
    {
        $this->dbh = new \PDO(
            'mysql:host=' . $GLOBALS['sapper-env']['DB_HOST'] . ';dbname=' . $GLOBALS['sapper-env']['DB_NAME'] .
            ';charset=utf8', $GLOBALS['sapper-env']['DB_USER'], $GLOBALS['sapper-env']['DB_PASS']
        );
        $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->dbh->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        $this->dbh->setAttribute(\PDO::ATTR_EMULATE_PREPARES, FALSE);

        $this->dbh->query("SET NAMES 'utf8'");
        $this->dbh->query("SET CHARACTER SET utf8");
        $this->dbh->query('SET time_zone = "+00:00"');

        $this->debugMode = self::DEBUG_OFF;
    }

    public static function debug($debugMode) {
        if (!in_array($debugMode, self::$debugModes)) {
            throw new \Exception('Unknown debug mode: ' . $debugMode);
        }
        $instance = self::getInstance();
        $instance->debugMode = $debugMode;
    }

    /**
     * @return \PDO
     */
    public static function dbh() {
        $instance = self::getInstance();

        return $instance->dbh;
    }

    /**
     * @param $query
     * @param array $params
     * @return \PDOStatement
     */
    public static function query($query, $params = []) {
        $instance = self::getInstance();

        $query = $instance->dbh->prepare($query);

        if (self::DEBUG_ON == $instance->debugMode) {
            echo '<pre>';
            $query->debugDumpParams();
            print_r($params);
            exit;
        }
        $query->execute($params);

        return $query;
    }

    /**
     * @param $query
     * @param array $params
     * @return mixed
     */
    public static function fetch($query, $params = []) {
        $result = self::query($query, $params);

        return $result->fetch();
    }

    public static function fetchById($table, $id)
    {
        return self::fetch(
            sprintf('SELECT * FROM `%s` WHERE `id` = :id', $table),
            ['id' => $id]
        );
    }

    /**
     * @param $query
     * @param array $params
     * @param $columnName
     * @return mixed
     */
    public static function fetchColumn($query, $params = [], $columnName) {
        $result = self::query($query, $params);

        $row = $result->fetch();
        return is_array($row) && array_key_exists($columnName, $row) ? $row[$columnName] : null;
    }

    /**
     * @param $query
     * @param array $params
     * @return array
     */
    public static function fetchAll($query, $params = []) {
        $result = self::query($query, $params);

        return $result->fetchAll();
    }

    /**
     * @param $query
     * @param array $params
     * @return string
     */
    public static function insert($query, $params = []) {
        self::query($query, $params);

        $instance = self::getInstance();
        return $instance->dbh->lastInsertId();
    }

    public static function createRow($table, $data)
    {
        $keys = array_map(
            function ($field) {
                return '`' .  trim($field) . '`';
            },
            array_keys($data)
        );
        $keys = implode(', ', $keys);

        $values = array_map(
            function ($field) {
                return ':' . trim($field);
            },
            array_keys($data)
        );
        $values = implode(', ', $values);

        $query = 'INSERT INTO ' . '`sap_' . $table . '`' . ' (' . $keys . ') VALUES (' . $values . ')';

        try {
            $id = self::insert($query, $data);
        } catch (\Exception $e) {
            return null;
        }

        return $id;
    }

    public static function updateRowById($table, $id, $data)
    {
        $fields = array_map(
            function ($fieldName) {
                return '`' . $fieldName . '`' . ' = :' . $fieldName;
            },
            array_keys($data)
        );

        $fields = implode(', ', $fields);

        $query = 'UPDATE ' . '`sap_' . $table . '`' . ' SET ' . $fields . ' WHERE `id` = :id';

        $data['id'] = $id;

        self::query($query, $data);
    }

    public static function deleteById($table, $id)
    {
        self::query('DELETE FROM `sap_' . $table . '` WHERE `id` = :id', ['id' => $id]);
    }

    /**
     * @return  Db Singleton instance
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