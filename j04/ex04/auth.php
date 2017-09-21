<?php

function auth($login, $passwd)
{
    $filename = "private/passwd";
    if (!(file_exists('private')) || !(file_exists($filename)))
      return (FALSE);
    else
    {
      $content = unserialize(file_get_contents($filename));
      $salt1 = "#ejghnoubgihe@bagi10rtg102r?";
      $salt2 = "~lhebglihbr!tah0rt4h8d04r35g4d&";
      $passwd = hash('whirlpool', $salt1 . $passwd . $salt2);
      foreach ($content as $key => $val)
        if ($val['login'] == $login && $val['passwd'] == $passwd)
          return (TRUE);
      return (FALSE);
    }
}

?>
