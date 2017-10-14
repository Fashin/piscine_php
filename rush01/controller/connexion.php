<?php

  if (isset($_POST['login']) && !empty($_POST['login'])
      && isset($_POST['psswd']) && !empty($_POST['psswd']))
  {
    require_once("../options/Options.trait.php");
    require_once("../models/Select.class.php");
    $login = htmlspecialchars($_POST['login']);
    $psswd = htmlspecialchars($_POST['psswd']);
    $psswd = hash('whirlpool', Options::$salt1 . $psswd . Options::$salt2);
    $sel = new Select();
    $user = $sel->user(null, $login, $psswd);
  }
  else
    return (false);

?>
