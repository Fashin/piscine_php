<?php

  if ((isset($_POST['login']) && !empty($_POST['login']))
    && (isset($_POST['passwd']) && !empty($_POST['passwd']))
    && isset($_POST['submit']) && $_POST['submit'] == "OK")
    {
      $filename = 'private/passwd';
      $salt1 = "#ejghnoubgihe@bagi10rtg102r?";
      $salt2 = "~lhebglihbr!tah0rt4h8d04r35g4d&";
      $passwd = hash('whirlpool', $salt1 . $_POST['passwd'] . $salt2);
      $login = $_POST['login'];
      if (!(file_exists('private')))
        mkdir('private');
      if (!(file_exists($filename)))
      {
        $bool = file_put_contents($filename, serialize(array(array(
          'login'   => $login,
          'passwd'  =>  $passwd,
        ))));
        if ($bool)
          echo "OK\n";
        else
          echo "ERROR\n";
      }
      else
      {
        $content = unserialize(file_get_contents($filename));
        $subscribe = 0;
        foreach ($content as $key => $val)
        {
          if ($val['login'] == $login)
            $subscribe = 1;
        }
        if ($subscribe == 0)
        {
          $content[] = array('login' => $login, 'passwd' => $passwd);
          file_put_contents($filename, serialize($content));
          echo "OK\n";
        }
        else
          echo "ERROR\n";
      }
    }
  else
    echo "ERROR\n";

?>
