<?php

class Tyrion extends Lannister
{
  function __construct()
  {
    parent::__construct();
    print_r("My name is Tyrion" . PHP_EOL);
  }

  public function getSize()
  {
    return ("Short");
  }
}

?>
