<?php

function deconnexion()
{
  setcookie("login", $login, -1);
  setcookie("password", $password, -1);
  setcookie("id", $id, -1);
}

/*
*   Function to save pseudo/password/id couple on a cookie who have 1 week duration
*   @author cbeavoi
*   @return {void}
*/
function save_in_cookie($login, $password, $id, $url)
{
  setcookie("login", $login, time() + (7 * 24 * 60 * 60));
  setcookie("password", $password, time() + (7 * 24 * 60 * 60));
  setcookie("id", $id, time() + (7 * 24 * 60 * 60));
  header("Location:" . $url);
}

/*
*   Function to check if user exist, $save isn't mandatory, if is true the function save_in_cookie is called
*   @author cbeauvoi
*   @return {int}
*/
function check_user_exist($pseudo, $password, $save = false)
{
  $file_content = unserialize(file_get_contents('database/user'));
  if (is_array($file_content))
    foreach ($file_content as $elem)
      if ($elem['login'] == $pseudo && $elem['password'] == hash("sha512", $password))
        if ($elem['permission'] > 0)
          save_in_cookie($pseudo, hash("sha512", $password), $elem['id'], "admin/admin.php?connexion=success");
        else
          if ($save) { save_in_cookie($pseudo, hash("sha512", $password), $elem['id'], "index.php?connexion=success"); } else { return (1); }
  return (0);
}

/*
*   Function to register an user, return a string with error message or just 1 if all is ok
*   @author cbeauvoi
*   @return {String || int}
*/
function register_user($login, $password, $confirm_password, $email)
{
  if (!(check_user_exist($login, $password)))
  {
    if ($password == $confirm_password)
    {
      $file_content = unserialize(file_get_contents('database/user'));
      $id = count($file_content) + 1;
      $data_user = array("login" => $login, "password" => hash("sha512", $password), "email" => $email, "id" => $id, "permission" => 0);
      if (is_array($file_content))
      {
        $file_content[] = $data_user;
        file_put_contents('database/user', serialize($file_content));
      }
      else
        file_put_contents('database/user', serialize(array($data_user)));
      save_in_cookie($login, $password, $id, "index.php?register=true");
    }
    else
      return ("Les mots de passe ne correspondent pas");
  }
  else
    return ("L'utilisateur éxiste déjà !");
}

?>
