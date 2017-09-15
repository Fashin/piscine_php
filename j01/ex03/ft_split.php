#!/usr/bin/php
<?php

  function ft_split($str)
  {
    if (preg_match_all("/\S+/", $str, $ret))
    {
      $ret = $ret[0];
      return ($ret);
    }
    return (NULL);
  }

?>
