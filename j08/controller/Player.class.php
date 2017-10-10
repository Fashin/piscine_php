<?php

class Player
{
  private $_name;
  private $_race;
  private $_id;
  private $_ships = array();
  private $_color;
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
      $txt = $txt . "==>" . $v->_get('_name') . "<br>";
    $txt = $txt . "<br>";
    return ($txt);
  }
}

?>
