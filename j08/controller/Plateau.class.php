<?php

class Plateau
{
  private $_height = 0;
  private $_width = 0;
  private $_board;

  function __construct($width, $height)
  {
    $this->_width = (($width = intval($width)) > 0) ? $width : 150;
    $this->_height = (($height = intval($height)) > 0) ? $height : 100;
  }

  public function generate()
  {
    $nbr_obstacles = 0;
    $obs_max = rand(5,6);

    for ($i = 0; $i < $this->_width; $i++)
      for ($j = 0; $j < $this->_height; $j++)
        $this->_board[$i][$j] = '.';
    while ($nbr_obstacles < $obs_max)
    {
      $width = rand(0, $this->_width - 10);
      $height = rand(0, $this->_height - 10);
      for ($i = $width; $i < $width + 10; $i++)
        for ($j = $height; $j < $height + 10; $j++)
          $this->_board[$i][$j] = 'X';
      $nbr_obstacles++;
    }
  }

  public function _get($var)
  {
    return ($this->$var);
  }

}

?>
