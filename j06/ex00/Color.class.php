<?php

class Color
{

	public $red;
	public $green;
	public $blue;

	public static $verbose;

	function __construct(array $params)
	{
		if (array_key_exists('rgb', $params))
		{
			$val = $params['rgb'];
			$this->red = ($val >> 16) & 0xFF;
			$this->green = ($val >> 8) & 0xFF;
			$this->blue = $val  & 0xFF;
		}
		else if (array_key_exists('red', $params)
			&& array_key_exists('green', $params)
			&& array_key_exists('blue', $params))
		{
			$this->red = ((is_numeric($params['red']) || $params['red'] == 0) && ($params >= 0 && $params <= 255)) ? $params['red'] : 255;
			$this->green = ((is_numeric($params['green']) || $params['green'] == 0) && ($params >= 0 && $params <= 255)) ? $params['green'] : 255;
			$this->blue = ((is_numeric($params['blue']) || $params['blue'] == 0) && ($params >= 0 && $params <= 255)) ? $params['blue'] : 255;
		}
		else
			return (NULL);
		if (self::$verbose)
			printf("Color( red: %3d, green: %3d, blue: %3d ) constructed.\n", $this->red, $this->green, $this->blue);
	}

	public function add(Color $rhs)
	{
		$red = ($this->red + $rhs->red <= 255) ? $this->red + $rhs->red : 0;
		$green = ($this->green + $rhs->green <= 255) ? $this->green + $rhs->green : 0;
		$blue = ($this->blue + $rhs->blue <= 255) ? $this->blue + $rhs->blue : 0;
		return (new Color(array('red' => $red, 'green' => $green, 'blue' => $blue)));
	}

	public function sub(Color $rhs)
	{	
		$red = ($this->red - $rhs->red >= 0) ? $this->red - $rhs->red : 0;
		$green = ($this->green - $rhs->green >= 0) ? $this->green - $rhs->green : 0;
		$blue = ($this->blue - $rhs->blue >= 0) ? $this->blue - $rhs->blue : 0;
		return (new Color(array('red' => $red, 'green' => $green, 'blue' => $blue)));
	}

	public function mult($rhs)
	{
		$red = ($this->red * $rhs >= 0 && $this->red <= 255) ? $this->red * $rhs: 0;
		$green = ($this->green * $rhs >= 0 && $this->green <= 255) ? $this->green * $rhs : 0;
		$blue = ($this->blue * $rhs >= 0 && $this->blue <= 255) ? $this->blue * $rhs : 0;
		return (new Color(array('red' => $red, 'green' => $green, 'blue' => $blue)));	
	}

	public function __toString()
	{
		return ("Color( red: " . sprintf("%3d", $this->red) . ", green: " . sprintf("%3d", $this->green) . ", blue: " . sprintf("%3d", $this->blue) . " )");
	}

	public static function doc()
	{
		if ($content = file_get_contents('./Color.doc.txt'))
			return ($content);
	}

	function __destruct()
	{
		if (self::$verbose)
			printf("Color( red: %3d, green: %3d, blue: %3d ) destructed.\n", $this->red, $this->green, $this->blue);
	}

}

?>
