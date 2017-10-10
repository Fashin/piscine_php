<?php

class Game extends System
{
  private $_players = array();
  private $_board;
  public $error = 0;

  private function save(Plateau $board)
  {
    if (file_put_contents(ROOT . 'tmp/board', serialize($board->_get('_board'))))
      return (0);
    return (1);
  }

  public function init_player(Plateau $board)
  {
    //session_start();
    /* Dans le futur mode multijoueur laisser les joueurs choisir leurs couleur dans le lobby */
    $color = array('red', 'blue', 'purple', 'yellow');
    $init_data = unserialize(file_get_contents('tmp/ship'));
    if (!($init_data))
      return (0);
    foreach ($init_data as $k => $v)
    {
      $p = new Player($k, $v->race, $color[count($this->_players)]);
      $p->attribute_position($this->_players, $board->position);
      $p->_set_ships($this->init_ship($v, $p));
      $board->insert_ship($p, $board);
      $this->_players[] = $p;
    }

    // ($this->init_ship($board)) ?
    //   $this->insert_log('All ship are generated' . PHP_EOL) :
    //   $this->insert_log('Error from ship generation' . PHP_EOL);
    /*$_SESSION['turn'] = rand(0, count($this->_players));
    $cmd = new Command();
    $txt = "Its turn to player " . $_SESSION['turn'] . " please activate a ship";
    $cmd->put_tchat($txt, 'tmp/tchat', 1);*/
  }

  private function init_ship($cara, Player $p)
  {
    $ret = array();
    foreach ($cara->ship as $k => $v)
    {
      $s = new Ship($k, $v);
      $ret[] = $s;
    }
    return ($ret);
  }

  function __construct()
  {
    $this->_board = new Plateau(150, 100, 10);
    $this->_board->generate();
    $this->error = $this->save($this->_board);
    ($this->error) ?
      $this->insert_log('Fatal Error : (can\'t generate file system)' . PHP_EOL) :
      $this->insert_log('File System generate, game can be launch' . PHP_EOL);
  }

  public function _get($var)
  {
    return ($this->$var);
  }
}

?>
