<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="refresh" content="2" > -->
    <link rel="stylesheet" href="../css/tchat.css">
  </head>
  <body>
    <div class="display_command">
      <?php
        $content = unserialize(file_get_contents('../tmp/tchat'));
        if ($content)
          foreach ($content as $k => $v)
            echo $v['login'] . ":" .  $v['text'] ."<br>";
      ?>
    </div>
  </body>
</html>
