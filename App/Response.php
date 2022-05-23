<?php

namespace SIS\App;

class Response
{

    public static int $statusCode = 301;
    public static string $body = "";
    public static bool $next = false;
    public static array $mdData = [];

    const INTERNAL_SERVER_ERROR = [500, 'Internal Server Error'];

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

    /**
     * @param array $data
     * @return Response
     */
    public static function next(array $data = []): Response
    {
        self::$next = true;
        self::$mdData = $data;
        return new self();
    }

    /**
     * @param Response $res
     * @return bool
     */
    public static function hasNext(Response $res): bool
    {
        return $res::$next;
    }

    /**
     * @param array $constant
     * @return Response
     */
    public static function static(array $constant): Response
    {
        return self::status($constant[0])->json(['error' => true, 'message' => $constant[1]]);
    }

}