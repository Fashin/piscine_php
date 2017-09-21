#!/usr/bin/php
<?php

function display_array($tab)
{
  for ($i = 0; $i < count($tab); $i++)
    echo $tab[$i] . "\n";
}

if ($argc > 1)
{
  $ret = array();
  for ($i = 1; $i < count($argv); $i++)
    $ret = array_merge($ret, explode(' ', $argv[$i]));
  for ($i = 0; $i < count($ret); $i++)
  {
    if (ctype_alpha($ret[$i]))
      $string[] = $ret[$i];
    else if (is_numeric($ret[$i]))
      $numeric[] = $ret[$i];
    else
      $ascii[]  = $ret[$i];
  }
  sort($string, SORT_STRING);
  sort($numeric, SORT_NATURAL | SORT_FLAG_CASE);
  sort($ascii);
  display_array($string);
  display_array($numeric);
  display_array($ascii);
}

?>
