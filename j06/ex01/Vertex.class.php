<?php

class Vertex
{
	private $_x;
	private $_y;
	private $_z;
	private $_w;
	private $_color;

	public static $verbose = FALSE;

	function __construct(array $params)
	{
		if (array_key_exists('x', $params) &&
			array_key_exists('y', $params) &&
			array_key_exists('z', $params))
		{
			$this->_x = floatval($params['x']);
			$this->_y = floatval($params['y']);
			$this->_z = floatval($params['z']);
			$this->_w = (array_key_exists('w', $params)) ? intval($params['w']) : 1.0;
			$this->_color = (is_a($params['color'], 'Color')) ? $params['color'] : new Color(array('red' => 255, 'green'=> 255, 'blue'=>255));
			if (self::$verbose)
				echo "Vertex( x: " . sprintf("%.02f", $this->_x) . ", y: " . sprintf("%.02f", $this->_y) . ", z:" . sprintf("%.02f", $this->_z) . ", w:" . sprintf("%.02f", $this->_w). ", " . $this->_color . " ) constructed\n";
		}
	}

	public static function doc()
	{
		if ($content = file_get_contents('./Vertex.doc.txt'))
			return ($content);
	}

	public function _set($var, $val)
	{
		$this->$var = $val;
	}

	public function _get($var)
	{
		return ($this->$var);
	}

	public function __toString()
	{
		$x = sprintf("%.02f", $this->_x);
		$y = sprintf("%.02f", $this->_y);
		$z = sprintf("%.02f", $this->_z);
		$w = sprintf("%.02f", $this->_w);
		$color = (self::$verbose) ? ", " . $this->_color : "";
		return ("Vertex( x: " . $x . ", y: " . $y . ", z:" . $z . ", w:" . $w . $color . " )");
	}

	function __destruct()
	{
		if (self::$verbose)
			echo "Vertex( x: " . sprintf("%.02f", $this->_x) . ", y: " . sprintf("%.02f", $this->_y) . ", z:" . sprintf("%.02f", $this->_z) . ", w:" . sprintf("%.02f", $this->_w). ", " . $this->_color . " ) destructed\n";
	}
}

?>
