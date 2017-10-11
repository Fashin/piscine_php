<?php

  function get_color($c)
  {
    $tab = array(
      'R' => 'red_player',
      'B' => 'blue_player',
      'X' => 'obstacle',
      'P' => 'purple_player',
      'Y' => 'yellow_player',
      '.' => 'herbe'
    );
    if (in_array($c, array_keys($tab)))
      return ($tab[$c]);
  }

?>

<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="../css/board.css">
  </head>
  <body>
    <?php
      $board = unserialize(file_get_contents('../tmp/board'));
      if ($board)
      {
        echo "<table>";
        $height = count($board) - 1;
        for ($x = 0; $x < $height; $x++)
        {
          $width = count($board[$x]) - 1;
          echo "<tr>";
          for ($y = 0; $y < $width; $y++)
          {
            echo '<td class=" ' . get_color($board[$x][$y]). ' "></td>';
          }
          echo "</tr>";
        }
        echo "</table>";
      }
    ?>
  </body>
</html>
