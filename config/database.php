<?php

require_once __DIR__ . '/config.php';

class Database
{
    private static $connection = null;

    public static function connect()
    {
        if (self::$connection === null) {
            try {
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;

                self::$connection = new PDO($dsn, DB_USER, DB_PASS);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                self::$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            } catch (PDOException $e) {
                die('Error de conexión: ' . $e->getMessage());
            }
        }

        return self::$connection;
    }
}