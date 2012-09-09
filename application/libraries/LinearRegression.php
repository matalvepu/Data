<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LinearRegression {

    public function get_m($x_bar , $y_bar , $xy_bar , $x_sqr_bar )
    {

        $lob = ($x_bar * $y_bar) - $xy_bar ;
        $hor = ($x_bar * $x_bar) - $x_sqr_bar;

        return $lob/$hor;
        
    }

    public function get_b($x_bar , $y_bar , $m)
    {
        return ($y_bar - $m * $x_bar);
    }
}


?>
