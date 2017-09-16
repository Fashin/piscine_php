#!/usr/bin/php

<?php

if ($argc > 1)
{
  if ($argv[1] == "mais pourquoi cette demo ?")
    echo "Tout simplement pour qu'en feuilletant le sujet\non se s'apercoive pas de la nature de l'exo\n";
  else if ($argv[1] == "mais pourquoi cette chanson ?")
    echo "Parce que Kwame a des enfants\n";
  else if ($argv[1] == "vraiment ?")
  {
    $rep = ["Nan c'est parce que c'est le premier avril", "Oui il a vraiment des enfants"];
    echo $rep[rand(0, 1)] . "\n";
  }
  else
    echo "Je ne sais pas quoi mettre\n";
}

?>
