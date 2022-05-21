<?php

namespace SIS\App;

class Response
{

    public static int $statusCode = 301;
    public static string $body = "";
    public static bool $next = false;

    public static function json(array $res): Response
    {
        header('Content-Type: application/json');
        self::$body = json_encode($res);
        return new self();
    }

    public static function send(string $res): Response
    {
        header('Content-Type: text/html; charset=UTF-8');
        self::$body = $res;
        return new self();
    }

    /**
     * @param int $st
     * @return Response
     */
    public static function status(int $st = 301): Response
    {
        self::$statusCode = $st;
        return new self();
    }

    /**
     * @param Response $res
     * @return void
     */
    public static function end($res): void
    {

        if (gettype($res) !== "object" || get_class($res) !== "SIS\\App\\Response") {
            $res = Response::status(500)->json([
                "error" => true,
                "message" => "Controller should return \\SIS\\App\\Response object"
            ]);
        }
        http_response_code($res::$statusCode);
        echo $res::$body;
    }

    public static function next()
    {
        self::$next = true;
        return new self();
    }

    public static function hasNext(Response $res)
    {
        return $res::$next;
    }

}