#!/usr/bin/php
<?php

if ($argc == 2)
{
  $ch = curl_init($argv[1]);
  if (preg_match_all('/[a-zA-Z]+:\/\/(.+)/', $argv[1], $match))
  {
    $folder = $match[1][0];
    $filename = $folder . '/tmp';
    if (mkdir($folder))
    {
      if ($fd = fopen($filename, 'w'))
      {
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FILE, $fd);
        curl_exec($ch);
        curl_close($ch);
        fclose($fd);
        $content = file_get_contents($filename);
        if (preg_match_all('/<img.+src="([a-zA-Z\s:=\/\.0-9-_]+)"/', $content, $match))
        {
          $match = $match[1];
          unlink($filename);
          for ($i = 0; $i < count($match); $i++)
          {
            $file = explode('/', $match[$i]);
            $file = $file[count($file) - 1];
            $filename = $folder . '/' . $file;
            if (!(fopen($filename, 'a+')))
              echo "Can't create output file\n";
          }
        }
        else
          echo "No pictures found\n";
      }
      else
        echo "Can't create tempory file\n";
    }
    else
      echo "Error from folder create\n";
  }
  else
    echo "Enter a valid URL\n";
}
else
  echo "Usage ./photo.php [path to the website]\n";

?>
