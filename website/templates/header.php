<!DOCTYPE html>
<html dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Location: <?php echo $title; ?></title>
  </head>
  <body>
    <ul>
      <li><a href="<?php echo $url_home; ?>">Home</a></li>
      <li><a href="<?php echo $url_home; ?>/blog">Blog</a></li>
      <li><a href="<?php echo $url_home; ?>/about">About</a></li>
      <li><a href="<?php echo $url_home; ?>/category/foo-bar">Category 1</a></li>
      <li><a href="<?php echo $url_home; ?>/category/baz-qux">Category 2</a></li>
      <li><a href="<?php echo $url_home; ?>/article/asdfasdf">Article 404</a></li>
    </ul>
    <form action="<?php echo $url_home; ?>/search" method="post">
      <input type="text" name="q" value="<?php echo isset($query) ? $query : ""; ?>">
      <button type="submit">Search</button>
    </form>