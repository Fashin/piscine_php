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
  </head>
  <body>
  </body>
</html>
<script src="js/create_board.js" charset="utf-8"></script>
