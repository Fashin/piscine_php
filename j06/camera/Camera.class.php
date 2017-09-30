<?php

class Camera
{
  private $_origin;
  private $_orientation;
  private $_fov;
  private $_near;
  private $_far;
  private $_ratio;
  private $_proj;

  public static $verbose = FALSE;

  function __construct($input)
  {
    if ((array_key_exists('origin', $input) && is_a($input['origin'], 'Vertex'))
        && (array_key_exists('orientation', $input)) && (array_key_exists('fov', $input))
        && (array_key_exists('near', $input)) && array_key_exists('far', $input))
        {
          if (array_key_exists('width', $input) && array_key_exists('height', $input))
            $this->_ratio = intval($input['width'] / $input['height']);
          else if (array_key_exists('ratio', $input))
            $this->_ratio = intval($input['ratio']);
          else
            exit (1);
          $this->_origin = $input['origin'];
          $this->_orientation = $input['orientation'];
          $this->_fov= intval($input['fov']);
          $this->_near = intval($input['near']);
          $this->_far = intval($input['far']);
          $oppv = new Vector(array('dest' => $this->_origin));
          $tT = new Matrix(array('preset' => Matrix::TRANSLATION, 'vtc' => $oppv->opposite()));
          $tR = $this->_orientation->transpose();
          $this->_view_matrix = $tR->mult($tT);
          $this->_proj = new Matrix(array('preset' => Matrix::PROJECTION, 'fov' => $this->_fov, 'ratio' => $this->_ratio, 'near' => $this->_near, 'far' => $this->_far));
          if (self::$verbose)
            echo 'Camera instance constructed' . PHP_EOL;
        }
  }

  public function watchVertex($worldVertex)
  {

  }

  public function __toString()
  {
    return ();
  }

  function __destruct()
  {
    if (self::$verbose)
      echo "Camera instance destructed" . PHP_EOL;
  }
}

?>
