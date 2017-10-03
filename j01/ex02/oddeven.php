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
        $num = $rep[strlen($rep) - 1];
		$rep = rtrim($rep);
        if ($num % 2 == 0)
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
