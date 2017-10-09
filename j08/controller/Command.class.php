<?php

class Command
{
  public $list_cmd = array(
    'help',
  );

  private function help($cmd)
  {
    
  }

  public static function launch_command($cmd)
  {
    $cmd = substr($cmd, 1, strlen($cmd));
    for ($i = 0; $i < count($this->list_cmd); $i++)
      if ($cmd == $this->list_cmd[$i])
      {
        $exec = $this->list_cmd[$i];
        $this->$exec($cmd);
        break ;
      }
  }
}

if (isset($_POST['command']) && !empty($_POST['command']))
{
    $content = unserialize(file_get_contents('../tmp/tchat'));
    $text = htmlspecialchars($_POST['command']);
    if ($content)
    {
      if ($text[0] == '/')
        Command::launch_command($text);
      $content[] = array('login' => 'TODO:les sessions ?', 'text' => htmlspecialchars($text));
      file_put_contents('../tmp/tchat', serialize($content));
    }
    else
      file_put_contents('../tmp/tchat', serialize(array(array(
        'login' => 'TODO:les sessions ?',
        'text'  =>  htmlspecialchars($text),
      ))));
}

//header('Location:../view/input-tchat.php');


?>
