<?php

  function set ($name, $value)
  {
    setcookie($name, $value, 2147483647);
  }

  function  get ($cookie)
  {
    if (isset($_COOKIE[$cookie]))
      echo $_COOKIE[$cookie] . "\n";
  }

  function del($cookie)
  {
    setcookie($cookie, null, -1);
  }

  if (isset($_GET['action']))
  {
    $action = $_GET['action'];
    if (isset($_GET['name']))
    {
      if (isset($_GET['value']))
        set($_GET['name'], $_GET['value']);
      else
      {
        if ($_GET['action'] == "del")
          del($_GET['name']);
        else if ($_GET['action'] == "get")
          get($_GET['name']);
      }
    }
  }

?>
