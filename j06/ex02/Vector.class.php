<?php

class Vector
{
  private $_x;
  private $_y;
  private $_z;
  private $_w = 0.0;

  public static $verbose = FALSE;

  function __construct(Array $input)
  {
    if (array_key_exists('dest', $input) && is_a($input['dest'], 'Vertex'))
    {
      $orig = (array_key_exists('orig', $input) && is_a($input['orig'], 'Vertex')) ? $input['orig'] : new Vertex(array('x'=>0, 'y'=>0, 'z'=>0));
      $this->_x = floatval($input['dest']->_get('_x')) - floatval($orig->_get('_x'));
      $this->_y = floatval($input['dest']->_get('_y')) - floatval($orig->_get('_y'));
      $this->_z = floatval($input['dest']->_get('_z')) - floatval($orig->_get('_z'));
      if (self::$verbose)
        echo "Vector( x:" . sprintf("%.02f", $this->_x) . ", y:" . sprintf("%.02f", $this->_y) . ", z:" . sprintf("%.02f", $this->_z) . ", w:0.00 ) constructed\n";
    }
  }

  public function magnitude()
  {
    return (sqrt(pow($this->_x, 2) + pow($this->_y, 2) + pow($this->_z, 2)));
  }

  public function normalize()
  {
    $magn = $this->magnitude();
    $vtx = new Vertex(array(
      'x' => $this->_x / $magn,
      'y' => $this->_y / $magn,
      'z' => $this->_z / $magn
    ));
    return (new Vector(array('dest' => $vtx)));
  }

  public function _get($var)
  {
    return ($this->$var);
  }

  public function add(Vector $vect)
  {
      return (new Vector(array('dest' => new Vertex(array(
        'x' => floatval($this->_x + $vect->_x),
        'y' => floatval($this->_y + $vect->_y),
        'z' => floatval($this->_z + $vect->_z),
      )))));
  }

  public function sub(Vector $vect)
  {
      return (new Vector(array('dest' => new Vertex(array(
        'x' => floatval($this->_x - $vect->_x),
        'y' => floatval($this->_y - $vect->_y),
        'z' => floatval($this->_z - $vect->_z),
      )))));
  }

  public function opposite()
  {
    return (new Vector(array('dest' => new Vertex(array(
      'x' => floatval($this->_x * (-1)),
      'y' => floatval($this->_y * (-1)),
      'z' => floatval($this->_z * (-1))
    )))));
  }

  public function scalarProduct($scal)
  {
    return (new Vector(array('dest' => new Vertex(array(
      'x' => floatval($this->_x * $scal),
      'y' => floatval($this->_y * $scal),
      'z' => floatval($this->_z * $scal)
    )))));
  }

  public function dotProduct(Vector $vect)
  {
    return (floatval(($this->_x * $vect->_x) + ($this->_y * $vect->_y) + ($this->_z * $vect->_z)));
  }

  public function cos(Vector $vect)
  {
      return (($this->dotProduct($vect)) / (($this->magnitude()) * ($vect->magnitude())));
  }

  public function crossProduct($vect)
  {
    return (new Vector(array('dest' => new Vertex(array(
      'x' => floatval(($this->_y * $vect->_z) - ($this->_z * $vect->_y)),
      'y' => floatval(($this->_z * $vect->_x) - ($this->_x * $vect->_z)),
      'z' => floatval(($this->_x * $vect->_y) - ($this->_y * $vect->_x))
    )))));
  }

  public static function doc()
  {
	  if ($content = file_get_contents('./Vector.doc.txt'))
		  return ($content);
  }

  public function __toString()
  {
    return ("Vector( x:" . sprintf("%.02f", $this->_x) . ", y:" . sprintf("%.02f", $this->_y) . ", z:" . sprintf("%.02f", $this->_z) . ", w:0.00 )");
  }

  function __destruct()
  {
    echo "Vector( x:" . sprintf("%.02f", $this->_x) . ", y:" . sprintf("%.02f", $this->_y) . ", z:" . sprintf("%.02f", $this->_z) . ", w:0.00 ) destructed\n";
  }
}

?>
