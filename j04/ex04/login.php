<?php

if ((isset($_POST['login']) && !empty($_POST['login']))
  && (isset($_POST['passwd']) && !empty($_POST['passwd']))
  && (isset($_POST['submit']) && !empty($_POST['submit'])) && $_POST['submit'] == "OK")
  {
    session_start();
    include('auth.php');
    if (auth($_POST['login'], $_POST['passwd']))
    {
      $_SESSION['loggued_on_user'] = $_POST['login'];
      ?>
      <!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Bienvenue dans l'espace de discution</title>
        </head>
        <body>
          <iframe src="chat.php" name="chat" width="100%" height="550px"></iframe>
          <iframe src="speak.php" name="speak" width="100%" height="50px"></iframe>
        </body>
      </html>
      <?php
    }
    else
    {
      $_SESSION['loggued_on_user'] = "";
      header('Refresh :1; index.html', true, 303);
      echo "ERROR\n";
      exit;
    }
  }
  else
  {
    header('Refresh :1; index.html', true, 303);
    echo "ERROR\n";
    exit;
  }

?>
