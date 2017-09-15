#!/usr/bin/php
<?php

  function cleans_space($str)
  {
    if (preg_match_all('/\S+/', $str, $ret))
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
