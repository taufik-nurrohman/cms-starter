<?php

// Create the Home URL
$url_base = trim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$url_home = 'http://' . trim($_SERVER['HTTP_HOST'], '/') . (trim($url_base) !== "" ? '/' . $url_base : "");


// Load the Required Functions
require 'functions/route.php';
require 'functions/template.php';


// Index Page => `blog`, `blog/1`
route_add(array('blog', 'blog/(:num)'), function($offset = 1) use($url_home) {
    template_create('blog', array(
        'title' => 'Blog Page',
        'offset' => (int) $offset
    ));
});

// Category Page => `category/category-slug`, `category/category-slug/1`
route_add(array('category/(:any)', 'category/(:any)/(:num)'), function($slug = "", $offset = 1) use($url_home) {
    template_create('category', array(
        'title' => 'Category Page',
        'category' => $slug,
        'offset' => (int) $offset
    ));
});

// Article Page => `article/article-slug`
route_add('article/(:num)/(:num)/(:any)', function($year = "", $month = "", $slug = "") use($url_home) {
    if(file_exists('articles/' . $year . '-' . $month . '_' . $slug . '.txt')) {
        template_create('article', array(
            'title' => 'Article Page',
            'slug' => $slug,
            'content' => file_get_contents('articles/' . $year . '-' . $month . '_' . $slug . '.txt')
        ));
    } else {
        header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
        template_create('404', array(
            'title' => '404 Not Found',
            'content' => '<p>Article not found.</p>'
        ));
    }
});

// User Search
route_add('search', function() use($url_home) {
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['q']) && ! empty($_POST['q'])) {
        header('Location: ' . $url_home . '/search/' . urlencode($_POST['q']));
        exit;
    } else {
        header('Location: ' . $url_home);
        exit;
    }
});

// Search Page => `search/search-query`, `search/search-query/1`
route_add(array('search/(:any)', 'search/(:any)/(:num)'), function($query = "", $offset = 1) use($url_home) {
    $title = 'Search Page';
    $query = urldecode($query);
    template_create('search', array(
        'title' => 'Search Page',
        'query' => urldecode($query)
    ));
});

// Static Page
route_add('(:any)', function($slug = "") use($url_home) {
    if(file_exists('pages/' . $slug . '.txt')) {
        template_create('page', array(
            'title' => 'Static Page',
            'slug' => $slug,
            'content' => file_get_contents('pages/' . $slug . '.txt')
        ));
    } else {
        header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
        template_create('404', array(
            'title' => '404 Not Found',
            'content' => '<p>Page not found.</p>'
        ));
    }
});

// Home Page => `/`
route_add('/', function() use($url_home) {
    template_create('home', array(
        'title' => 'Home Page'
    ));
});

// Do Routing
route_execute();

// Fallback to 404 Page if Nothing Matched
header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
template_create('404', array(
    'title' => '404 Not Found',
    'content' => '<p>Page not found.</p>'
));