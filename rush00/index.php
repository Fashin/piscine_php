<?php
  $info = "";
  if (isset($_GET['id']))
  {
    if (isset($_COOKIE['cart']))
    {
      $new_value = $_COOKIE['cart'] . '/' . $_GET['id'];
      setcookie("cart", $new_value, time() + (7 * 7 * 60 * 60));
    }
    else
      setcookie("cart", $_GET['id'], time() + (7 * 7 * 60 * 60));
    header("Refresh:0; url=index.php");
  }
  include_once("public/header.php");
  if (isset($_GET['register']) && $_GET['register'] == 'true')
    $info = "Bienvenue sur ce super site de vente en ligne !";
  else if (isset($_GET['connexion']) && $_GET['connexion'] == 'success')
    $info = "Rebonjour " . $_COOKIE['pseudo'] . " heureux de vous revoir !";
  else if (isset($_GET['deconnexion']) && $_GET['deconnexion'] == 'success')
    $info = "Au revoir et a très bientôt !";
  if (!empty($info))
    echo '<div class="info">' . $info . '</div>';
  include_once("public/menu.php");
  include_once("admin/admin_controller.php");
  $items = select('*', 'database', 'item');
  ?>
  <div class="items">
  <?php
  foreach ($items as $item)
  {
    ?>
    <a href="index.php?id=<?= $item['id']; ?>">
      <div class="item">
        <div class="name"><?= $item['name']; ?></div>
        <div class="price"><?= $item['price']; ?>$</div>
        <div class="quantity">En stock : <?= $item['quantity']?></div>
        <img src="<?= $item['picture']; ?>" class="picture_item">
      </div>
    </a>
    <?php
  }
  ?>
  </div>
  <?php
  include_once("public/footer.php");
?>
