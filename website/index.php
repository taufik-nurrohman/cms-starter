<?php

include 'functions/Route.php';

/*!
 * Define our home URL
 */
$base = trim(dirname($_SERVER['SCRIPT_NAME']), '/');
$host = 'http://' . trim($_SERVER['HTTP_HOST'], '/') . (empty($base) ? "" : '/' . $base);

/*!
 * Index page => `blog`, `blog/1`
 */
Route::get(array('blog', 'blog/(:num)'), function($offset = 1) use($host) {
    $title = 'Blog Page';
    include 'templates/blog.php';
    exit;
});

/*!
 * Category page => `category/category-slug`, `category/category-slug/1`
 */
Route::get(array('category/(:any)', 'category/(:any)/(:num)'), function($slug = "", $offset = 1) use($host) {
    $title = 'Category Page';
    include 'templates/category.php';
    exit;
});

/*!
 * Article page => `article/article-slug`
 */
Route::get('article/(:any)', function($slug = "") use($host) {
    $title = 'Article Page';
    if(file_exists('pages/' . $slug . '.txt')) {
        $content = file_get_contents('pages/' . $slug . '.txt');
        include 'templates/article.php';
        exit;
    } else {
        header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
        include 'templates/404.php';
        exit;
    }
});

/*!
 * User submitting a search query
 */
Route::get('search', function() use($host) {
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['q']) && ! empty($_POST['q'])) {
        header('Location: ' . $host . '/search/' . urlencode($_POST['q']));
        exit;
    } else {
        header('Location: ' . $host);
        exit;
    }
});

/*!
 * Search page => `search/search-query`, `search/search-query/1`
 */
Route::get(array('search/(:any)', 'search/(:any)/(:num)'), function($query = "", $offset = 1) use($host) {
    $title = 'Search Page';
    $query = urldecode($query);
    include 'templates/search.php';
    exit;
});

/*!
 * Home page => `/`
 */
Route::get("", function() use($host) {
    $title = 'Home Page';
    include 'templates/home.php';
    exit;
});

/*!
 * Execute the URL matching!
 */
Route::execute();




/*!
 * Fallback to 404 page if nothing matched!
 */
header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
$title = '404 Page';
include 'templates/404.php';