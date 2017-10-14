<?php

  trait Options
  {
      private $_db_parameter = array(
        '42' => array(
          'dsn' => "mysql:host=localhost;dbname=war40k;charset=utf8",
          'user' => "root",
          'psswd' => 'hmassonn'
        ),
      );
      private $connection_used = '42';
      public static $salt1 = "fgvjmbg838638+fvcb";
      public static $salt2 = "g5s40t5g4rs5h45dh4";

      public function _get_db_parameter()
      {
        return ($this->_db_parameter[$this->connection_used]);
      }
  }

?>
