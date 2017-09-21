<?php
  session_start();
  if (isset($_GET['submit']) && $_GET['submit'] != 'OK')
  {
    $login = (isset($_GET['login']) && !empty($_GET['login'])) ? $_GET['login'] : $_SESSION['login'];
    $passwd = (isset($_GET['passwd']) && !empty($_GET['passwd'])) ? $_GET['passwd'] : $_SESSION['passwd'];
    $_SESSION['login'] = $login;
    $_SESSION['passwd'] = $passwd;
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form action="index.php" method="get">
      <input type="text" name="login" value="<?= $login ?>"><br>
      <input type="password" name="passwd"value="<?= $passwd ?>"><br>
      <input type="submit" name="submit" value="OK">
    </form>
  </body>
</html>
