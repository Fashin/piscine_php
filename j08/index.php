<?php

define('ROOT', getcwd() . "/");
define('CONT', ROOT . 'controller/');
require_once(CONT . 'Controller.php');
Controller::call_function();
$game = new Game();
$game->init_player($game->_get('_board'), $game);

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Warhammer 40000</title>
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <!-- <iframe src="view/board.php" class="board"></iframe>
    <iframe src="view/tchat.php" class="tchat"></iframe>
    <iframe src="view/input-tchat.php" class="input-tchat"></iframe> -->
  </body>
</html>
