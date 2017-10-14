<?php

error_reporting(0);

class Command
{
  public $list_cmd = array(
    'help' => "Get all the command for play at this game",
    'ship_info' => "Get informations on all of your ship, if you specify a ship name, return more informations",
    'activate' => "Activate a ship",
    'attribute' => "Attribute your power point. sequence : /attribute [vitesse | bouclier | armes | health] [number of points] if you activate \"armes\" name specified",
    'next' => "Finish your phase turn and go to the next phase",
    'moveTo' => "Move your activated ship, /moveTo [east | west | north | south] [number of case you want]",
    'shoot' => "Shoot on an enemy with a specified weapon name only if you have a direct line, /shoot [weapon name]",
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
     * Maybe needed to review this, for exemple with the ship activation and for see the next phase calling and switch player ?
     */
    session_start();
    if ($_SESSION['phase'] + 1 < 3)
    {
      $_SESSION['phase'] = $_SESSION['phase'] + 1;
      if ($_SESSION['phase'] == 1)
      {
        $this->put_tchat("* * * * * * * * * * * * *", '../tmp/tchat', 1, 0);
        $this->put_tchat("-> Phase de mouvement <-", '../tmp/tchat', 1, 0);
        $this->put_tchat("* * * * * * * * * * * * *", '../tmp/tchat', 1, 0);
      }
      else
      {
        $this->put_tchat("* * * * * * * * * *", '../tmp/tchat', 1, 0);
        $this->put_tchat("-> Phase de tirs <-", '../tmp/tchat', 1, 0);
        $this->put_tchat("* * * * * * * * * *", '../tmp/tchat', 1, 0);
      }
    }
    else
    {
      $game = json_decode($_SESSION['data'], true);
      $ship_id = null;
      foreach ($game['_players'][$_SESSION['turn']]['_ships'] as $k => $v)
        if ($v['is_activated'] == 1)
          $ship_id = $k;
      $game['_players'][$_SESSION['turn']]['_ships'][$ship_id]['_cara']['shield'] = 0;
      $game['_players'][$_SESSION['turn']]['_ships'][$ship_id]['_cara']['pp_actual'] = $game['_players'][$_SESSION['turn']]['_ships'][$ship_id]['_cara']['pp'];
      $game['_players'][$_SESSION['turn']]['_ships'][$ship_id]['_cara']['is_moving'] = 1;
      $game['_players'][$_SESSION['turn']]['_ships'][$ship_id]['_cara']['vitesse'] = $game['_players'][$_SESSION['turn']]['_ships'][$ship_id]['_cara']['const_vitesse'];;;
      $game['_players'][$_SESSION['turn']]['_ships'][$ship_id]['is_activated'] = 2;
      $_SESSION['turn'] = ($_SESSION['turn'] == 0) ? 1 : 0;
      $_SESSION['name'] = $name;
      $new_player = $game['_players'][$_SESSION['turn']];
      $_SESSION['name'] = $new_player['_name'];
      $_SESSION['phase'] = 0;
      $end_turn = true;
      for ($i = 0; $i < count($game['_players']); $i++)
        for ($j = 0; $j < count($game['_players'][$i]['_ships']); $j++)
          if ($game['_players'][$i]['_ships'][$j]['is_activated'] == 0)
            $end_turn = false;
      if ($end_turn)
      {
        for ($i = 0; $i < count($game['_players']); $i++)
          for ($j = 0; $j < count($game['_players'][$i]['_ships']); $j++)
            $game['_players'][$i]['_ships'][$j]['is_activated'] = 0;
        $this->put_tchat("* * * * * * * * * * * * * * * * * *", '../tmp/tchat', 1);
        $this->put_tchat("-> New turn all stats are reset <-", '../tmp/tchat', 1);
        $this->put_tchat("* * * * * * * * * * * * * * * * * *", '../tmp/tchat', 1);
      }
      $_SESSION['data'] = json_encode($game);
      $this->put_tchat("Its turn to " . $_SESSION['name'] . " please activate a ship", '../tmp/tchat', 1);
      $this->put_tchat("* * * * * * * * * * * * *", '../tmp/tchat', 1, 0);
      $this->put_tchat("-> Phase d'activation <-", '../tmp/tchat', 1, 0);
      $this->put_tchat("* * * * * * * * * * * * *", '../tmp/tchat', 1, 0);
    }
  }

