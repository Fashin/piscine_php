<?php

class Matrix
{
  const IDENTITY = array("identity", NULL, NULL);
  const SCALE = array("scale", matrice_scale, array('scale'));
  const TRANSLATION = array('translation', matrice_translation, array('vtc'));
  const PROJECTION = array('projection', matrice_projection, array('ratio', 'fov', 'near', 'far'));
  const RX = array('rx', matrice_rotation, array('angle'));
  const RY = array('ry', matrice_rotation, array('angle'));
  const RZ = array('rz', matrice_rotation, array('angle'));

  private $matrice = array(
    0 => array('M', 'vtcX', 'vtcY', 'vtcZ', 'vtx0'),
    1 => array('x', 1.0, 0.0, 0.0, 0.0),
    2 => array('y', 0.0, 1.0, 0.0, 0.0),
    3 => array('z', 0.0, 0.0, 1.0, 0.0),
    4 => array('w', 0.0, 0.0, 0.0, 1.0)
  );

  public static $verbose = FALSE;

  function __construct($params)
  {
    if (array_key_exists('preset', $params))
    {
      if ($params['preset'][2] !== NULL)
        foreach ($params['preset'][2] as $k => $v)
          if (!(array_key_exists($v, $params)))
            exit(1);
      if (self::$verbose)
        echo "Matrice " . strtoupper($params['preset'][0]) . " preset instance constructed\n";
      if ($params['preset'][1] !== NULL)
        $this->$params['preset'][1]($params);
    }
  }

  private function matrice_translation($params)
  {
    $vtx = $params['vtc'];
    $this->matrice[1][4] = $vtx->_get('_x');
    $this->matrice[2][4] = $vtx->_get('_y');
    $this->matrice[3][4] = $vtx->_get('_z');
  }

  private function matrice_scale($params)
  {
    $scale = floatval($params['scale']);
    $this->matrice[1][1] = $this->matrice[1][1] * $scale;
    $this->matrice[2][2] = $this->matrice[2][2] * $scale;
    $this->matrice[3][3] = $this->matrice[3][3] * $scale;
    $this->matrice[4][4] = $this->matrice[4][4] * $scale;
  }

  private function matrice_rotation($params)
  {
    $angle = floatval($params['angle']);
    $rot = $params['preset'][0];
    if ($rot == 'rx')
    {
      $this->matrice[2][2] = cos($angle);
      $this->matrice[2][3] = (sin($angle) * (-1));
      $this->matrice[3][2] = sin($angle);
      $this->matrice[3][3] = cos($angle);
    }
    else if ($rot == 'ry')
    {
      $this->matrice[1][1] = cos($angle);
      $this->matrice[1][3] = sin($angle);
      $this->matrice[3][1] = (sin($angle) * (-1));
      $this->matrice[3][3] = cos($angle);
    }
    else
    {
      $this->matrice[1][1] = cos($angle);
      $this->matrice[1][2] = (sin($angle) * (-1));
      $this->matrice[2][1] = sin($angle);
      $this->matrice[2][2] = cos($angle);
    }
  }

  private function matrice_projection($params)
  {
    $fov = floatval($params['fov']);
    $ratio = floatval($params['ratio']);
    $near = floatval($params['near']);
    $far = floatval($params['far']);
    $scale = tan(deg2rad($fov * 0.5)) * $near;

    $this->matrice[1][1] = (2 * $near) / (($ratio * $scale) - (($ratio * $scale) * (-1)));
    $this->matrice[1][2] = 0;
    $this->matrice[1][3] = (($ratio * $scale) + (($ratio * $scale) * (-1))) / (($ratio * $scale) - (($ratio * $scale) * (-1)));
    $this->matrice[1][4] = 0;

    $this->matrice[2][1] = 0;
    $this->matrice[2][2] = (2 * $near) / ($scale - ($scale * (-1)));
    $this->matrice[2][3] = ($scale + ($scale * (-1))) / ($scale - ($scale * (-1)));
    $this->matrice[2][4] = 0;

    $this->matrice[3][1] = 0;
    $this->matrice[3][2] = 0;
    $this->matrice[3][3] = -(($far + $near) / ($far - $near));
    $this->matrice[3][4] = -((2 * $far * $near) / ($far - $near));

    $this->matrice[4][1] = 0;
    $this->matrice[4][2] = 0;
    $this->matrice[4][3] = -1;
    $this->matrice[4][5] = 0;
  }

  public function mult($rhs)
  {
    $old_verbose = Matrix::$verbose;
    Matrix::$verbose = FALSE;
    $m1 = new Matrix(array('preset'=>Matrix::IDENTITY));
    Matrix::$verbose = $old_verbose;
    for ($i = 1; $i < 5; $i++)
    {
      for ($j = 1; $j < 5; $j++)
      {
        $un = floatval($this->matrice[$i][1] * $rhs->matrice[1][$j]);
        $deux = floatval($this->matrice[$i][2] * $rhs->matrice[2][$j]);
        $trois = floatval($this->matrice[$i][3] * $rhs->matrice[3][$j]);
        $quatre = floatval($this->matrice[$i][4] * $rhs->matrice[4][$j]);
        $m1->matrice[$i][$j] = floatval($un + $deux + $trois + $quatre);
      }
    }
    return ($m1);
  }

  public function transformVertex($vtx)
  {
    for ($i = 1; $i < 5; $i++)
    {
      $count = 0;
      for ($j = 1; $j < 5; $j++)
        $count = $count + $this->matrice[$i][$j];
      $ret[] = $vtx->_get("_" . $this->matrice[$i][0]) + $count;
    }
    return (new Vector(array('dest' => new Vertex(array(
      'x' => $ret[0],
      'y' => $ret[1],
      'z' => $ret[2],
      'w' => $ret[3]
    )))));
  }

  public function transpose()
  {
    $mx1 = new Matrix(array('preset' => Matrix::IDENTITY));
    for ($i = 1; $i < 5; $i++)
      for ($j = 1; $j < 5; $j++)
        $mx1->matrice[$i][$j] = $this->matrice[$j][$i];
    return ($mx1);
  }

  public function __toString()
  {
    $ret = "";
    for ($i = 0; $i < 5; $i++)
    {
      for ($j = 0; $j < 5; $j++)
      {
        if ($j > 0 && $i > 0)
          $ret = $ret . sprintf(" %.2f", $this->matrice[$i][$j]);
        else
          $ret = $ret . sprintf(" %s |", $this->matrice[$i][$j]);
        if ($j < 4 && $i > 0 && $j > 0)
          $ret = $ret . " |";
      }
      if ($i == 0)
        $ret = $ret . "\n--------------------------------";
      if ($i < 4)
        $ret = $ret . "\n";
    }
    return ($ret);
  }

  function __destruct()
  {
    if (Matrix::$verbose)
      echo "Matrix instance destructed\n";
  }

}

?>
