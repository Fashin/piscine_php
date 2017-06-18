<?php

  /*
  *   Function to insert an items, only needed to follow the item format
  *     => check admin_shop.php for more information
  *   @author cbeauvoi
  *   @return {void}
  */
  function insert_item($name, $price, $quantity, $picture)
  {
    $prot = false;
    $path = "../database";
    $db_name = "item";
    $items = select("*", $path, $db_name);
    $new_item = array("id" => count($items) + 1, "name" => $name, "price" => $price, "quantity" => $quantity, "picture" => $picture);
    if (is_array($items))
    {
      foreach ($items as $item)
        if ($item['name'] == $new_item['name'])
          $prot = true;
      if (!($prot))
      {
        $items[] = $new_item;
        file_put_contents($path.'/'.$db_name, serialize($items));
      }
    }
    else
      file_put_contents($path.'/'.$db_name, serialize(array($new_item)));
  }

  /*
  *   Its absolute the same from find_user_change_value but the keys array has been update for the items
  *   @author cbeauvoi
  *   return {String}
  */
  function find_shop_change_value($new, $old)
  {
    $keys = array("name", "price", "quantity", "picture");
    for ($i = 0; $i < count($keys); $i++)
      if ($new[$keys[$i]] != $old[$keys[$i]])
        return ($keys[$i]);
  }

?>
