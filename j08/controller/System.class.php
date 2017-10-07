<?php

class System
{
  private $_file = ROOT . 'log/log.txt';
  public $error = 0;

  public function insert_log($txt)
  {
    if (strlen(file_get_contents($this->_file)) == 0)
      file_put_contents($this->_file, $txt);
    else
      file_put_contents($this->_file, $txt, FILE_APPEND);
  }
}

?>
