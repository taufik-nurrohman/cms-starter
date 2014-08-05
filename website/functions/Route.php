<?php

/**
 * Simple PHP Router
 * -----------------
 */

class Route {

    private static $routes = array();

    private function __construct() {}
    private function __clone() {}

    private static function fix($str) {
        return str_replace(array(':any', ':num', ':all'), array('.[^/]*?', '\d+', '.*?'), $str);
    }

    public static function get($patterns, $callback) {
        if(is_array($patterns)) {
            foreach($patterns as $pattern) {
                $pattern = '#^' . self::fix($pattern) . '$#';
                self::$routes[$pattern] = $callback;
            }
        } else {
            $pattern = '#^' . self::fix($patterns) . '$#';
            self::$routes[$pattern] = $callback;
        }
    }

    public static function execute() {
        $url = $_SERVER['REQUEST_URI'];
        $base = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        if(strpos($url, $base) === 0) {
            $url = substr($url, strlen($base));
        }
        $url = trim($url, '/');
        foreach(self::$routes as $pattern => $callback) {
            if(preg_match($pattern, $url, $params)) {
                array_shift($params);
                return call_user_func_array($callback, array_values($params));
            }
        }
    }

}
