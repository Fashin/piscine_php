<?php

define('ROOT', getcwd() . "/");
define('CONT', ROOT . 'controller/');
require_once(CONT . 'Controller.php');
Controller::call_function();
$game = new Game();

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Warhammer 40000</title>
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <canvas id="canvas" width="100%" height="100%">
      Please upgrade your navigator
    </canvas>
  </body>
</html>
<script src="js/display_board.js" charset="utf-8"></script>
<script src="js/create_board.js" charset="utf-8"></script>
