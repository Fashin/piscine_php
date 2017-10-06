<?php

class Tyrion extends Lannister
{
  public function sleepWith($vhr)
  {
    if (get_class($vhr) == 'Sansa')
        echo 'Let\'s do this.' . PHP_EOL;
    else
      echo 'Not Event if I\'m drunk !' . PHP_EOL;
  }
}

?>
