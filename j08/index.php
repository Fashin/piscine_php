<?php

session_start();
define('ROOT', getcwd() . "/");
define('CONT', ROOT . 'controller/');
require_once(CONT . 'Controller.php');
Controller::call_function();
$game = new Game();
$game->init_player($game->_get('_board'), $game);
$_SESSION['data'] = json_encode($game);
/*
$ships = $game->_players[1]->_ships;
foreach ($ships as $k => $v)
{
  echo $v->_name . "<br>";
  echo $v->_cara['pos_x'] . " ; " . $v->_cara['pos_y'] . "<br>";
}

$board = $game->_board->_getboard();

for ($i = 0; $i < count($board) - 1; $i++)
{
  for ($j = 0; $j < count($board[$i]) - 1; $j++)
    echo $board[$i][$j] . " ";
  echo "<br>";
}*/

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Warhammer 40000</title>
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <iframe src="view/board.php" class="board"></iframe>
    <iframe src="view/tchat.php" class="tchat"></iframe>
    <iframe src="view/input-tchat.php" class="input-tchat"></iframe>
  </body>
</html>
