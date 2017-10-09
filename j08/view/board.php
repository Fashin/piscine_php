<!DOCTYPE html>
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
        $height = count($board);
        $width = count($board[0]);
        for ($x = 0; $x < $height; $x++)
        {
          for ($y = 0; $y < $width; $y++)
          {
            if ($board[$x][$y] == 'X')
              echo '<span class="tuile obstacle"></span>';
            else
              echo '<span class="tuile herbe"></span>';
          }
          echo "<br>";
        }
      }
    ?>
  </body>
</html>
