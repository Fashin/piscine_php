<?php

class Ship
{

  public $_name;
  public $_id;
  public $armes;
  public $orientation;
  public $_cara = array(
    'height'  =>  0,
    'width'   =>  0,
    'vitesse' =>  0,
    'bouclier' => 0,
    'pos_x' => 0,
    'pos_y' => 0,
    'health' => 0,
    'health_max' => 0,
    'manoeuvre' => 0,
    'pp' => 0,
    'pp_actual' => -1,
    "is_moving" => 0
  );
  public $is_activated;

  public $error = 0;

  function __construct($name, $params)
  {
    if (!empty($name))
      $this->_name = $name;
    foreach ($params as $k => $v)
    {
      if (key_exists($k, $this->_cara))
        $this->_cara[$k] = $v;
      else if ($k == 'armes')
        $this->armes[] = new Armes($v);
      else if ($k == "id")
        $this->_id = $v;
      else
        $this->error = 1;
    }
    $this->is_activated = 0;
  }

  public function _getcara()
  {
    return ($this->_cara);
  }

  public function _get($var)
  {
    return ($this->$var);
  }

  function __toString()
  {
    $txt = "The Ship : \"" . $this->_name . "\" have the caracteristic : <br>";
    foreach ($this->_cara as $k => $v)
      $txt = $txt . " -> " . $k . " : " . $v . "<br>";
    $txt = "And the Weapons : <br>";
    foreach ($this->armes as $k => $v)
      $txt = $this->armes[$k];
    $txt = $txt . "<br>";
    return ($txt);
  }

}

 ?>
