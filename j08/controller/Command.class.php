<?php

class Command
{
  public $list_cmd = array(
    'help' => help,
  );
}

if (isset($_POST['send']) && isset($_POST['command']) && !empty($_POST['command']))
{
    $content = unserialize(file_get_contents('../tmp/tchat'));
    $text = htmlspecialchars($_POST['command']);
    if ($content)
    {
      $content[] = array('login' => 'TODO:les sessions ?', 'text' => htmlspecialchars($text));
      file_put_contents('../tmp/tchat', serialize($content));
    }
    else
      file_put_contents('../tmp/tchat', serialize(array(array(
        'login' => 'TODO:les sessions ?',
        'text'  =>  htmlspecialchars($text),
      ))));
}

header('Location:../view/input-tchat.php');


?>
