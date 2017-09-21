#!/usr/bin/php

<?php

  if ($argc == 2)
  {
    if ($handle = fopen($argv[1], 'r'))
    {
      $content = fread($handle, filesize($argv[1]));
      $pattern = '/title="([a-zA-Z0-9\s]+)"/';
      $pattern2 = '/<a[a-zA-Z\s=\":\/\.]+\>(.+?)\</';
      $ret = preg_replace_callback($pattern, function ($match) {
        return ('title="' . strtoupper($match[1]). '"');
      }, $content);
      $ret = preg_replace_callback($pattern2, function ($match) {
        return (substr($match[0], 0, (strlen($match[0]) - (strlen($match[1]) + 1))) . strtoupper($match[1]) . '<');
      }, $ret);
      print_r($ret);
    }
    else
      echo "Erreur lors de l'ouverture de votre fichier : " . $argv[1] . "\n";
  }

?>
