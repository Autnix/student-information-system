<?php

namespace SIS\App;

class Config
{
    public static function load()
    {
        self::loadEnv();
        self::loadDb();
    }

    private static function loadDb(): void
    {
        new \SIS\App\Database();
    }

    private static function loadEnv(): void
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(realpath('.'));
        $dotenv->load();
    }

    public static function getenv(string $key): string
    {
        if (isset($_ENV[$key]))
            return $_ENV[$key];
        return "";
    }
}