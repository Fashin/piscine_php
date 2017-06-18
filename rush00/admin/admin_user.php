<?php

  /*
  *   Here you control the users, you can change their pseudo/email/permissions and reset their password
  *   If you reset the password he is reload to "qwerty"
  *   You can apply only one modification each times
  *   @author cbeauvoi
  */

  include_once("admin.php");

  $info = "";

  if (isset($_POST['modify']))
  {
    $id = $_POST['id'];
    $user = select($id, "../database", 'user');
    $key = find_user_change_value($_POST, $user);
    change_value($id, $key, $_POST[$key], "../database", "user");
    $info = "Value modified";
  }

  else if (isset($_POST['reset_password']))
  {
    change_value($_POST['id'], 'password', 'qwerty', "../database", "user");
    $info = "Password reset for 'qwerty'";
  }

  else if (isset($_POST['delete']))
  {
    change_value($_POST['id'], 'delete', '', '../database', 'user');
    $info = "User has been deleted";
  }

  $user_data = select("*", "../database", 'user');

  if (!(empty($info)))
  {
  ?>
    <div class="info"><?= $info ?></div>
  <?php
  }

  foreach ($user_data as $elem)
  {
    ?>
    <form class="" action="#" method="post">
      <input type="text" name="login" value="<?= $elem['login']; ?>">
      <select name="permission">
        <?php ($elem['permission'] == "0") ? print_r("<option selected value=\"0\">0</option> ") : print_r("<option value=\"0\">0</option>") ?>
        <?php ($elem['permission'] == "1") ? print_r("<option selected value=\"1\">1</option> ") : print_r("<option value=\"1\">1</option>") ?>
        <?php ($elem['permission'] == "2") ? print_r("<option selected value=\"2\">2</option> ") : print_r("<option value=\"2\">2</option>") ?>
      </select>
      <input type="email" name="email" value="<?= $elem['email']; ?>">
      <input type="hidden" name="id" value="<?= $elem['id']; ?>">
      <input type="hidden" name="password" value="<?= $elem['password']; ?>">
      <input type="submit" name="modify" value="change">
      <input type="submit" name="reset_password" value="reset password">
      <button type="submit" name="delete"><img src="../public/pictures/delete.jpg" class="delete"></button>
    </form>
    <?php
  }
?>
