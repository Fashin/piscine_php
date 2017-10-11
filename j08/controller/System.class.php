<?php

class System
{
  public $error = 0;

  public function insert_log($txt)
  {
    $file = ROOT . 'log/log.txt';
    if (strlen(file_get_contents($file)) == 0)
      file_put_contents($file, $txt);
    else
      file_put_contents($file, $txt, FILE_APPEND);
  }
}

?>
