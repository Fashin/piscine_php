<?php

/*
*   Function for checking if a login/password/id have the permission to be redirect on admin board
*   @author cbeauvoi
*   @return {int}
*/
function check_admin($login, $password, $id, $path = "../database")
{
  $user = select($id, $path, 'user');
  if ($user > 0 && !($user['permission'] > 0))
    return (0);
  return (1);
}


/*
*   Specific function who find what is the key change beetween two ObjectUser
*   @author cbeauvoi
*   @return {String}
*/
function find_user_change_value($new, $old)
{
  $keys = array("login", "password", "email", "permission");
  for ($i = 0; $i < count($keys); $i++)
    if ($new[$keys[$i]] != $old[$keys[$i]])
      return ($keys[$i]);
}

?>
