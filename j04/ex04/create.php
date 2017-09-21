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
        {
          header('Refresh :1; index.html', true, 303);
          echo "OK\n";
          exit;
        }
        else
        {
          header('Refresh :1; create.php', true, 303);
          echo "ERROR\n";
          exit;
        }
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
          header('Refresh :1; index.html', true, 303);
          echo "OK\n";
          exit;
        }
        else
        {
          header('Refresh :1; create.php', true, 303);
          echo "ERROR\n";
          exit;
        }
      }
    }
  else
  {
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Create My Account</title>
  </head>
  <body>
    <form action="#" method="post">
      <input type="text" name="login"><br>
      <input type="password" name="passwd"><br>
      <input type="submit" name="submit" value="OK">
    </form>
  </body>
</html>
<?php
}
?>
