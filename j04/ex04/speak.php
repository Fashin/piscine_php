<?php

date_default_timezone_set('Europe/Berlin');

if ((isset($_POST['submit']) && $_POST['submit'] == "OK")
  && (isset($_POST['msg']) && !empty($_POST['msg'])))
{
  session_start();
  $msg = htmlspecialchars($_POST['msg']);
  $time = date('H:i');
  if (!(file_exists('private')))
    mkdir('prviate');
  if (!(file_exists('private/chat')))
  {
    file_put_contents('private/chat', serialize(array(array(
      'login' => $_SESSION['loggued_on_user'],
      'time' => $time,
      'msg' => $msg
    ))));
  }
  else
  {
    $content = unserialize(file_get_contents('private/chat'));
    $content[] = array(
      'login' => $_SESSION['loggued_on_user'],
      'time' => $time,
      'msg' => $msg,
    );
    file_put_contents('private/chat', serialize($content));
  }
  ?>
  <script langage="javascript">top.frames['chat'].location = 'chat.php';</script>
  <?php
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <form action="#" method="post">
      <input type="text" name="msg" style="width:80%; height: 100%;">
      <input type="submit" name="submit" value="OK" style="width: 15%; height: 100%;">
    </form>
  </body>
</html>
