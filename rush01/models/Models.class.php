<?php

require_once("../options/Options.trait.php");

class Models
{
  protected $db_co;

  use Options;

  protected function init_db()
  {
    try {
      $db_p = $this->_get_db_parameter();
      var_dump($db_p);
      $this->db_co = new PDO($db_p['dsn'], $db_p['user'], $db_p['psswd']);
    } catch (PDOException $e) {
      echo "Connexion failed : " . $e->getMessage();
    }
  }
}

?>
