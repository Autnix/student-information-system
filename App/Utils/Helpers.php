<?php

namespace SIS\App\Utils;

use SIS\App\Config;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Helpers
{

    public static int $sessionExp = 604800;
    public static array $payload = [];

    public static function passwordToHash(string $password): string
    {
        return hash('SHA256', $password . hash('SHA1', Config::getenv('PASWORD_HASH_TOKEN')));
    }

    public static function generateAccessToken(array $user, int $rank): string
    {

        self::$payload = [
            'iss' => $_SERVER['HTTP_HOST'],
            'aud' => $_SERVER['HTTP_HOST'],
            'exp' => time() + self::$sessionExp,
        ];
        self::$payload['data'] = $user;
        self::$payload['data']['rank'] = $rank;
        return JWT::encode(self::$payload, Config::getenv('ACCESS_TOKEN'), 'HS256');
    }

    public static function cors(): void
    {

        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
            // you want to allow, and if so:
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

            exit(0);
        }

    }

}