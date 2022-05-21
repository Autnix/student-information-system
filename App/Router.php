<?php

namespace SIS\App;

class Router
{

    public static array $routes = [];
    public static string $path;
    public static array $patterns = [
        ":([a-zA-Z0-9]+)" => "([0-9a-zA-Z-_]+)"
    ];
    public static string $prefix = "";

    /**
     * @param string $path
     * @return Router
     */
    public static function route(string $path): Router
    {
        self::$path = self::$prefix . $path;
        return new self();
    }

    public static function dispatch()
    {
        //print_r(self::$routes);

        $url = self::getUrl();
        $method = self::getMethod();
        foreach (self::$routes[$method] ?? [] as $path => $route) {

            $path = self::getRealPath($path);
            $pattern = "#^" . $path . "$#";
            $requestBody = Input::getJson();


            if (preg_match($pattern, $url, $params)) {

                array_shift($params);

                $request = [
                    'body' => $requestBody,
                    'params' => $params
                ];

                self::runCallback($route['callback'], $request);

            }

        }
    }

    /**
     * @param \Closure $closure
     * @return void
     */
    public function group(\Closure $closure): void
    {
        $closure();
        self::$prefix = "";
    }

    /**
     * @param string $pre
     * @return Router
     */
    public static function prefix(string $pre): Router
    {
        self::$prefix = $pre;
        return new self();
    }

    /**
     * @param string $path
     * @return string
     */
    public static function getRealPath(string $path): string
    {
        foreach (self::$patterns as $key => $pattern) {
            $path = preg_replace('#' . $key . '#', $pattern, $path);
        }

        return $path;
    }

    /**
     * @param callable $callback
     * @param array $params
     * @return void
     */
    private static function runCallback($callback, array $params = []): void
    {
        if (is_callable($callback)) {
            $result = call_user_func_array($callback, $params);
        } else {

            [$controllerName, $controllerMethod] = explode('@', $callback);

            $controllerName = "SIS\\App\\Controller\\" . $controllerName;
            $controller = new $controllerName();
            $result = call_user_func_array([$controller, $controllerMethod], $params);
        }

        Response::end($result);
    }

    /**
     * @return string
     */
    public static function getMethod(): string
    {
        return (string)strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return string
     */
    public static function getUrl(): string
    {
        $url = (string)str_replace(Config::getenv('BASE_PATH'), null, $_SERVER['REQUEST_URI']);
        if (strlen($url) > 1 && substr($url, -1) === "/") {
            $url = substr($url, 0, -1);
        }
        return $url;
    }

    /**
     * @param $callback
     * @return void
     */
    public function get($callback): void
    {
        self::$routes['get'][self::$path] = [
            "callback" => $callback
        ];
    }

    /**
     * @param $callback
     * @return void
     */
    public function post($callback): void
    {
        self::$routes['post'][self::$path] = [
            "callback" => $callback
        ];
    }


}