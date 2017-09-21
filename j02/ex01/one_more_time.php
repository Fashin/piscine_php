#!/usr/bin/php

<?php

if ($argc != 2)
  return (1);
if (!(date_default_timezone_set('Europe/Berlin')))
  echo "Error from setting timezone\n";
$pattern = '/([a-zA-Z]+)\s{1}([0-9]+){2}\s{1}([a-zA-Z])+\s{1}([0-9]+){4}\s{1}([0-9]{2}:{1}){2}([0-9]){2}/';
if (preg_match($pattern, $argv[1]))
{
  $day = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche');
  $month = array('janvier', 'fevrier', 'mars', 'avril', 'mai', 'juin', 'juillet', 'aout', 'septembre', 'octobre', 'novembre', 'decembre');
  $date = explode(' ', $argv[1]);
  if (array_search(strtolower($date[0]), $day) && array_search(strtolower($date[2]), $month))
  {
    $date = $date[1] . '-' . array_keys($month, strtolower($date[2]))[0] . '-' . $date[3] . ' ' . $date[4];
    if ($timestamp = strtotime($date))
      echo $timestamp . "\n";
  }
  else
    echo "Wrong Format\n";
}
else
  echo "Wrong Format\n";

?>
