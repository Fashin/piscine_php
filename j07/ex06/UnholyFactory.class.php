<?php

class UnholyFactory
{
  private $_already_absorbed = array();

  public function absorb($vhr)
  {
    if (get_parent_class($vhr) == 'Fighter')
    {
      $bool = TRUE;
      if (count($this->_already_absorbed) > 0)
      {
        $type = $vhr->_get('_type');
        foreach ($this->_already_absorbed as $k => $v)
          if ($v->_get('_type') == $type)
            $bool = FALSE;
      }
      if ($bool)
      {
        echo "(Factory absorbed a fighter of type " . $vhr->_get('_type') . ")" . PHP_EOL;
        $this->_already_absorbed[] = $vhr;
      }
      else
        echo "(Factory already absorbed a fighter of type " . $type . ")" . PHP_EOL;
    }
    else
      echo '(Factory can\'t absorb this, it\'s not a fighter)' . PHP_EOL;
  }

  public function fabricate($type)
  {
    foreach($this->_already_absorbed as $k => $v)
    {
      if ($v->_get('_type') == $type)
      {
        echo "(Factory fabricates a fighter of type " . $type . ")" . PHP_EOL;
        return ($this->_already_absorbed[$k]);
      }
    }
    echo "(Factory hasn't absorbed any fighter of type " . $type . ")" . PHP_EOL;
    return (NULL);
  }
}

?>
