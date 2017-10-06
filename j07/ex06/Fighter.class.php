<?php

class Fighter
{
  private $_type;

  function __construct($type)
  {
    $this->_type = $type;
  }

  public function _get($var)
  {
    return ($this->$var);
  }
}

?>
