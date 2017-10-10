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
    //$this->position['NORTH'] = array(0, $this->_width, 10, $this->_width);
    //$this->position['SOUTH'] = array($this->_height - 10, $this->_width, $this->_height, $this->_width);
    $this->position['EAST'] = array(0, 10, $this->_height - 10, 10, "check_east_position");
    $this->position['WEST'] = array($this->_width - 20, $this->_width - 10, $this->_height - 10, $this->_width - 10, "check_west_position");
  }

  public function generate()
  {
    $nbr_obstacles = 0;
    $obs_max = rand(5,6);

    for ($i = 0; $i < $this->_height; $i++)
    {
      for ($j = 0; $j < $this->_width; $j++)
        $this->_board[$i][$j] = '.';
      $this->_board[$i][$j + 1] = PHP_EOL;
    }
    $this->_board[$i + 1][$j] = PHP_EOL;
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

  public function check_east_position($cara, $plateau, $p_position)
  {
    $s_width = $cara['width'];
    $s_height = $cara['height'];
    $x = $p_position[0];
    $obs_x = 0;
    $is_find = true;
    for ($x = $p_position[0]; $x < $s_height && $x < $p_position[2]; $x++)
    {
      for ($y = 0; $y < $s_width && $y < $p_position[1] && $is_find; $y++)
      {
        echo "check for [ " . $x . "][ " . $y . " ] = " . $plateau[$x][$y] . "<br>";
        if ($plateau[$x][$y] != '.')
        {
          $is_find = false;
        }
      }
      if (!($is_find))
        $x += 2;
      $is_find = true;
    }
    return (array($x, $y));
  }

  public function check_west_position($cara, $plateau, $p_position)
  {
    $s_width = $cara['width'];
    $s_height = $cara['height'];
    return (array(0, 0));
  }

  public function insert_ship(Player $p)
  {
    $p_position = $this->position[$p->position];
    $color = strtoupper($p->_getcolor()[0]);
    $ships = $p->_get_ships();
    $func = $p_position[4];
    foreach ($ships as $k => $v)
    {
      $plateau = $this->_getboard();
      $cara = $v->_getcara();
      $pos = $this->$func($cara, $plateau, $p_position);
      var_dump($pos);
      if ($pos[0] > 0 && $pos[1] > 0)
        for ($i = $pos[0]; $i > $pos[0] - $cara['height']; $i--)
          for ($j = $pos[1]; $j > $pos[1] - $cara['width']; $j--)
            $this->_board[$i][$j] = $color;
      // if ($pos[0] && $pos[1])
      //   for ($i = $pos[0]; )
    }
  }

  public function _getboard()
  {
    return ($this->_board);
  }

  public function _get($var)
  {
    return ($this->$var);
  }

}

?>
