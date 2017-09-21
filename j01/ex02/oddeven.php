#!/usr/bin/php
<?php

  while (1)
  {
    echo "Entrez un nombre : ";
    $rep = fgets(STDIN);
    if (feof(STDIN))
      break ;
    else
    {
      if (preg_match('/[0-9]+/', $rep))
      {
        $rep = intval($rep);
        if ($rep % 2 == 0)
          echo $rep . " est un chiffre Pair\n";
        else
          echo $rep . " est un chiffre Impair\n";
      }
      else
      {
        $rep = rtrim($rep);
        echo $rep . " n'est pas un chiffre\n";
      }
    }
  }
?>
