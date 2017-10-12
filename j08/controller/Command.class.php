<?php

class Command
{
  public $list_cmd = array(
    'help' => "Get all the command for play at this game",
    'ship_info' => "Get informations on all of your ship, if you specify a ship name, return more informations",
    'activate' => "Activate a ship",
    'attribute' => "Attribute your power point. sequence : /attribute [vitesse | bouclier | armes | health] [number of points] if you activate \"armes\" name specified",
    'next' => "Finish your phase turn and go to the next phase",
    'moveTo' => "Move your activated ship, /moveTo [right | left | top | bottom] [number of case your want]",
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

  private function next($cmd)
  {
    /**
     * Maybe needed to review this, for exemple with the ship activation and for see the next phase appel
     */
    session_start();
    if ($_SESSION['phase'] > 0)
    {
      if ($_SESSION['phase'] + 1 < 4)
        $_SESSION['phase'] = $_SESSION['phase'] + 1;
      else
        $_SESSION['phase'] = 0;
    }
  }

  private function moveTo($cmd)
  {
    session_start();
    if ($_SESSION['phase'] == 1)
    {
      $game = json_decode($_SESSION['data']);
      $player = $game->_players[$_SESSION['turn']];
      $ships = $player->_ships;
      $ship = null;
      foreach ($ships as $k => $v)
        if ($v->is_activated)
          $ship = $v->orientation;
      if ($ship)
      {

      }
    }
  }

  private function help($cmd)
  {
    if (isset($cmd[1]))
    {
      if (in_array($cmd[1], array_keys($this->list_cmd)))
        $this->put_tchat($this->list_cmd[$cmd[1]], '../tmp/tchat', 1);
      else
        $this->put_tchat('This command don\'t exists, type /help for see the list of the command', '../tmp/tchat', 1);
    }
    else
    {
      $this->put_tchat("You can use the following command :", '../tmp/tchat', 1);
      foreach ($this->list_cmd as $k => $v)
      {
        $txt = "=>" . $k . " : " . $v;
        $this->put_tchat($txt, '../tmp/tchat', 1);
      }
    }
  }

  private function attribute($cmd)
  {
    session_start();
    if ($_SESSION['phase'] == 0)
    {
      $actual_player = $_SESSION['turn'];
      $game = json_decode($_SESSION['data']);
      $players = $game->_players;
      $types = array('vitesse', 'bouclier', 'armes' ,'health');
      if (isset($cmd[1]) && in_array($cmd[1], $types) && isset($cmd[2]))
      {
        $val = intval($cmd[2]);
        $game = json_decode($_SESSION['data']);
        $types = $cmd[1];
        $players = $game->_players;
        $actual_player = $_SESSION['turn'];
        if (isset($players[$actual_player]))
        {
          $player = $players[$actual_player];
          $ships = $player->_ships;
          $ship = null;
          $id_ship = null;
          foreach ($ships as $k => $v)
          {
            if ($v->is_activated == 1)
            {
              $ship = $v;
              $id_ship = $k;
            }
          }
          $continue = true;
          if ($ship)
          {
            if ($ship->_cara->pp_actual == -1 && $ship->_cara->pp - $val >= 0)
              $ship->_cara->pp_actual = $ship->_cara->pp - $val;
            else if ($ship->_cara->pp_actual - $val >= 0)
              $ship->_cara->pp_actual = $ship->_cara->pp_actual - $val;
            else
            {
              $continue = false;
              $this->put_tchat("You don't have enougth power point", '../tmp/tchat', 1);
            }
          }
        }
        if ($continue)
        {
          if ($types == 'vitesse')
          {
            $des = 0;
            for ($i = 0; $i < $val; $i++)
              $des = $des + rand(1, 6);
            $ship->_cara->vitesse =  $ship->_cara->vitesse + $des;
            $this->put_tchat('Ship ' . $ship->_name . ' have now : ' . $ship->_cara->vitesse . ' speed', '../tmp/tchat', 1);
          }
          else if ($types == 'health')
          {
            if ($ship->_cara->health == $ship->_cara->health_max)
              $this->put_tchat('Ship ' . $ship->_name . ' is already full life', '../tmp/tchat', 1);
            else
            {
              $this->put_tchat('Launch ' . $val . 'D6...', '../tmp/tchat', 1);
              for ($i = 0; $i < $val; $i++)
              {
                $des = rand(1, 6);
                if ($des == 6)
                {
                  $ship->_cara->health = $ship->_cara->health + 1;
                  $this->put_tchat($des . ' ship ' . $ship->_name . ' have now ' . $ship->_cara->health . ' health', '../tmp/tchat', 1);
                }
                else
                  $this->put_tchat($des . ' ship ' . $ship->_name . ' isn\'t repaire', '../tmp/tchat', 1);
              }
            }
          }
          else if ($types == 'bouclier')
          {
            $ship->_cara->bouclier = $ship->_cara->bouclier + $val;
            $this->put_tchat('You have now ' . $ship->_cara->bouclier . ' shield point', '../tmp/tchat', 1);
          }
          else if ($types == 'armes')
          {
            if (isset($cmd[3]))
            {
              $armes = $ship->armes;
              $find_weapon = false;
              foreach ($armes as $k => $v)
              {
                if ($v->name == $cmd[3])
                {
                  $des = 0;
                  for ($i = 0; $i < $val; $i++)
                    $des = $des + rand(1, 6);
                  $ship->armes[$k]->charge = $des;
                  $this->put_tchat('The weapon ' . $ship->armes[$k]->name . ' have now ' . $ship->armes[$k]->charge . ' charge point', '../tmp/tchat', 1);
                  $find_weapon = true;
                }
              }
            }
            else
              $this->put_tchat('Please specified a weapon name', '../tmp/tchat', 1);
          }
          if ($ship->_cara->pp_actual > 0)
          {
            $this->put_tchat('You have : ' . $ship->_cara->pp_actual . ' power point', '../tmp/tchat', 1);
            $game->_players[$actual_player]->_ships[$id_ship] = $ship;
            $_SESSION['data'] = json_encode($game);
          }
          else
          {
            $this->put_tchat('Order phase terminated', '../tmp/tchat', 1);
            $_SESSION['phase'] = 1;
            $game->_players[$actual_player]->_ships[$id_ship] = $ship;
            $_SESSION['data'] = json_encode($game);
          }
        }
      }
      else
        $this->put_tchat('Please write a type for attribute your point or attribute a value /help activate', '../tmp/tchat', 1);
    }
    else
      $this->put_tchat('Please finish your turn before attribute point at a new ship', '../tmp/tchat', 1);
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
  header('Location:../view/input-tchat.php');
}


?>
