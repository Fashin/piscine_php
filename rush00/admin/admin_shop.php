<?php

  /*
  *   Items can be added/change/delete here, permission > 0 is needed
  *   Items have a format to be modify {id:{int}, name:{String}, price:{int}, quantity:{int}};
  *   Each items respect this format.
  *   @author cbeauvoi
  */

  include_once("admin.php");

  $error = "";
  $info = "";

  if (isset($_POST['insert']))
  {
      if (isset($_POST['name']) && !empty($_POST['name'])
          && isset($_POST['price']) && !empty($_POST['price'])
          && isset($_POST['quantity']) && !empty($_POST['quantity'])
          && isset($_POST['picture']) && !empty($_POST['picture']))
      {
        insert_item($_POST['name'], $_POST['price'], $_POST['quantity'], $_POST['picture']);
        $info = "Item has been added";
      }
      else
        $error = "Veuillez remplir tous les champs !";
  }
  else if (isset($_POST['modify']))
  {
    $id = $_POST['id'];
    $item = select($id, '../database', 'item');
    $key = find_shop_change_value($_POST, $item);
    change_value($id, $key, $_POST[$key], "../database", 'item');
    $info = "Value has been updated";
  }

  else if (isset($_POST['delete']))
  {
    $id = $_POST['id'];
    change_value($id, 'delete', '', '../database', 'item');
    $info = "Item has been deleted";
  }

  if (!empty($error))
    echo "<div class='error'> " . $error . "</div>";
  else if (!empty($info))
    echo "<div class='info'> " . $info . "</div>";

  $items = select('*', "../database", "item");

  if (is_array($items))
  {
    foreach($items as $item)
    {
      ?>
        <form action="#" method="post">
          <input type="text" name="name" value="<?= $item['name']; ?>">
          <input type="number" name="price" value="<?= $item['price']; ?>">
          <input type="number" name="quantity" value="<?= $item['quantity']; ?>">
          <input type="text" name="picture" value="<?= $item['picture']; ?>">
          <input type="hidden" name="id" value="<?= $item['id']; ?> ">
          <input type="submit" name="modify" value="change">
          <button type="submit" name="delete"><img src="../public/pictures/delete.jpg" class="delete"></button>
        </form>
      <?php
    }
  }
?>

<form action="#" method="post">
  <input type="text" name="name" placeholder="Article Reference">
  <input type="number" name="price" placeholder="Price ($)">
  <input type="number" name="quantity" placeholder="Quantity Stocked (u)">
  <input type="text" name="picture" placeholder="Path to the picture">
  <input type="submit" name="insert" value="Add to stock">
</form>
