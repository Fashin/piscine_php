<?php

class Color
{
	public $red;
	public $green;
	public $blue;
	static $verbose = FALSE;

	public function __construct(array $array)
	{
		if (array_key_exists('rgb', $array))
		{
			$rgb = intval($array["rgb"]);
			$this->red = $rgb / 65281 % 256;
	  		$this->green = $rgb / 256 % 256;
	  		$this->blue = $rgb % 256;
		}
		else
		{
			$this->red = intval($array['red']);
			$this->green = intval($array['green']);
			$this->blue = intval($array['blue']);
		}
		if ($this->red < 0)
			$this->red = 0;
		if ($this->green < 0)
			$this->green = 0;
		if ($this->blue < 0)
			$this->blue = 0;
		if ($this->red > 255)
			$this->red = 255;
		if ($this->green > 255)
			$this->green = 255;
		if ($this->blue > 255)
			$this->blue = 255;
		if (Self::$verbose === TRUE)
			printf("Color( red: %3d, green: %3d, blue: %3d ) constructed.\n", $this->red, $this->green, $this->blue);
	}

    function __destruct()
    {
        if (Self::$verbose === TRUE)
            printf("Color( red: %3d, green: %3d, blue: %3d ) destructed.\n", $this->red, $this->green, $this->blue);
    }

	public function __toString()
	{
		return (vsprintf("Color( red: %3d, green: %3d, blue: %3d )", array($this->red, $this->green, $this->blue)));
	}

	public static function doc()
	{
		$read = fopen("Color.doc.txt", 'r');
		while ($read && !feof($read))
			echo fgets($read);
	}

	public function add($Color)
	{
	  return (new Color(array('red' => $this->red + $Color->red, 'green' => $this->green + $Color->green, 'blue' => $this->blue + $Color->blue)));
	}
	public function sub($Color)
	{
	  return (new Color(array('red' => $this->red - $Color->red, 'green' => $this->green - $Color->green, 'blue' => $this->blue - $Color->blue)));
	}
	public function mult($mult)
	{
	  return (new Color(array('red' => $this->red * $mult, 'green' => $this->green * $mult, 'blue' => $this->blue * $mult)));
	}

}

?>
