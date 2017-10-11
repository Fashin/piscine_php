<?php

class Command
{
  public $list_cmd = array(
    'help' => "Get all the command for play at this game",
    'ship_info' => "Get informations on all of your ship, if you specify a ship name, return more informations",
    'activate' => "Activate a ship",
    'attribute' => "Attribute your power point. sequence : /attribute [vitesse | bouclier | armes | health] [number of points]",
  );

  public function put_tchat($text, $path, $is_player = 0, $display_name = 1)
  {
    $text = htmlspecialchars($text);
    if ($text[0] == '/')
      $this->launch_command($text);
    else
    {
      $content = unserialize(file_get_contents($path));
      $login = ($display_name) ? ($is_player) ? 'Game Master' : 'Player' : "";
      if ($content)
      {
        $content[] = array('login' => $login, 'text' => $text);
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
    $this->put_tchat("You can use the following command :", '../tmp/tchat', 1);
    foreach ($this->list_cmd as $k => $v)
    {
      $txt = "=>" . $k . " : " . $v;
      $this->put_tchat($txt, '../tmp/tchat', 1);
    }
  }

  private function attribute($cmd)
  {
    session_start();
    $actual_player = $_SESSION['turn'];
    $game = json_decode($_SESSION['data']);
    $players = $game->_players;
    
  }

  private function activate($cmd)
  {
    if (!isset($cmd[1]))
      $this->put_tchat("Please insert a ship name", '../tmp/tchat', 1);
    else
    {
      session_start();
      $game = json_decode($_SESSION['data']);
      $players = $game->_players;
      $actual_player = $_SESSION['turn'];
      $name_player = $_SESSION['name'];
      if (isset($players[$actual_player]) && $players[$actual_player]->_name == $name_player)
      {
        $ships = $players[$actual_player]->_ships;
        $have_ship = false;
        $activate_in_running = false;
        foreach ($ships as $k => $v)
          if ($v->is_activated == 1)
            $activate_in_running = true;
        if (!($activate_in_running))
        {
          foreach ($ships as $k => $v)
          {
            if ($cmd[1] == $v->_name)
            {
              $have_ship = true;
              $this->put_tchat("You have activated the following ship : " . $cmd[1], '../tmp/tchat', 1);
              $this->put_tchat("* * * * * * * * * *", '../tmp/tchat', 1, 0);
              $this->put_tchat("-> Phase d'ordre <-", '../tmp/tchat', 1, 0);
              $this->put_tchat("* * * * * * * * * *", '../tmp/tchat', 1, 0);
              $this->put_tchat($cmd[1] . " have : " . $v->_cara->pp . " power point", '../tmp/tchat', 1, 0);
              $game->_players[$actual_player]->_ships[$k]->is_activated = 1;
              $_SESSION['data'] = json_encode($game);
            }
          }
        }
        if ($activate_in_running)
          $this->put_tchat("You can't activate a new ship now, finish your turn before", '../tmp/tchat', 1);
        if (!($have_ship) && !($activate_in_running))
          $this->put_tchat("You don't have the ship : " . $cmd[1], '../tmp/tchat', 1);
      }
    }
  }

  private function ship_info($cmd)
  {
    session_start();
    $actual_player = $_SESSION['turn'];
    $game = json_decode($_SESSION['data']);
    $players = $game->_players;
    $cmd = (count($cmd) > 1) ? $cmd[1] : false;
    if (isset($players[$actual_player]) && $players[$actual_player]->_name == $_SESSION['name'])
    {
      $player = $players[$actual_player];
      $ships = $player->_ships;
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

  public function launch_command($cmd)
  {
    $cmd = explode(' ', $cmd);
    $s_cmd = substr($cmd[0], 1, strlen($cmd[0]));
    $list_cmd = array_keys($this->list_cmd);
    for ($i = 0; $i < count($list_cmd); $i++)
    {
      if ($s_cmd == $list_cmd[$i])
      {
        $exec = $list_cmd[$i];
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
