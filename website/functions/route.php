<?php

$routes = array();

function route_add($patterns, $callback) {
    global $routes;
    if( ! is_array($patterns)) {
        $patterns = array($patterns);
    }
    foreach($patterns as $pattern) {
        $pattern = trim($pattern, '/');
        $pattern = str_replace(
            array(
                '\(',
                '\)',
                '\|',
                '\:any',
                '\:num',
                '\:all',
                '#'
            ),
            array(
                '(',
                ')',
                '|',
                '[^/]+',
                '\d+',
                '.*?',
                '\#'
            ),
        preg_quote($pattern, '/'));
        $routes['#^' . $pattern . '$#'] = $callback;
    }
}

function route_execute() {
    global $routes;
    $url = $_SERVER['REQUEST_URI'];
    $base = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    if(strpos($url, $base) === 0) {
        $url = substr($url, strlen($base));
    }
    $url = trim($url, '/');
    foreach($routes as $pattern => $callback) {
        if(preg_match($pattern, $url, $params)) {
            array_shift($params);
            return call_user_func_array($callback, array_values($params));
        }
    }
}
