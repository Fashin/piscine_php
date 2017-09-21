#!/usr/bin/php
<?php

if ($argc > 1)
{
  $str = $argv[1];
  $pattern = "/\S+/";
  if (preg_match_all($pattern, $str, $match))
  {
    $match = $match[0];
    for ($i = 0; $i < count($match); $i++)
    {
      if ($i + 1 == count($match))
        echo $match[$i] . "\n";
      else
        echo $match[$i] . ' ';
    }
  }
}

?>
