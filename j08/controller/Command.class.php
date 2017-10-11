<?php

class Command
{
  public $list_cmd = array(
    'help',
    'ship_info',
    'activate',

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
    $this->put_tchat('TODO : l\'aide sur les commandes', '../tmp/tchat',1);
  }

  private function ship_info($cmd)
  {
    session_start();
    $actual_player = $_SESSION['turn'];
    $game = json_decode($_SESSION['data']);
    var_dump($game);
    $players = $game->_players;
    $cmd = (count($cmd) > 1) ? $cmd[1] : false;
    for ($i = 0; $i < count($players); $i++)
    {
      if ($players[$i]->_name == $actual_player)
      {
        $ships = $players[$i]->_ships;
        $txt = "";
        if (!($cmd))
          foreach ($ships as $k => $v)
            $txt = $txt . $v->_name . " ; ";
        else
          foreach ($ships as $k => $v)
            if ($v->_name == $cmd)
              $txt = $v->_name . " : more informations in coming";
        if (empty($txt))
          $this->put_tchat("You don't have the ship : " . $cmd, '../tmp/tchat', 1);
        else
          $this->put_tchat('You have the ships : ' . $txt, '../tmp/tchat', 1);
      }
    }
  }

  public function launch_command($cmd)
  {
    $cmd = explode(' ', $cmd);
    $s_cmd = substr($cmd[0], 1, strlen($cmd[0]));
    for ($i = 0; $i < count($this->list_cmd); $i++)
    {
      if ($s_cmd == $this->list_cmd[$i])
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
  //header('Location:../view/input-tchat.php');
}


?>
