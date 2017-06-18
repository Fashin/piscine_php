<?php
  $error = 0;
  if (!(isset($_GET['log_in'])) && !(isset($_GET['register'])) && !(isset($_GET['deconnexion'])))
    header('Location:index.php');
  else if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['log_in']))
  {
    if (!(empty($_POST['login'])) && !(empty($_POST['password'])))
    {
        include_once("database/control_user.php");
        $error = check_user_exist($_POST['login'], $_POST['password'], true);
    }
    else
      $error = "Veuillez remplir tous les champs !";
  }
  else if (isset($_POST['login']) && isset($_POST['password'])
          && isset($_POST['confirm_password'])
          && isset($_POST['email']) && isset($_POST['register']))
  {
    if (!(empty($_POST['login'])) && !(empty($_POST['password']))
            && !(empty($_POST['confirm_password']))
            && !(empty($_POST['email'])) && !(empty($_POST['register'])))
    {
        include_once("database/control_user.php");
        $error = register_user($_POST['login'], $_POST['password'], $_POST['confirm_password'], $_POST['email']);
    }
    else
      $error = "Veuillew remplir tous les champs ! ";
  }
  else if (isset($_GET['deconnexion']))
  {
    include_once("database/control_user.php");
    deconnexion();
    header("Location:index.php?deconnexion=success");
  }
  include_once("public/header.php");
  include_once("public/menu.php");
  if (!empty($error))
    echo '<div class="error"> ' . $error . ' </div>';
?>
    <form class="formulaire_connexion" action="#" method="post">
      <?php
        if ($_GET['log_in'])
        {
      ?>
          <input type="text" name="login" placeholder="Login" value="<?= $_POST['login'] ?>">
          <input type="password" name="password" placeholder="Password" value="<?= $_POST['password'] ?>">
          <input type="submit" name="log_in" value="Sign In">
      <?php
        }
        else if ($_GET['register'])
        {
      ?>
          <input type="text" name="login" placeholder="Login">
          <input type="password" name="password" placeholder="Password">
          <input type="password" name="confirm_password" placeholder="Confirm Password">
          <input type="email" name="email" placeholder="Your Email">
          <input type="submit" name="register" value="Sign In">
      <?php
        }
      ?>
    </form>
<?php
  include_once("public/footer.php");
?>
