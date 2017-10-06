<?php

  function set ($name, $value)
  {
    setcookie($name, $value, 2147483647);
  }

  function  get ($cookie)
  {
    if ($_COOKIE[$cookie] != "")
      echo $_COOKIE[$cookie] . PHP_EOL;
  }

  function del($cookie)
  {
    setcookie($cookie, null, -1);
  }

  if ($_GET['action'] != "")
  {
    $action = $_GET['action'];
    if ($_GET['name'] != "")
    {
      if ($_GET['value'] != "")
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
