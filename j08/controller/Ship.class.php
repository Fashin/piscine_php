<?php

class Ship
{

  public $_name;
  public $_id;
  public $_cara = array(
    'height'  =>  0,
    'width'   =>  0
  );

  public $error = 0;

  function __construct($name, $params)
  {
    if (!empty($name))
      $this->_name = $name;
    $obj_var = get_object_vars($params);
    foreach ($obj_var as $k => $v)
    {
      if (key_exists($k, $this->_cara))
        $this->_cara[$k] = $v;
      else if ($k == "id")
        $this->_id = $v;
      else
        $this->error = 1;
    }
  }

  public function _getcara()
  {
    return ($this->_cara);
  }

  public function _get($var)
  {
    return ($this->$var);
  }

}

 ?>
