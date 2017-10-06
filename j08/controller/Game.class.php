<?php

class Game
{
  private $_board;

  function __construct()
  {
    $this->_board = new Plateau(100, 150);
    $this->_board->generate();
  }
}

?>
