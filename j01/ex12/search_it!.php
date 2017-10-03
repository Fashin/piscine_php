#!/usr/bin/php
<?php
if ($argc > 2)
{
	$search = $argv[1];
	for ($i = 2; $i < count($argv); $i++)
	{
		$tmp = explode(':', $argv[$i]);
		if (count($tmp) == 2)
			$tab[$tmp[0]] = $tmp[1];
	}
	if (array_key_exists($search, $tab))
		echo $tab[$search] . PHP_EOL;
}
?>
