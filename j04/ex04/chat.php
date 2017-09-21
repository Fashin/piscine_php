<?php

$filename = 'private/chat';
if (file_exists($filename))
{
  header('Refresh : 2; chat.php', true, 303);
  $content = unserialize(file_get_contents($filename));
  if (!empty($content))
    foreach ($content as $key => $val)
      echo "[ " . $val['time'] . "] <b> " . $val['login']. " </b> : " . $val['msg'] . "<br>";
}

?>
