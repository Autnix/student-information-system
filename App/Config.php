<?php

namespace SIS\App;

class Config
{
    public static function getenv(string $key): string
    {
        if (isset($_ENV[$key]))
            return $_ENV[$key];
        return "";
    }
}