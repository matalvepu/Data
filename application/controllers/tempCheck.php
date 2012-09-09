<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TempCheck extends CI_Controller
{	
	public function index()
	{

             $years = array(1953,1958,1963,1968,1973,1978,1983,1988,1993,1998,2003,2008);
             //$years = array(1970,1975,1980,1985,1990,1995,2000,2005);

            $sid = 1;
             $month = 1;
             
            


             $data['array'] =  $this->prepareChart($sid,$month,$years);

                //echo "var javascript_array = ". $js_array . ";\n";
            $this->load->view('tempCheckCandle',$data);
           // echo $this->maxTemp(1, 1, 1953);
        }

        function minTemp($sid,$month,$year)
        {
            $q = $this->db->query("SELECT MIN( mintemp ) AS a FROM weatherdata WHERE sid = ? AND MONTH( wdate ) = ? AND YEAR( wdate ) = ?",array($sid,$month,$year));
            return $q->row()->a;
        }
         function maxTemp($sid,$month,$year)
        {
            $q = $this->db->query("SELECT MAX( maxtemp ) AS a FROM weatherdata WHERE sid = ? AND MONTH( wdate ) = ? AND YEAR( wdate ) = ?",array($sid,$month,$year));
            return $q->row()->a;
        }
        public function prepareChart($sid,$month,$years)
        {
                foreach($years as $year)
                {
                    unset ($lilArray);
                    
                    $lilArray[] = "On $year";
                    $lilArray[]=0;

                    $mintotal = 0;
                    $maxtotal = 0;

                    $minCount = 0;
                    $maxCount = 0;
                    
                    for($i=0;$i<5;$i++)
                    {
                        $min = $this->minTemp($sid, $month, $year);
                        $max = $this->maxTemp($sid, $month, $year);

                        if(!($min == NULL || $min == 0))
                        {
                            $mintotal += $min;
                            $minCount++;
                        }

                        if(!($max == NULL || $max == 0))
                        {
                            $maxtotal += $max;
                            $maxCount++;
                        }               
                    }
                    
                     $lilArray[] = ($mintotal/$minCount) ;
                     $lilArray[] = ($maxtotal/$maxCount) ;

                     $lilArray[]=100;
                     //echo str_pad(""+$var, 20, " ", STR_PAD_LEFT);
                     $phpArray[] = $lilArray;
                }

               // print_r($phpArray);
                
                $js_array = json_encode($phpArray,JSON_NUMERIC_CHECK);

               // print_r($js_array);

                return $js_array;
	}
	
	public function totalRain($sid,$month,$year)
	{
		$q = $this->db->query("SELECT SUM(rainfall) AS a FROM weatherdata WHERE sid = ? AND MONTH(wdate) = ? AND YEAR(wdate) = ? ",array($sid,$month,$year));
		return $q->row()->a;

	}
        public function echoRainMissingDays($sid)
        {
	echo "FOLLOWING DAYS HAVE -1 as RAIN DATA IN DHAKA";

            $this->load->model('dataTransfer');
            
            set_time_limit(0);
            $q = $this->db->query("SELECT wdate FROM  `weatherdata` WHERE sid = ? AND `rainfall` = -1",$sid);
	    
	    foreach($q->result() as $row)
            {
                echo $row -> wdate;
                echo "<br/>";
            }
        }
}

