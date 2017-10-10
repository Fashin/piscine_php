<?php

class Command
{
  public $list_cmd = array(
    'help',
  );

  public function put_tchat($text, $path, $is_player = 0)
  {
    $text = htmlspecialchars($text);
    if ($text[0] == '/')
      $this->launch_command($text);
    else
    {
      $content = unserialize(file_get_contents($path));
      if ($content)
      {
        $content[] = array('login' => ($is_player) ? 'Game Master' : 'Player', 'text' => $text);
        file_put_contents($path, serialize($content));
      }
      else
      {
        file_put_contents($path, serialize(array(array(
          'login' => ($is_player) ? 'Game Master' : 'Player',
          'text'  =>  $text,
        ))));
      }
    }
  }

  private function help($cmd)
  {
    $this->put_tchat('TODO : l\'aide sur les commandes', 1);
  }

  public function launch_command($cmd)
  {
    $cmd = substr($cmd, 1, strlen($cmd));
    for ($i = 0; $i < count($this->list_cmd); $i++)
    {
      if ($cmd == $this->list_cmd[$i])
      {
        $exec = $this->list_cmd[$i];
        $this->$exec($cmd);
        break ;
      }
    }
  }
}

if (isset($_POST['command']) && !empty($_POST['command']))
{
  $command = new Command();
  $command->put_tchat($_POST['command'], '../tmp/tchat');
  header('Location:../view/input-tchat.php');
}


?>
