<?php

namespace SIS\App;

class Router
{

    public static array $routes = [];
    public static string $path;
    public static array $patterns = [
        ":([a-zA-Z0-9]+)" => "([0-9a-zA-Z-_]+)",
        "{any}" => "([0-9a-zA-Z-_/]+)"
    ];
    public static string $prefix = "";
    public static array $middlewares = [];
    public static bool $isRoute = false;

    /**
     * @param string $path
     * @return Router
     */
    public static function route(string $path): Router
    {
        $path = (self::$prefix !== "" && $path === "/") ? "" : $path;
        self::$path = self::$prefix . $path;
        return new self();
    }

    /**
     * @return void
     */
    public static function dispatch(): void
    {
        $url = self::getUrl();
        $method = self::getMethod();
        foreach (self::$routes[$method] ?? [] as $path => $route) {

            $path = self::getRealPath($path);
            $pattern = "#^" . $path . "$#";
            $requestBody = Input::getJson();


            if (preg_match($pattern, $url, $params)) {

                array_shift($params);
                self::$isRoute = true;

                $request = [
                    'body' => $requestBody,
                    'params' => $params
                ];

                $mdcheck = self::runMiddlewares($route['middlewares'], $request);

                if ($mdcheck[0]) {
                    $request = $mdcheck[1];
                    self::runCallback($route['callback'], $request);
                }

            }

        }
    }

    public function middleware($callback): Router
    {
        self::$middlewares[] = $callback;
        return new self();
    }

    /* Dispatch Running Method */

    /**
     * @param $middlewares
     * @param array $params
     * @return bool
     */
    private static function runMiddlewares($middlewares, array $params = []): array
    {

        [$continue, $mdData] = [true, []];

        foreach ($middlewares as $callback) {
            if (is_callable($callback)) {
                $result = call_user_func_array($callback, $params);
            } else {
                [$middlewareName, $middlewareMethod] = explode('@', $callback);

                $middlewareName = "SIS\\App\\Middleware\\" . $middlewareName;
                $middleware = new $middlewareName();
                $result = call_user_func_array([$middleware, $middlewareMethod], $params);
            }

            if (!Response::hasNext($result)) {
                Response::end($result);
                $continue = false;
                break;
            } else {
                $mdData = Response::$mdData;
                Response::$next = false;
                $params['mdData'] = [...$params['mdData'] ?? [], $mdData];
                Response::$mdData = [];
            }

        }

        return [$continue, $params];

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

    /* Prefix Group Methods */

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

    /* Getter Methods */

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
     * @return void
     */
    public static function clearMiddlewares(): void
    {
        self::$middlewares = [];
    }

    /**
     * @return bool
     */
    public static function hasRoute(): bool
    {
        return self::$isRoute;
    }

    /* HTTP Methods */

    /**
     * @param $callback
     * @return void
     */
    public function get($callback): void
    {
        self::$routes['get'][self::$path] = [
            "callback" => $callback,
            "middlewares" => self::$middlewares
        ];
        self::clearMiddlewares();
    }

    /**
     * @param $callback
     * @return void
     */
    public function post($callback): void
    {
        self::$routes['post'][self::$path] = [
            "callback" => $callback,
            "middlewares" => self::$middlewares
        ];
        self::clearMiddlewares();
    }

    /**
     * @param $callback
     * @return void
     */
    public function put($callback): void
    {
        self::$routes['put'][self::$path] = [
            "callback" => $callback,
            "middlewares" => self::$middlewares
        ];
        self::clearMiddlewares();
    }

    /**
     * @param $callback
     * @return void
     */
    public function delete($callback): void
    {
        self::$routes['delete'][self::$path] = [
            "callback" => $callback,
            "middlewares" => self::$middlewares
        ];
        self::clearMiddlewares();
    }


}