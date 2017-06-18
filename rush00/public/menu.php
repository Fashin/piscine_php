<header>
  <a href="index.php"><img src="public/pictures/logo.jpg" class="logo"/></a>
  <menu>
    <?php
    ?>
  </menu>
  <a href="valid_cart.php"><img src="public/pictures/cart.png" class="cart"></a>
  <span class="display_number_items">
    <?php
      if (isset($_COOKIE['cart']))
        echo count(explode("/", explode("%2F", $_COOKIE['cart'])[0]));
      else
        echo "0";
    ?>
  </span>
  <?php
  if (!isset($_COOKIE['login']))
  {
  ?>
    <connexion>
      <a href="connexion.php?register=true">Log in</a>
      <a href="connexion.php?log_in=true">Sign in</a>
    </connexion>
  <?php
  }
  else
  {
    include_once("admin/admin_controller.php");
  ?>
  <connexion>
      Welcome <?= $_COOKIE['login']; ?>
      <?php
        if (check_admin($_COOKIE['login'], $_COOKIE['password'], $_COOKIE['id'], "./database"))
        {
          ?>
            <a href="admin/admin.php">Espace Administrateur</a>
          <?php
        }
      ?>
      <a href="connexion.php?deconnexion=true">Log out</a>
  </connexion>
  <?php
  }
  ?>
</header>
