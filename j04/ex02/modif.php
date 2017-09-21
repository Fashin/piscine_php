<?php
if ((isset($_POST['login']) && !empty($_POST['login']))
  && (isset($_POST['oldpwd']) && !empty($_POST['oldpwd']))
  && (isset($_POST['newpw']) && !empty($_POST['newpw']))
  && isset($_POST['submit']) && $_POST['submit'] == "OK")
  {
    $filename = 'private/passwd';
    $salt1 = "#ejghnoubgihe@bagi10rtg102r?";
    $salt2 = "~lhebglihbr!tah0rt4h8d04r35g4d&";
    $oldpwd = hash('whirlpool', $salt1 . $_POST['oldpwd'] . $salt2);
    $newpwd = hash('whirlpool', $salt1 . $_POST['newpw'] . $salt2);
    $login = $_POST['login'];
    if (!(file_exists('private')) || !(file_exists($filename)))
      echo "ERROR\n";
    else
    {
      $content = unserialize(file_get_contents($filename));
      $is_subscribe = 0;
      foreach ($content as $key => $val)
      {
          if ($val['login'] == $login && $val['passwd'] == $oldpwd)
          {
            $is_subscribe = 1;
            $content[$key]['passwd'] = $newpwd;
            file_put_contents($filename, serialize($content));
          }
      }
      if ($is_subscribe)
        echo "OK\n";
      else
        echo "ERROR\n";
    }
  }
  else
    echo "ERROR\n";
?>
