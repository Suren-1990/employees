<?php

use App\Base\Request;

class Route
{
    private static $routes = [];

    /**
     * Store route
     *
     * @param $route
     * @param $closure
     * @throws Exception
     */
    public static function set($route, $closure)
    {
        if ($closure instanceof \Closure) {
            self::$routes[$route] = $closure;
        } else if (!empty($closure)) {
            $arr = explode('@', $closure);
            if (count($arr) == 2) {
                $controller = $arr[0];
//                if (strpos($controller, 'App\Http\Controllers') >= 0) {
//                    $controller = '\App\Http\Controllers\\' . $controller;
//                }
                $method = $arr[1];
                self::$routes[$route] = [
                    'controller' => $controller,
                    'method' => $method
                ];
            } else {
                throw new \Exception("Unknown controller method passed");
            }
        } else {
            throw new \Exception("Unknown controller method passed");
        }
    }

    /**
     * Get response for current route
     *
     * @param $route
     * @return null
     * @throws HttpException
     */
    public static function get($route)
    {
        if (isset(self::$routes[$route])) {
            $routeObj = self::$routes[$route];
            if (count($routeObj) == 1) {
                return $routeObj->__invoke(new Request());
            } else {
                $controller = $routeObj['controller'];
                $method = $routeObj['method'];

                include_once(CONTROLLERS_PATH . $controller . '.php');
                $controller = '\App\Http\Controllers\\' . $controller;

                $controllerObj = new $controller;
                return $controllerObj->$method(new Request());
            }
        }

        header("HTTP/1.0 404 Not Found");
        return View::make('errors.404');
    }
}
