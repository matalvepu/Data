<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MonthlyRainComparison extends CI_Controller
{	
	public function index()
	{

            $years = array(1975,1985,1995,2008);
            $sid = 1;
            
            //$phpArray[] = array('Month','1973','1983','1993','2003','2008');
            $phpArray[] = array('Month','1975','1985','1995','2008');
            for($month = 1 ; $month<=12 ; $month ++)
            {
                unset ($lilArray);
                $lilArray[]=$month;

                foreach($years as $year)
                {
                    $var = $this->totalRain($sid,$month,$year);
                    //echo str_pad(""+$var, 20, " ", STR_PAD_LEFT);
                    $lilArray[] = $var;
                }

                $phpArray[] = $lilArray;
                //echo "<br/>";
            }

            //print_r($phpArray);
        //$php_array = array(array(1,2,3),array(4,5,6),array(1,2,3));
                $js_array = json_encode($phpArray,JSON_NUMERIC_CHECK);


                //echo $js_array;
                $data['array'] = $js_array;

                //echo "var javascript_array = ". $js_array . ";\n";
          $this->load->view('rainCheckColumn',$data);
            /*
            $var = $this->totalRain(1, 2, 1970);
            echo $var;
            */
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

