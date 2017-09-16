#!/usr/bin/php
<?php

if ($argc > 1)
{
  for ($i = 1; $i < count($argv); $i++)
    $tab[] = explode(' ', $argv[$i]);
  for ($i = 0; $i < count($tab); $i++)
    for ($j = 0; $j < count($tab[$i]); $j++)
      $sort[] = $tab[$i][$j];
  if (sort($sort, SORT_REGULAR))
    for ($i = 0; $i < count($sort); $i++)
      echo $sort[$i] . "\n";
}

?>
