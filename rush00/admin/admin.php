<?php

  include_once("admin_controller.php");
  if (!(check_admin($_COOKIE['login'], $_COOKIE['password'], $_COOKIE['id'])))
    header("Location:../connexion.php?deconnexion");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../public/css/admin.css">
    <title>Admin Board</title>
  </head>
  <body>
    <a href="../index.php"><img src="../public/pictures/logo.jpg" class="logo"></a><br>
    <nav>
      <a href="admin_user.php">Users</a>
      <a href="admin_shop.php">Shop</a>
      <a href="admin_commande.php">Commande</a>
    </nav>

<?php

  include_once("admin_footer.php");

?>
