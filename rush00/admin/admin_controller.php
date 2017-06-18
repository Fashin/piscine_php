<?php

  /*
  *   Function to select any object from database, path mandatory, only one id is needed
  *   If the id is an asterix, all the data from the database is returned
  *   @author cbeauvoi
  *   @eturn {Object}
  */
  function select($id, $path = "../", $db_name)
  {
    $file_content = unserialize(file_get_contents($path . '/' . $db_name));
    if ($id == '*')
      return ($file_content);
    foreach ($file_content as $elem)
      if ($elem['id'] == $id)
        return ($elem);
    return (0);
  }

  /*
  *   Function for change the value of any item, only id/key/value needed, path mandatory
  *   @author cbeauvoi
  *   @return {void}
  */
  function change_value($id, $key, $value, $path = "../", $db_name)
  {
    $file_content = unserialize(file_get_contents($path . '/' . $db_name));
    $i = 0;
    foreach ($file_content as $elem)
    {
      if ($elem['id'] == $id)
      {
        if ($key == 'password')
          $file_content[$i][$key] = hash("sha512", $value);
        else if ($key == 'delete')
          unset($file_content[$i]);
        else
          $file_content[$i][$key] = $value;
      }
      $i++;
    }
    file_put_contents($path . "/" . $db_name, serialize($file_content));
  }

  include_once("admin_controller-user.php");
  include_once("admin_controller-shop.php");

?>
