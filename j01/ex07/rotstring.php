#!/usr/bin/php
<?php

if ($argc > 1)
{
    $str = $argv[1];
    $str = explode(' ', $str);
    $str[] = $str[0];
    array_splice($str, 0, 1);
    for ($i = 0 ; $i < count($str); $i++)
    {
      if ($i < count($str) - 1)
        echo $str[$i] . ' ';
      else
        echo $str[$i] . "\n";
    }
}

?>
