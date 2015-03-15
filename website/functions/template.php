<?php

function template_create($path, $vars) {
    global $url_base, $url_home;
    extract($vars);
    require 'templates/' . trim($path, '/') . '.php';
    exit;
}