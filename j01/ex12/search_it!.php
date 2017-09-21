#!/usr/bin/php

<?php

if ($argc > 2)
{
  for ($i = 1; $i < count($argv); $i++)
  {
      $tmp = explode(':', $argv[$i]);
      if (isset($tmp[0]) && isset($tmp[1]))
        $tab[$tmp[0]] = $tmp[1];
      else if (isset($tmp[0]))
        $search = $tmp[0];
  }
  if ($key = array_key_exists($search, $tab))
    echo $tab[$search] . "\n";
}

?>