  /**
   * here you need to soustraire les points de vitesse utilise avec les points de vitesse disponible avant de push /!\
   * Compter le nombre de points de vitesse restant avant de passer a la phase de shoot
   * peut etre gerer les obstacles au passage ? et le fait de sortir du plateau
   * @param  [type] $cmd [description]
   * @return [type]      [description]
   */
  private function moveTo($cmd)
  {
    session_start();
    if ($_SESSION['phase'] == 1)
    {
      if (isset($cmd[1]) && $cmd[2])
      {
        $game = json_decode($_SESSION['data'], true);
        $player = $game['_players'][$_SESSION['turn']];
        $ships = $player['_ships'];
        $ship = null;
        $id_ship = null;
        foreach ($ships as $k => $v)
        {
          if ($v['is_activated'])
          {
            $ship = $v;
            $id_ship = $k;
          }
        }
        if ($ship)
        {
          $direction = strtoupper($cmd[1]);
          $value = intval($cmd[2]);
          $possible_direction = array('WEST', 'NORTH', 'EAST', 'SOUTH');
          if (!(in_array($direction, $possible_direction)))
            $this->put_tchat("Please write a correct direction", '../tmp/tchat', 1);
          else
          {
            /*
            *   For the rush, this comportment don't check the rules "if you move value < manoeuvre"
            *   vous n'etes plus considerer comme immobile mais activable seulement si vous etes immobile
             */
             if ($ship['_cara']['is_moving'] > 0 && $value < $ship['_cara']['manoeuvre'])
              $this->put_tchat("You are in movement, you can't moving less than : " . $ship['_cara']['manoeuvre'], '../tmp/tchat', 1);
            else
            {
              $speed = $ship['_cara']['vitesse'];
              if ($speed - $value >= 0)
              {
                $board = unserialize(file_get_contents('../tmp/board'));
                $obstacle = false;
                $start_x = intval($ship['_cara']['pos_x']);
                $start_y = intval($ship['_cara']['pos_y']);
                $height = intval($ship['_cara']['height']);
                $width = intval($ship['_cara']['width']);
                $new_direction = -1;
                $length = count($possible_direction);
                for ($i = 0; $i < $length; $i++)
                {
                  if ($direction == $possible_direction[$i])
                  {
                    if ($i == 0)
                      $new_direction = 1;
                    else if ($i == $length - 1)
                      $new_direction = 0;
                    else
                    {
                      if ($ship['orientation'] == $possible_direction[$i - 1])
                      $new_direction = 1;
                    else
                      $new_direction = 0;
                    }
                  }
                }
                if (($new_direction == 0 || $new_direction == 1) || $direction == $ship->orientation)
                {
                    if ($direction == "NORTH")
                    {
                      $x = $start_x - $value;
                      if ($x >= 0 && $x < count($board))
                      {
                        for ($i = 0; $i < $width; $i++)
                        {
                          $board[$x][$start_y] = strtoupper($player['_color'][0]);
                          $x++;
                        }
                      }
                      $pos_x = $start_x - $value;
                      $pos_y = $start_y;
                    }
                    else if ($direction == "SOUTH")
                    {
                      $x = $start_x + $value;
                      if ($x >= 0 && $x < count($board))
                      {
                        for ($i = 0; $i < $width; $i++)
                        {
                          $board[$x][$start_y] = strtoupper($player['_color'][0]);
                          $x--;
                        }
                      }
                      $pos_x = $start_x + $value;
                      $pos_y = $start_y;
                    }
                    else if ($direction == "EAST")
                    {
                      $y = $start_y + $value;
                      if ($y >= 0 && $y < count($board[$start_x]))
                      {
                        for ($i = 0; $i < $width; $i++)
                        {
                          $board[$start_x][$y] = strtoupper($player['_color'][0]);
                          $y--;
                        }
                      }
                      $pos_x = $start_x;
                      $pos_y = $start_y + $value;
                    }
                    else if ($direction == "WEST")
                    {
                      $y = $start_y - $value;
                      if ($y >= 0 && $y < count($board[$start_x]));
                      {
                        for ($i = 0; $i < $width; $i++)
                        {
                          $board[$start_x][$y] = strtoupper($player['_color'][0]);
                          $y++;
                        }
                      }
                      $pos_x = $start_x;
                      $pos_y = $start_y - $value;
                    }
                    $i = $height;
                    while ($i > 0)
                    {
                      $j = $width;
                      while ($j >= 0)
                      {
                        $board[$start_x][$start_y] = '.';
                        if ($ship['orientation'] == "EAST")
                          $start_y = $start_y - 1;
                        else if ($ship['orientation'] == "WEST")
                          $start_y = $start_y + 1;
                        else if ($ship['orientation'] == "NORTH")
                          $start_x = $start_x + 1;
                        else if ($ship['orientation'] == "SOUTH")
                          $start_x = $start_x - 1;
                        $j--;
                      }
                      $i--;
                    }
                    $game['_players'][$_SESSION['turn']]['_ships'][$id_ship]['orientation'] = $direction;
                    $game['_players'][$_SESSION['turn']]['_ships'][$id_ship]['_cara']['pos_x'] = $pos_x;
                    $game['_players'][$_SESSION['turn']]['_ships'][$id_ship]['_cara']['pos_y'] = $pos_y;
                    $game['_players'][$_SESSION['turn']]['_ships'][$id_ship]['_cara']['vitesse'] = $speed - $value;
                    $_SESSION['data'] = json_encode($game);
                    file_put_contents('../tmp/board', serialize($board));
                    if ($speed - $value == 0)
                    {
                      $_SESSION['phase'] = 2;
                      $this->put_tchat("* * * * * * * * * *", '../tmp/tchat', 1, 0);
                      $this->put_tchat("-> Phase de tirs <-", '../tmp/tchat', 1, 0);
                      $this->put_tchat("* * * * * * * * * *", '../tmp/tchat', 1, 0);
                    }
                  }
                  else
                    $this->put_tchat("You can't move more 90 degrees right or left", '../tmp/tchat', 1);
                }
              else
                $this->put_tchat("You can't move " . $direction . " of " . $value . " because you have " . $speed . " moving point", '../tmp/tchat', 1);
            }
          }
        }
      }
      else
        $this->put_tchat("Please specify a direction and a value", '../tmp/tchat', 1);
    }
    else
      $this->put_tchat("Please activate a ship or finish your ordre phase before moving", '../tmp/tchat', 1);
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
      $game = json_decode($_SESSION['data'], true);
      $players = $game['_players'];
      $types = array('vitesse', 'bouclier', 'armes' ,'health');
      if (isset($cmd[1]) && in_array($cmd[1], $types) && isset($cmd[2]))
      {
        $val = intval($cmd[2]);
        $types = $cmd[1];
        $players = $game['_players'];
        $actual_player = $_SESSION['turn'];
        if (isset($players[$actual_player]))
        {
          $player = $players[$actual_player];
          $ships = $player['_ships'];
          $ship = null;
          $id_ship = null;
          foreach ($ships as $k => $v)
          {
            if ($v['is_activated'] == 1)
            {
              $ship = $v;
              $id_ship = $k;
            }
          }
          $continue = true;
          if ($ship)
          {
            if ($ship['_cara']['pp_actual'] == -1 && $ship['_cara']['pp'] - $val >= 0)
              $ship['_cara']['pp_actual'] = intval($ship['_cara']['pp']) - $val;
            else if ($ship['_cara']['pp_actual'] - $val >= 0)
              $ship['_cara']['pp_actual'] = intval($ship['_cara']['pp_actual']) - $val;
            else
            {
              $continue = false;
              $this->put_tchat("You don't have enougth power point", '../tmp/tchat', 1);
            }
          }
          else
            $continue = false;
        }
        if ($continue)
        {
          if ($types == 'vitesse')
          {
            $des = 0;
            for ($i = 0; $i < $val; $i++)
            {
              $actual = rand(1, 6);
              $this->put_tchat("You make : " . $actual, '../tmp/tchat', 1);
              $des = $des + $actual;
            }
            $ship['_cara']['vitesse'] =  $ship['_cara']['vitesse'] + $des;
            $this->put_tchat('Ship ' . $ship['_name'] . ' have now : ' . $ship['_cara']['vitesse'] . ' speed', '../tmp/tchat', 1);
          }
          else if ($types == 'health')
          {
            if ($ship['_cara']['health'] == $$ship['_cara']['health_max'])
              $this->put_tchat('Ship ' . $ship['_name'] . ' is already full life', '../tmp/tchat', 1);
            else
            {
              $this->put_tchat('Launch ' . $val . 'D6...', '../tmp/tchat', 1);
              for ($i = 0; $i < $val; $i++)
              {
                $des = rand(1, 6);
                if ($des == 6)
                {
                  $ship['_cara']['health'] = $ship['_name'] + 1;
                  $this->put_tchat($des . ' ship ' . $ship['_name'] . ' have now ' . $ship['_cara']['health'] . ' health', '../tmp/tchat', 1);
                }
                else
                  $this->put_tchat($des . ' ship ' . $ship['_name'] . ' isn\'t repaire', '../tmp/tchat', 1);
              }
            }
          }
          else if ($types == 'bouclier')
          {
            $ship['_cara']['bouclier'] = $ship['_cara']['bouclier'] + $val;
            $this->put_tchat('You have now ' . $ship['_cara']['bouclier'] . ' shield point', '../tmp/tchat', 1);
          }
          else if ($types == 'armes')
          {
            if (isset($cmd[3]))
            {
              $armes = $ship['armes'];
              $find_weapon = false;
              foreach ($armes as $k => $v)
              {
                if ($v['name'] == $cmd[3])
                {
                  $des = 0;
                  for ($i = 0; $i < $val; $i++)
                    $des = $des + rand(1, 6);
                  $ship['armes'][$k]['charge'] = $des;
                  $this->put_tchat('The weapon ' . $ship['armes'][$k]['name'] . ' have now ' . $ship['armes'][$k]['charge'] . ' charge point', '../tmp/tchat', 1);
                  $find_weapon = true;
                }
              }
            }
            else
              $this->put_tchat('Please specified a weapon name', '../tmp/tchat', 1);
          }
          if ($ship['_cara']['pp_actual'] > 0)
          {
            $this->put_tchat('You have : ' . $ship['_cara']['pp_actual'] . ' power point', '../tmp/tchat', 1);
            $game['_players'][$actual_player]['_ships'][$id_ship] = $ship;
            $_SESSION['data'] = json_encode($game);
          }
          else
          {
            $_SESSION['phase'] = 1;
            $game['_players'][$actual_player]['_ships'][$id_ship] = $ship;
            $_SESSION['data'] = json_encode($game);
            $this->put_tchat("* * * * * * * * * * * * *", '../tmp/tchat', 1, 0);
            $this->put_tchat("-> Phase de mouvement <-", '../tmp/tchat', 1, 0);
            $this->put_tchat("* * * * * * * * * * * * *", '../tmp/tchat', 1, 0);
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
      $game = json_decode($_SESSION['data'], true);
      $players = $game['_players'];
      $actual_player = $_SESSION['turn'];
      $name_player = $_SESSION['name'];
      if (isset($players[$actual_player]) && $players[$actual_player]['_name'] == $name_player)
      {
        $ships = $players[$actual_player]['_ships'];
        $have_ship = false;
        if ($_SESSION['phase'] == 0)
        {
          foreach ($ships as $k => $v)
          {
            if ($cmd[1] == $v['_name'] && $v['is_activated'] != 2)
            {
              $have_ship = true;
              $this->put_tchat("You have activated the following ship : " . $cmd[1], '../tmp/tchat', 1);
              $this->put_tchat("* * * * * * * * * *", '../tmp/tchat', 1, 0);
              $this->put_tchat("-> Phase d'ordre <-", '../tmp/tchat', 1, 0);
              $this->put_tchat("* * * * * * * * * *", '../tmp/tchat', 1, 0);
              $this->put_tchat($cmd[1] . " have : " . $v['_cara']['pp'] . " power point", '../tmp/tchat', 1, 0);
              $game['_players'][$actual_player]['_ships'][$k]['is_activated'] = 1;
              $_SESSION['data'] = json_encode($game);
            }
          }
        }
        else
          $this->put_tchat("You can't activate a new ship now or you have already activated this ship, finish your turn before", '../tmp/tchat', 1);
        if (!($have_ship))
          $this->put_tchat("You don't have the ship or the following ship is already activated : " . $cmd[1], '../tmp/tchat', 1);
      }
    }
  }

  private function ship_info($cmd)
  {
    session_start();
    $actual_player = $_SESSION['turn'];
    $game = json_decode($_SESSION['data'], true);
    $players = $game['_players'];
    $cmd = (count($cmd) > 1) ? $cmd[1] : false;
    if (isset($players[$actual_player]) && $players[$actual_player]['_name'] == $_SESSION['name'])
    {
      $player = $players[$actual_player];
      $ships = $player['_ships'];
      $txt = "";
      if (!($cmd))
        foreach ($ships as $k => $v)
          $txt = $txt . $v['_name'] . " ; ";
      else
        foreach ($ships as $k => $v)
          if ($v['_name'] == $cmd)
            $txt = $v['_name'] . " : more informations in coming";
      if (empty($txt))
        $this->put_tchat("You don't have the ship : " . $cmd, '../tmp/tchat', 1);
      else
        $this->put_tchat('You have the ships : ' . $txt, '../tmp/tchat', 1);
    }
  }

  private function shoot($cmd)
  {
    session_start();
    if ($_SESSION['phase'] == 2)
    {
      if (isset($cmd[1]))
      {
        $game = json_decode($_SESSION['data'], true);
        $turn = $_SESSION['turn'];
        $player = $game['_players'][$turn];
        $name = $_SESSION['name'];
        $ships = $player['_ships'];
        $ship_id = null;
        $ship = null;
        foreach ($ships as $k => $v)
        {
          if ($v['is_activated'])
          {
            $ship_id = $k;
            $ship = $v;
          }
        }
        if ($ship)
        {
            $weapons = $ship['armes'];
            $weapon = null;
            $weapon_id = null;
            foreach ($weapons as $k => $v)
            {
              if ($v['name'] == $cmd[1])
              {
                $weapon = $v;
                $weapon_id = $k;
              }
            }
            if ($weapon)
            {
              $orientation = $ship['orientation'];
              $find_obstacles = false;
              $find_players = false;
              $find_enemy = null;
              $max_range = $weapon['range'][2][1];
              if ($orientation == "NORTH")
              {
                $x = $ship['_cara']['pos_x'] - 1;
                $i = 0;
                $board = unserialize(file_get_contents('../tmp/board'));
                while ($i < $max_range && $x - $i >= 0 && !($find_players) && !($find_obstacles))
                {
                  if (($board[$x - $i][$ship['_cara']['pos_y']] == 'X' ||
                      $board[$x - $i][$ship['_cara']['pos_y']] == strtoupper($player['_color'][0])) &&
                      !($find_players))
                    $find_obstacles = true;
                  else if ($board[$x - $i][$ship['_cara']['pos_y']] != '.' &&
                          $board[$x - $i][$ship['_cara']['pos_y']] != 'X' && !($find_obstacles))
                  {
                    $find_enemy = array($x - $i, $ship['_cara']['pos_y']);
                    $find_players = true;
                  }
                  $i++;
                }
              }
              else if ($orientation == "SOUTH")
              {
                $x = $ship['_cara']['pos_x'] + 1;
                $i = 0;
                $board = unserialize(file_get_contents('../tmp/board'));
                while ($i < $max_range && $x + $i <= count($board) && !($find_players) && !($find_obstacles))
                {
                  if (($board[$x + $i][$ship['_cara']['pos_y']] == 'X' ||
                      $board[$x + $i][$ship['_cara']['pos_y']] == strtoupper($player['_color'][0])) &&
                      !($find_players))
                    $find_obstacles = true;
                  else if ($board[$x + $i][$ship['_cara']['pos_y']] != '.' &&
                          $board[$x + $i][$ship['_cara']['pos_y']] != 'X' && !($find_obstacles))
                  {
                    $find_enemy = array($x + $i, $ship['_cara']['pos_y']);
                    $find_players = true;
                  }
                  $i++;
                }
              }
              else if ($orientation == "EAST")
              {
                $y = $ship->_cara->pos_y + 1;
                $i = 0;
                $board = unserialize(file_get_contents('../tmp/board'));
                while ($i < $max_range && $y + $i <= count($board[$ship['_cara']['pos_x']]) && !($find_players) && !($find_obstacles))
                {
                  if (($board[$ship['_cara']['pos_x']][$y + $i] == 'X' ||
                      $board[$ship['_cara']['pos_x']][$y + $i] == strtoupper($player['_color'][0])) &&
                      !($find_players))
                    $find_obstacles = true;
                  else if ($board[$ship['_cara']['pos_x']][$y + $i] != '.' &&
                          $board[$ship['_cara']['pos_x']][$y + $i] != 'X' && !($find_obstacles))
                  {
                    $find_enemy = array($ship['_cara']['pos_y'], $y + $i);
                    $find_players = true;
                  }
                  $i++;
                }
              }
              else if ($orientation == "WEST")
              {
                $y = $ship['_cara']['pos_y'] - 1;
                $i = 0;
                $board = unserialize(file_get_contents('../tmp/board'));
                while ($i < $max_range && $y - $i >= 0 && !($find_players) && !($find_obstacles))
                {
                  if (($board[$ship['_cara']['pos_x']][$y - $i] == 'X' ||
                      $board[$ship['_cara']['pos_x']][$y - $i] == strtoupper($player['_color'][0])) &&
                      !($find_players))
                    $find_obstacles = true;
                  else if ($board[$ship['_cara']['pos_x']][$y - $i] != '.' &&
                          $board[$ship['_cara']['pos_x']][$y - $i] != 'X' && !($find_obstacles))
                  {
                    $find_enemy = array($ship['_cara']['pos_y'], $y - $i);
                    $find_players = true;
                  }
                  $i++;
                }
              }
              if (!($find_obstacles) && $find_players)
              {
                $p_enemy_id = ($_SESSION['turn'] == 0) ? 1 : 0;
                $p_enemy = $game['_players'][$p_enemy_id];
                $s_enemy = $p_enemy['_ships'];
                $touched_enemy = false;
                $touched_enemy_id = -1;
                foreach ($s_enemy as $k => $v)
                {
                  $pos_x = $v['_cara']['pos_x'];
                  $pos_y = $v['_cara']['pos_y'];
                  $height = $v['_cara']['height'];
                  $width = $v['_cara']['width'];
                  $orientation = $v['orientation'];
                  if ($orientation == "NORTH")
                  {
                    for ($i = 0; $i < $height && !($touched_enemy); $i++)
                    {
                      for ($j = 0; $j < $width && !($touched_enemy); $j++)
                      {
                        if ($pos_x + $i == $find_enemy[0] || $pos_y - $j == $find_enemy[1])
                        {
                          $touched_enemy = $v;
                          $touched_enemy_id = $k;
                        }
                      }
                    }
                  }
                  else if ($orientation == "SOUTH")
                  {
                    for ($i = 0; $i < $height && !($touched_enemy); $i++)
                    {
                      for ($j = 0; $j < $width && !($touched_enemy); $j++)
                      {
                        if ($pos_x - $i == $find_enemy[0] || $pos_y - $j == $find_enemy[1])
                        {
                          $touched_enemy = $v;
                          $touched_enemy_id = $k;
                        }
                      }
                    }
                  }
                  else if ($orientation == "EAST")
                  {
                    for ($i = 0; $i < $height && !($touched_enemy); $i++)
                    {
                      for ($j = 0; $j < $width && !($touched_enemy); $j++)
                      {
                        if ($pos_x - $i == $find_enemy[0] || $pos_y - $j == $find_enemy[1])
                        {
                          $touched_enemy = $v;
                          $touched_enemy_id = $k;
                        }
                      }
                    }
                  }
                  else if ($orientation == "WEST")
                  {
                    for ($i = 0; $i < $height && !($touched_enemy); $i++)
                    {
                      for ($j = 0; $j < $width && !($touched_enemy); $j++)
                      {
                        if ($pos_x - $i == $find_enemy[0] || $pos_y + $j == $find_enemy[1])
                        {
                          $touched_enemy = $v;
                          $touched_enemy_id = $k;
                        }
                      }
                    }
                  }
                }
                if ($touched_enemy)
                {
                  $charge = $weapon['charge'];
                  $distance_x = abs($ship['_cara']['pos_x'] - $touched_enemy['_cara']['pos_x']);
                  $distance_y = abs($ship['_cara']['pos_y'] - $touched_enemy['_cara']['pos_y']);
                  $value = 0;
                  if ($ship['orientation'] == "NORTH" || $ship['orientation'] == "SOUTH")
                    $value = $distance_x;
                  else if ($ship['orientation'] == "EAST" || $ship['orientation'] == "WEST")
                    $value = $distance_y;
                  $range = $weapon['range'];
                  $min_des = 7;
                  $this->put_tchat("distance beetween two ship : " .$value, '../tmp/tchat', 1);
                  if ($value >= $range[0][0] && $value <= $range[0][1])
                  {
                    $this->put_tchat("You try " . $charge . " short range shoot", '../tmp/tchat', 1);
                    $min_des = 4;
                  }
                  else if ($value >= $range[1][0] && $value <= $range[1][1])
                  {
                    $this->put_tchat("You try " . $charge . " mid range shoot", '../tmp/tchat', 1);
                    $min_des = 5;
                  }

                  else if ($value >= $range[2][0] && $value <= $range[2][1])
                  {
                    $this->put_tchat("You try " . $charge . " long range shoot", '../tmp/tchat', 1);
                    $min_des = 6;
                  }
                  for ($i = 0; $i < $charge; $i++)
                  {
                    $des = rand(1, 6);
                    if ($des >= $min_des)
                    {
                      $this->put_tchat("Dès : " . $des . " you success your shoot and deal 1 damage point to " . $touched_enemy['_name'], '../tmp/tchat', 1);
                      if ($touched_enemy['_cara']['shield'] > 0 && $touched_enemy['_cara']['shield'] - 1 >= 0)
                        $game['_players'][$p_enemy_id]['_ships'][$touched_enemy_id]['_cara']['shield'] = $touched_enemy['_cara']['shield'] - 1;
                      else if ($touched_enemy['_cara']['shield'] == 0)
                        $game['_players'][$p_enemy_id]['_ships'][$touched_enemy_id]['_cara']['health'] = $game['_players'][$p_enemy_id]['_ships'][$touched_enemy_id]['_cara']['health'] - 1;
                      $this->put_tchat($touched_enemy['_name'] . " have now " . $game['_players'][$p_enemy_id]['_ships'][$touched_enemy_id]['_cara']['health'] . " pv", '../tmp/tchat', 1);
                      if ($game['_players'][$p_enemy_id]['_ships'][$touched_enemy_id]['_cara']['health'] <= 0)
                      {
                        $board = unserialize(file_get_contents('../tmp/board'));
                        $pos_x = $touched_enemy['_cara']['pos_x'];
                        $pos_y = $touched_enemy['_cara']['pos_y'];
                        $height = $touched_enemy['_cara']['height'];
                        $width = $touched_enemy['_cara']['width'];
                        $orientation = $touched_enemy['orientation'];
                        if ($orientation == "NORTH")
                        {
                          for ($i = 0; $i < $height; $i++)
                            for ($j = 0; $j < $width; $j++)
                              $board[$pos_x + $i][$pos_y] = '.';
                        }
                        else if ($orientation == "SOUTH")
                        {
                          for ($i = 0; $i < $height; $i++)
                            for ($j = 0; $j < $width; $j++)
                              $board[$pos_x - $i][$pos_y] = '.';
                        }
                        else if ($orientation == "EAST")
                        {
                          for ($i = 0; $i < $height; $i++)
                            for ($j = 0; $j < $width; $j++)
                              $board[$pos_x][$pos_y - $j] = '.';
                        }
                        else if ($orientation == "WEST")
                        {
                          for ($i = 0; $i < $height; $i++)
                            for ($j = 0; $j < $width; $j++)
                              $board[$pos_x][$pos_y + $j] = '.';
                        }
                        file_put_contents('../tmp/board', serialize($board));
                        unset($game['_players'][$p_enemy_id]['_ships'][$touched_enemy_id]);
                        $reindex = array_values($game);
                        $game = $reindex;
                        $_SESSION['data'] = json_encode($game);
                      }
                      else
                        $_SESSION['data'] = json_encode($game);
                    }
                    else
                      $this->put_tchat("Dès : " . $des . " you fail your shoot", '../tmp/tchat', 1);
                  }
                  $game['_players'][$_SESSION['turn']]['_ships'][$ship_id]['_cara']['shield'] = 0;
                  $game['_players'][$_SESSION['turn']]['_ships'][$ship_id]['_cara']['pp_actual'] = $$game['_players'][$_SESSION['turn']]['_ships'][$ship_id]['_cara']['pp'];
                  $game['_players'][$_SESSION['turn']]['_ships'][$ship_id]['_cara']['is_moving'] = 1;
                  $game['_players'][$_SESSION['turn']]['_ships'][$ship_id]['_cara']['vitesse'] = $game['_players'][$_SESSION['turn']]['_ships'][$ship_id]['_cara']['const_vitesse'];
                  $game['_players'][$_SESSION['turn']]['_ships'][$ship_id]['is_activated'] = 2;
                  $_SESSION['turn'] = ($_SESSION['turn'] == 0) ? 1 : 0;
                  $_SESSION['name'] = $name;
                  $new_player = $game['_players'][$_SESSION['turn']];
                  $_SESSION['name'] = $new_player['_name'];
                  $_SESSION['phase'] = 0;
                  $end_turn = true;
                  for ($i = 0; $i < count($game['_players']); $i++)
                    for ($j = 0; $j < count($game['_players'][$i]['_ships']); $j++)
                      if ($game['_players'][$i]['_ships'][$j]['is_activated'] == 0)
                        $end_turn = false;
                  if ($end_turn)
                  {
                    for ($i = 0; $i < count($game['_players']); $i++)
                      for ($j = 0; $j < count($game['_players'][$i]['_ships']); $j++)
                        $game['_players'][$i]['_ships'][$j]['is_activated'] = 0;
                  $_SESSION['data'] = json_encode($game);
                  if (isset($new_player['_ships[0]']) && !(empty($new_player['_ships'][0])))
                    $this->put_tchat("Its turn to " . $_SESSION['name'] . " please activate a ship", '../tmp/tchat', 1);
                  else
                  {
                    $this->put_tchat("Player " . $player['_name'] . " win this game !", '../tmp/tchat', 1);
                    exit(1);
                  }
                }
              }
              else
              {
                $game['_players'][$_SESSION['turn']]['_ships'][$ship_id]['_cara']['shield'] = 0;
                $game['_players'][$_SESSION['turn']]['_ships'][$ship_id]['_cara']['pp_actual'] = $game['_players'][$_SESSION['turn']]['_ships'][$ship_id]['_cara']['pp'];
                $game['_players'][$_SESSION['turn']]['_ships'][$ship_id]['_cara']['is_moving'] = 1;
                $game['_players'][$_SESSION['turn']]['_ships'][$ship_id]['_cara']['vitesse'] = $game['_players'][$_SESSION['turn']]['_ships'][$ship_id]['_cara']['const_vitesse'];
                $game['_players'][$_SESSION['turn']]['_ships'][$ship_id]['is_activated'] = 2;
                $_SESSION['turn'] = ($_SESSION['turn'] == 0) ? 1 : 0;
                $_SESSION['name'] = $name;
                $_SESSION['data'] = json_encode($game);
                $new_player = $game['_players'][$_SESSION['turn']];
                $_SESSION['name'] = $new_player['_name'];
                $_SESSION['phase'] = 0;
                $this->put_tchat("Its turn to " . $_SESSION['name'] . " please activate a ship", '../tmp/tchat', 1);
              }
            }
            else
              $this->put_tchat("The weapon " . $cmd[1] . " don't exists on the ship " . $ship['name'] . " type /ship_info " . $ship['name'] . " for more informations on the ship", '../tmp/tchat', 1);
        }
      }
      else
        $this->put_tchat("Please setup a weapon name, type /help for see all commands or /help shoot", '../tmp/tchat', 1);
    }
    else
      $this->put_tchat("Please finish your attribute or your movement phase before shoot, type /help for see all commands", '../tmp/tchat', 1);
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
