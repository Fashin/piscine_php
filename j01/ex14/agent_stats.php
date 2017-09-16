#!/usr/bin/php

<?php

function moyenne($file)
{
  $calc = 0;
  for ($i = 1; $i < count($file); $i++)
  {
    $data = explode(';', $file[$i]);
    if (isset($data[1]))
      $calc += intval($data[1]);
  }
  echo $calc / $i . "\n";
}

function moyenne_user($file)
{
}

function ecart_moulinette($file)
{
  echo "Cette fonction est actuellement indisponible\n";
}

if ($argc == 2)
{
    while($file[] = fgets(STDIN));
    $commands = array("1" => "moyenne", "2" => "moyenne_user", "3" => "ecart_moulinette");
    if (($key = array_search($argv[1], $commands)))
      $commands[$key]($file);
}


?>
