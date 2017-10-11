<?php

  class Controller
  {
    /**
     * All the function called for this super game !
     * @return {VOID} No return just calling
     */
    public static function call_function()
    {
      require_once(CONT . 'System.class.php');
      require_once(CONT . 'Command.class.php');
      require_once(CONT . 'Armes.class.php');
      require_once(CONT . 'Player.class.php');
      require_once(CONT . 'Ship.class.php');
      require_once(CONT . 'Game.class.php');
      require_once(CONT . 'Plateau.class.php');
    }
  }

?>
