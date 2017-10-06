<?php

class Jaime extends Lannister
{
  public function sleepWith($vhr)
  {
    if (get_class($vhr) == 'Cersei' || get_class($vhr) == 'Sansa')
    {
      if ($vhr instanceof parent)
        echo 'With pleasure, but only in a tower in Winterfell, then.' . PHP_EOL;
      else
        echo 'Let\'s do this.' . PHP_EOL;
    }
    else
      echo 'Not Event if I\'m drunk !' . PHP_EOL;
  }
}

?>
