<?php

class Plateau
{
  private $_height = 0;
  private $_width = 0;
  private $_obstacle_size = 0;
  private $_board;

  function __construct($width, $height, $obstacle_size)
  {
    $this->_width = (($width = intval($width)) > 0) ? $width : 150;
    $this->_height = (($height = intval($height)) > 0) ? $height : 100;
    $this->_obstacle_size = (($obstacle_size = intval($obstacle_size)) > 0) ? $obstacle_size : 10;
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
      $width = rand(0, $this->_width - $this->_obstacle_size);
      $height = rand($height, $this->_height - $this->_obstacle_size);
      for ($i = $height; $i < $height + $this->_obstacle_size; $i++)
      {
        for ($j = $width; $j < $width + $this->_obstacle_size; $j++)
          $this->_board[$i][$j] = 'X';
      }
      $height += 2;
      $nbr_obstacles++;
    }
  }

  public function _get($var)
  {
    return ($this->$var);
  }

}

?>
