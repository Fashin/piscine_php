<?php

  require_once('./color/Color.class.php');

  Color::$verbose = true;
  $color = new Color(array('rgb'=>0xff));
  print_r(hexdec(255 << 8))
  //$color2 = new Color(array('red'=>255, 'green'=>255, 'blue'=>255));

?>
