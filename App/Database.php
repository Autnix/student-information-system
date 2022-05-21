<?php

namespace SIS\App;

class Database
{

    public static \PDO $db;

    public function __construct()
    {

        $dsn = sprintf("mysql:host=%s;dbname=%s;charset=%s", Config::getenv('DB_HOST'), Config::getenv('DB_NAME'), Config::getenv('DB_CHARSET'));
        try {
            self::$db = new \PDO($dsn, Config::getenv('DB_USER'), Config::getenv('DB_PASS'));
        } catch (\PDOException $e) {
            die("PDO Exception: " . $e->getMessage());
        }

    }

}