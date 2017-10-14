<?php

  require_once("Models.class.php");

  class Select extends Models
  {
    function __construct()
    {
      parent::init_db();
      //parent::__construct();
    }

    public function user($id = null, $login = null, $psswd = null)
    {
      if ($id == null && $login == null && $psswd == null)
        return (false);
      $params = "SELECT * FROM Players WHEN";
      $key_params = array();
      $value_params = array();
      if ($id && array_unshift($value_params, $id) && array_unshift($key_params, ":id"))
        $params = $params . " id=:id AND";
      if ($login && array_unshift($value_params, $login) && array_unshift($key_params, ":login"))
      {
        $params = $params . " login=:login";
        $params = ($psswd) ? $params . " AND" : $params;
      }
      if ($psswd && array_unshift($value_params, $psswd) && array_unshift($key_params, ":psswd"))
        $params = $params . " password=:password";

      //var_dump(parent::__construct());
      /*$req = $this->db_co->prepare($params);
      var_dump($req);
      $req->execute(array_combine($key_params, $value_params));
      $res = $req->fetchAll();
      var_dump($res);*/
    }
  }

?>
