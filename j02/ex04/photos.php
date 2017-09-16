#!/usr/bin/php
<?php

if ($argc == 2)
{
  $ch = curl_init($argv[1]);
  $filename = $argv[1] . '/tmp';
  if (mkdir($argv[1]))
  {
    if ($fd = fopen($filename, 'w'))
    {
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_FILE, $fd);
      curl_exec($ch);
      curl_close($ch);
      fclose($fd);
      $content = file_get_contents($filename);
      if (preg_match_all('/<img src="([a-zA-Z\s:=\/\.0-9-_]+)"/', $content, $match))
      {
        $match = $match[1];
        unlink($filename);
        for ($i = 0; $i < count($match); $i++)
        {
          $filename = quotemeta($argv[1] . '\/' . $match[$i]);
          if (!(fopen($filename, 'a+')))
            echo "Can't create file\n";
        }
      }
    }
    else
      echo "Can't create file\n";
  }
  else
    echo "Folder already exists\n";
}

?>
