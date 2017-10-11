<?php

class Armes
{
  public $name;
  public $charge;
  public $range = array();
  public $description;

  function __construct($params)
  {
    $range = array('pc', 'pi', 'pl');
    $this->name = array_keys($params)[0];
    $this->charge = $params[$this->name]['charge'];
    foreach ($range as $val)
      $this->range[] = $params[$this->name][$val];
    $this->description = $params[$this->name]['description'];
  }

  function __toString()
  {
    $txt = "The weapon : \"" . $this->name . "\" describe by : " . $this->description . "<br>";
    $txt = $txt . "Have a range of : <br>";
    foreach ($this->range as $k => $v)
      $txt = $txt . "[ " . $v[0] . " ; " . $v[1] . "]<br>";
    $txt = $txt . "<br>";
    return ($txt);
  }
}

?>
