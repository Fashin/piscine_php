<?php

class Player
{
  public $_name;
  public $_race;
  public $_id;
  public $_ships = array();
  public $_color;
  public $position;

  function __construct($p_name, $p_race, $p_color)
  {
    $this->_name = $p_name;
    $this->_race = $p_race;
    $this->_id = uniqid($p_name, TRUE);
    $this->_color = $p_color;
  }

  public function attribute_position($players, $b_position)
  {
    if (!empty($players))
    {
      // This array is only for multiplayer 1v1v1v1
      //$num_position = array(0 => 'NORTH', 1 => 'SOUTH', 2 => 'EAST', 3 => 'WEST');
      $num_position = array(1 => 'WEST');
      for ($i = 0; $i < count($players); $i++);
      $this->position = $num_position[$i];
    }
    else
      $this->position = 'EAST';
  }

  public function _get_ships()
  {
    return ($this->_ships);
  }

  public function _set_ships($ships)
  {
    $this->_ships = $ships;
  }

  public function _set_ship_position($pos, $id_ship)
  {
    $ship = $this->_ships[$id_ship];
    $ship->_cara['pos_x'] = $pos[0];
    $ship->_cara['pos_y'] = $pos[1];
  }

  public function _get($var)
  {
    return ($this->$var);
  }

  public function _getcolor()
  {
    return ($this->_color);
  }

  function __toString()
  {
    $txt = "Player " . $this->_name . " of the race " . $this->_race . " he have the color : ";
    $txt = $txt . $this->_color . " and the position : " . $this->position . "<br>";
    $txt = $txt . " have the ships : <br>";
    foreach ($this->_ships as $k => $v)
      $txt = $txt . "==>" . $v . "<br>";
    $txt = $txt . "<br>";
    return ($txt);
  }
}

?>
