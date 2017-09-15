#!/usr/bin/php
<?php

  if ($argc == 2)
  {
    if (preg_match_all('/\S+/', $argv[1], $ret))
    {
      $ret = $ret[0];
      $i = 0;
      while ($ret[$i])
      {
        if ($ret[$i + 1])
          echo $ret[$i] . ' ';
        else
          echo $ret[$i] . "\n";
        $i++;
      }
    }
  }
?>
