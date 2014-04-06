<!DOCTYPE html>
<html dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Location: <?php echo $title; ?></title>
  </head>
  <body>
    <ul>
      <li><a href="<?php echo $host; ?>">Home</a></li>
      <li><a href="<?php echo $host; ?>/blog">Blog</a></li>
      <li><a href="<?php echo $host; ?>/category/foo-bar">Category 1</a></li>
      <li><a href="<?php echo $host; ?>/category/bar-baz">Category 2</a></li>
      <li><a href="<?php echo $host; ?>/article/lorem-ipsum-1">Article 1</a></li>
      <li><a href="<?php echo $host; ?>/article/lorem-ipsum-2">Article 2</a></li>
      <li><a href="<?php echo $host; ?>/article/asdfasdf">Article 404</a></li>
    </ul>
    <form method="post" action="<?php echo $host; ?>/search">
      <input type="text" name="q" value="<?php echo isset($query) ? $query : ""; ?>">
      <button type="submit">Search</button>
    </form>