<?php

  $user = $_SERVER['PHP_AUTH_USER'];
  $psswd = $_SERVER['PHP_AUTH_PW'];
  if ($user == "zaz" && $psswd == "jaimelespetitsponeys")
  {
    ?>
    <html><body>
        Bonjour Zaz <br/>
        <?php
          echo "<img src='data:image/png;base64,";
          $file = base64_encode(file_get_contents('img/42.png'));
          echo $file;
          echo " '/>";
        ?>
    </body></html>
    <?php
  }
  else
  {
    header('WWW-Authenticate: Basic realm=\'\'Espace Membres\'\'');
    header('Connection: close ');
?>
<html><body>Cette zone est accessible uniquement aux membres du site</body></html>
<?php
  }
?>
