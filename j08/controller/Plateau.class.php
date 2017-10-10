<?php

class Plateau
{
  private $_height = 0;
  private $_width = 0;
  private $_obstacle_size = 0;
  private $_board;
  public $position;

  function __construct($width, $height, $obstacle_size)
  {
    $this->_width = (($width = intval($width)) > 10) ? $width : 150;
    $this->_height = (($height = intval($height)) > 10) ? $height : 100;
    $this->_obstacle_size = (($obstacle_size = intval($obstacle_size)) > 0) ? $obstacle_size : 10;
    $this->position['NORTH'] = array(0, $this->_width, 10, $this->_width);
    $this->position['SOUTH'] = array($this->_height - 10, $this->_width, $this->_height, $this->_width);
    $this->position['EAST'] = array(0, 10, $this->_height - 10, 10);
    $this->position['WEST'] = array($this->_width - 10, $this->_width, $this->_height - 10, $this->_width);
    foreach ($this->position as $k => $v)
      echo $k . " = [" . $v[0] . " ; " . $v[1] ."] -> [" . $v[2] . " ; " . $v[3] . "]<br>";
  }

  public function generate()
  {
    $nbr_obstacles = 0;
    $obs_max = rand(5,6);

    for ($i = 0; $i < $this->_height; $i++)
      for ($j = 0; $j < $this->_width; $j++)
        $this->_board[$i][$j] = '.';
    $height = 0;
    while ($nbr_obstacles < $obs_max)
    {
      $width = rand(10, $this->_width - ($this->_obstacle_size + 10));
      $height = $height + rand(0, 6);
      for ($i = $height; $i < $height + $this->_obstacle_size; $i++)
      {
        for ($j = $width; $j < $width + $this->_obstacle_size; $j++)
          $this->_board[$i][$j] = 'X';
      }
      $height += $this->_obstacle_size;
      $nbr_obstacles++;
    }
  }

  public function insert_ship(Ship $ship, Player $p)
  {
  }

  public function _get($var)
  {
    return ($this->$var);
  }

}

?>
