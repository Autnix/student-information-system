<?php

namespace SIS\App\Utils;

use SIS\App\Config;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Helpers
{

    public static int $sessionExp = 604000;
    public static array $payload = [];

    public static function __callStatic(string $name, array $arguments)
    {
        self::$payload = [
            'iss' => $_SERVER['HTTP_HOST'],
            'aud' => $_SERVER['HTTP_HOST'],
            'exp' => time() + self::$sessionExp,
        ];
    }

    public static function passwordToHash(string $password): string
    {
        return hash('SHA256', $password . hash('SHA1', Config::getenv('PASWORD_HASH_TOKEN')));
    }

    public static function generateAccessToken(array $user): string
    {
        return JWT::encode([...self::$payload, 'data' => $user], Config::getenv('ACCESS_TOKEN'), 'HS256');
    }

}