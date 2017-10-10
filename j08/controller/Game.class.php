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
    $color = array('red', 'blue', 'green', 'yellow');
    $init_data = unserialize(file_get_contents('tmp/ship'));
    if (!($init_data))
      return (0);
    /* Dans le futur mode multijoueur laisser les joueurs choisir leurs couleur dans le lobby */
    foreach ($init_data as $k => $v)
    {
      $p = new Player($k, $v->race, $color[$k]);
      //$p->attribute_position($this->_players, )
      $p->_set('_ships', $this->init_ship($board, $v, $p));
      $this->_players[] = $p;
    }
    for ($i = 0; $i < count($this->_players); $i++)
      echo $this->_players[$i];

    // ($this->init_ship($board)) ?
    //   $this->insert_log('All ship are generated' . PHP_EOL) :
    //   $this->insert_log('Error from ship generation' . PHP_EOL);
    /*$_SESSION['turn'] = rand(0, count($this->_players));
    $cmd = new Command();
    $txt = "Its turn to player " . $_SESSION['turn'] . " please activate a ship";
    $cmd->put_tchat($txt, 'tmp/tchat', 1);*/
  }

  private function init_ship(Plateau $board, $cara, Player $p)
  {
    $ret = array();
    foreach ($cara->ship as $k => $v)
    {
      $s = new Ship($k, $v);
      $board->insert_ship($s, $p);
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
    // $my_b = $board->_get('_board');
    // for ($x = 0; $x < count($my_b); $x++)
    // {
    //   for ($y = 0; $y < count($my_b[$x]); $y++)
    //     echo $my_b[$x][$y];
    //   echo "<br>";
    // }

  }

  public function _get($var)
  {
    return ($this->$var);
  }
}

?>
