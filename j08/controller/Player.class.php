<?php

class Player
{
  private $_name;
  private $_race;
  private $_id;
  private $_ships = array();
  private $color;

  function __construct($p_name, $p_race, $p_color)
  {
    $this->_name = $p_name;
    $this->_race = $p_race;
    $this->_id = uniqid($p_name, TRUE);
    $this->_color = $p_color;
  }

  public function _get($var)
  {
    return ($this->$v);
  }

  public function _set($var, $val)
  {
    $this->$var = $val;
  }

  function __toString()
  {
    $txt = "Player " . $this->_name . " of the race " . $this->_race . " have the ships : <br>";
    foreach ($this->_ships as $k => $v)
      $txt = $txt . "==>" . $v->_get('_name') . "<br>";
    $txt = $txt . "<br>";
    return ($txt);
  }
}

?>
