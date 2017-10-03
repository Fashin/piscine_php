#!/usr/bin/php
<?php

  function ft_is_sort($tab)
  {
    $sort = $tab;
    sort($sort, SORT_REGULAR);
    for ($i = 0; $i < count($tab); $i++)
      if ($sort[$i] != $tab[$i])
        return (FALSE);
    return (TRUE);
  }

?>
