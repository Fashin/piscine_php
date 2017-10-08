<?php

class Game extends System
{
  private function save(Plateau $board)
  {
    if (file_put_contents(ROOT . 'tmp/board', json_encode($board->_get('_board'))))
      return (0);
    return (1);
  }

  function __construct()
  {
    $board = new Plateau(100, 150, 10);
    $board->generate();
    $this->error = $this->save($board);
    ($this->error) ?
      $this->insert_log('Fatal Error : (can\'t generate file system)' . PHP_EOL) :
      $this->insert_log('File System generate, game can be launch' . PHP_EOL);
  }
}

?>
