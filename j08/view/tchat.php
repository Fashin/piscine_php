<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="3" >
    <link rel="stylesheet" href="../css/tchat.css">
  </head>
  <body>
    <div class="display_command">
      <?php
        $content = unserialize(file_get_contents('../tmp/tchat'));
        if ($content)
        {
          foreach ($content as $k => $v)
          {
            if (!empty($v['login']))
              echo $v['login'] . " : ";
            echo $v['text'];
            echo "<br>";
          }
        }
      ?>
    </div>
  </body>
</html>
