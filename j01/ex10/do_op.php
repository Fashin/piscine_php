#!/usr/bin/php
<?php

function display_array($tab)
{
  for ($i = 0; $i < count($tab); $i++)
    echo $tab[$i] . "\n";
}

if ($argc == 4)
{
  $first_number = array_values(array_filter(explode(' ', $argv[1])))[0];
  $operand = array_values(array_filter(explode(' ', $argv[2])))[0];
  $seconde_number = array_values(array_filter(explode(' ', $argv[3])))[0];
  if ($operand == '+') echo $first_number + $seconde_number . "\n";
  else if ($operand == '-') echo $first_number - $seconde_number . "\n";
  else if ($operand == '*') echo $first_number * $seconde_number . "\n";
  else if ($operand == '/') echo $first_number / $seconde_number . "\n";
  else if ($operand == '%') echo $first_number % $seconde_number . "\n";
  else
    echo "Incorrect operand\n";
}
else
  echo "Incorrect Parameters\n";

?>
