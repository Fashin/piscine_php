<?php

class NightsWatch
{
  private $_warrior;

  public function recruit($vhr)
  {
    if (method_exists($vhr, 'fight'))
      $this->_warrior[] = $vhr;
  }

  public function fight()
  {
    foreach ($this->_warrior as $k => $v)
      $v->fight();
  }
}

?>
