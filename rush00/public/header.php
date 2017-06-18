<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="public/css/style.css">
    <?php
      $url = explode('.', explode('?', explode('/', $_SERVER['REQUEST_URI'])[3])[0])[0];
      if (empty($url))
        echo '<link rel="stylesheet" href="public/css/index.css">';
      else
        echo '<link rel="stylesheet" href="public/css/' . $url . '.css">';
    ?>
  <title>My own shop</title>
</head>
<body>
