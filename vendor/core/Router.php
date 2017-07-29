<?php

namespace vendor\core;

class Router
{
    protected static $routes = [];
    protected static $route = [];

    public static function add($regexp, $route = [])
    {
        self::$routes[$regexp] = $route;
    }

    public static function getRoutes()
    {
        return self::$routes;
    }

    public static function getRoute()
    {
        return self::$route;
    }

    public static function matchRoute($url)
    {
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#$pattern#i", $url, $matches)) {
                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $route[$k] = $v;
                    }
                }
                if (!isset($route['action'])) {
                    $route['action'] = 'index';
                }
//                prefix for admin
                if(!isset($route['prefix'])){
                    $route['prefix'] = '';
                } else {
                    $route['prefix'] .= '\\';
                }

                $route['controller'] = self::upperCamelCase($route['controller']);
                $route['action'] = self::lowerCamelCase($route['action']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    /**
     */
    public static function dispatch($url)
    {
        $url = self::removeQueryString($url);
        if (self::matchRoute($url)) {
            $controller = 'app\controllers\\' .self::$route['prefix']. self::$route['controller'].'Controller';
            if (class_exists($controller)) {
                $cObj = new $controller(self::$route);
                $action = self::$route['action'];
                if (method_exists($cObj, $action)) {
                    $cObj->$action();
                    $cObj->getView();
                } else {
                    throw new \Exception("Метод <b>$controller : $action</b> не знайдено", 404);
//                    echo "Метод <b>$controller : $action</b> не знайдено";
                }
            } else {
                throw new \Exception("Контроллер <b>$controller</b> не знайдено", 404);
            }
        } else {
            throw new \Exception("Сторінка не знайдена", 404);
        }
    }

    protected static function upperCamelCase($name)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }

    protected static function lowerCamelCase($name)
    {
        return lcfirst(self::upperCamelCase($name));
    }

    protected static function removeQueryString($url)
    {
        if($url){
            $params = explode('&', $url, 2);
            return (strpos($params[0], '=')) ? '' : rtrim($params[0], '/');
        }
        return $url;
    }


}