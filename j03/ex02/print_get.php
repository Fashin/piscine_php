<?php

  if (isset($_GET))
  {
    foreach ($_GET as $key => $val)
      echo $key . ": " . $val . "\n";
  }

?>
