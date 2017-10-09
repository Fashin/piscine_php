<?php

class Game extends System
{
  private function save(Plateau $board)
  {
    if (file_put_contents(ROOT . 'tmp/board', serialize($board->_get('_board'))))
      return (0);
    return (1);
  }

  private function init_player()
  {
    
  }

  function __construct()
  {
    $board = new Plateau(150, 100, 10);
    $board->generate();
    $this->error = $this->save($board);
    ($this->error) ?
      $this->insert_log('Fatal Error : (can\'t generate file system)' . PHP_EOL) :
      $this->insert_log('File System generate, game can be launch' . PHP_EOL);
    $this->init_player();
  }
}

?>
