<?php

  class Color
  {
    private $blue;
    private $red;
    private $green;
    public static $verbose = false;

    public function __construct(array $input_color)
    {
      if (array_key_exists('rgb',$input_color))
      {
        $input_color = explode(',', $input_color['rgb']);
        $this->blue = intval($input_color[0]);
        $this->red = intval($input_color[1]);
        $this->green = intval($input_color[2]);
        if (Color::$verbose)
          print_r($this->print_construct(true));
      }
      else if (array_key_exists('red', $input_color)
              && array_key_exists('green', $input_color)
              && array_key_exists('blue', $input_color))
              {
                $this->blue = intval($input_color['red']);
                $this->blue = intval($input_color['green']);
                $this->blue = intval($input_color['blue']);
                echo 'success saving';
              }
      else
        echo 'test';
    }

    private function print_construct($construct)
    {
      $color = 'Color( red: ' . $this->convert_string_spaces($this->red);
      $color .= ', green: ' . $this->convert_string_spaces($this->green);
      $color .= ', blue: ' . $this->convert_string_spaces($this->blue) . ' )';
      $state = ($construct) ? 'constructed.' : 'destructed';
      return ($color . ' ' . $state . "\n");
    }

    private function convert_string_spaces($str)
    {
      $length = strlen($str);
      $ret = "";
      if ($length == 3)
        return ($str);
      for ($i = 0; strlen($str) + $i < 3; $i++)
        $ret .= ' ';
      $ret .= $str;
      return ($ret);
    }
  }

?>
