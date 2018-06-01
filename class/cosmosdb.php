<?php

namespace Sapper;

class CosmosDb {

    const CONNECTION_STRING = 'mongodb://sapper:tSfDnYF7srbW748nTah8JnmRRjv1cHlkMxAaxKsymPDzK5dKHXoXFIxeTofRRgCDj7OKzN14gW3IVi11pQRlBw==@sapper.documents.azure.com:10255/?ssl=true&replicaSet=globaldb';
    const DB_NAME = 'SapperSuite';

    public static function getDatabase()
    {
        $dbName = self::DB_NAME;

        if (!empty($GLOBALS['sapper-env']['ENV_NAME'])) {
            $dbName .= $GLOBALS['sapper-env']['ENV_NAME'];
        }

        return (new \MongoDB\Client(self::CONNECTION_STRING))->selectDatabase($dbName);
    }

    public static function mongoCall($resource, $method, $arguments)
    {
        $attempts = 0;

        doAttempt:
        try {
            return call_user_func_array([$resource, $method], $arguments);
        } catch (\Exception $e) {

            switch (true) {
                case ($e instanceof \MongoDB\Driver\Exception\ConnectionTimeoutException):
                    $attempts++;

                    if (3 == $attempts) {
                        throw $e;
                    } else {
                        sleep(5);
                        goto doAttempt;
                    }
                    break;

                default:
                    throw $e;
                    break;
            }

        }
    }
}