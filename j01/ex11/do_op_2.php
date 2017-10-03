#!/usr/bin/php
<?php

function find_operand($tab, $str)
{
  foreach ($tab as $key => $value)
    if (strpos($str, $value))
      return ($key);
  return (-1);
}

function find_numeric($tab, $split, $input)
{
  if ($split >= 0)
  {
    $chiffres = explode($tab[$split], $input);
    if (isset($chiffres[0]) && isset($chiffres[1]))
    {
      $first_num = array_values(array_filter(explode(' ', $chiffres[0])))[0];
      $second_num = array_values(array_filter(explode(' ', $chiffres[1])))[0];
      if ((is_numeric($first_num) || $first_num == 0) && is_numeric($second_num) || $second_num == 0)
      {
        $ret[] = $first_num;
        $ret[] = $second_num;
        $ret[] = $split;;
        return ($ret);
      }
      else
        return (FALSE);
    }
    else
      return (FALSE);
  }
  return (FALSE);
}

if ($argc == 2)
{
  $operand = array('+', '-', '*', '/', '%');
  if ($tab = find_numeric($operand, find_operand($operand, $argv[1]), $argv[1]))
  {
    if ($operand[$tab[2]] == '+') echo $tab[0] + $tab[1] . "\n";
    else if ($operand[$tab[2]] == '-') echo $tab[0] - $tab[1] . "\n";
    else if ($operand[$tab[2]] == '*') echo $tab[0] * $tab[1] . "\n";
    else if ($operand[$tab[2]] == '/') echo $tab[0] / $tab[1] . "\n";
    else if ($operand[$tab[2]] == '%') echo $tab[0] % $tab[1] . "\n";
    else
      echo "Syntax Error\n";
  }
  else
    echo "Syntax Error\n";
}
else
  echo "Incorrect Parameters\n";

?>
