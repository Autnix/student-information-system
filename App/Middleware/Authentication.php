<?php

namespace SIS\App\Middleware;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use SIS\App\Config;
use SIS\App\Response;

class Authentication
{

    public function authenticate($body, $params): Response
    {
        $token = null;
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $matches = array();
            $bToken = self::getBearerToken();
            if (!empty($bToken)) {
                $token = $bToken;
            }
        }

        if (!$token) {
            return Response::status(401)->json([
                'error' => true,
                'message' => 'Unauthorized'
            ]);
        }

        try {

            $info = JWT::decode($token, new Key(Config::getenv('ACCESS_TOKEN'), 'HS256'));

            return Response::next([
                'user' => (array)$info->data
            ]);

        } catch (\UnexpectedValueException $ex) {
            return Response::status(401)->json([
                'error' => true,
                'message' => 'Invalid Token'
            ]);
        }
    }
//
//    public function authenticate($body, $params)
//    {
//        $token = null;
//        $headers = apache_request_headers();
//        if (isset($headers['Authorization'])) {
//            $matches = array();
//            preg_match('/Token token="(.*)"/', $headers['Authorization'], $matches);
//            if (isset($matches[1])) {
//                $token = $matches[1];
//            }
//        }
//
//        if ($token) {
//            Response::send($token);
//        }
//    }

    private static function getAuthorizationHeader(): string
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    public static function getBearerToken(): string
    {
        $headers = self::getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return "";
    }

}