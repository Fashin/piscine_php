#!/usr/bin/php
<?php

if ($argc == 3)
{
  $file = $argv[1];
  $search = $argv[2];
  if (($fd = fopen($file, 'r')))
  {
    $key_search = explode(';', fgets($fd));
    $key_search[4] = substr($key_search[4], 0, strlen($key_search[4]) - 1);
    $save = array_search($search, $key_search);
    while (($line = fgets($fd)) !== FALSE)
    {
      $line = explode(';', $line);
      $tab_name = ($save == 4) ? substr($line[$save], 0, strlen($line[$save]) - 1) : $line[$save];
      $nom[$tab_name] = $line[0];
      $prenom[$tab_name] = $line[1];
      $mail[$tab_name] = $line[2];
      $IP[$tab_name] = $line[3];
      $pseudo[$tab_name] = substr($line[4], 0, strlen($line[4]) - 1);
    }
    fclose($fd);
    while (1)
    {
      echo "Entrez votre commamnde : ";
      $commands = fgets(STDIN);
      if (feof(STDIN))
        break ;
      eval($commands);
    }
  }
}

?>
