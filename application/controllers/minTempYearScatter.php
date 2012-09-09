<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MinTempYearScatter extends CI_Controller
{	
	public function index()
	{

            

             $sid = 1;
             $month = 1;

             $data['array'] =  $this->prepareChart($sid,1953);

            $this->load->view('minTempYearScatterView',$data);
           // echo $this->maxTemp(1, 1, 1953);
        }
        function nextDate($inputDate)
        {
            $format = 'Y-m-d';
            $usersTS = strtotime($inputDate);
            if($usersTS !== false){
              //echo 'And the 3 dates are: ';
              //echo date($format, strtotime('+1 day', $usersTS));

              return date($format, strtotime('+1 day', $usersTS));
            }
            else{
              echo "not a valid date : $inputDate<br/>";
}
        }
        function minTemp($sid,$month,$year)
        {
            $q = $this->db->query("SELECT MIN( mintemp ) AS a FROM weatherdata WHERE sid = ? AND MONTH( wdate ) = ? AND YEAR( wdate ) = ?",array($sid,$month,$year));
            return $q->row()->a;
        }

        function minTempDate($sid,$date)
        {
            $q = $this->db->query("SELECT mintemp AS a FROM weatherdata WHERE sid = ? AND wdate = ?",array($sid,$date));
            return $q->row()->a;
        }
        
        function maxTemp($sid,$month,$year)
        {
            $q = $this->db->query("SELECT MAX( maxtemp ) AS a FROM weatherdata WHERE sid = ? AND MONTH( wdate ) = ? AND YEAR( wdate ) = ?",array($sid,$month,$year));
            return $q->row()->a;
        }
        public function prepareChart($sid,$year)
        {
             $date = "$year-01-1";
             
             $phpArray[] = array('date','mintemp');

             for($x = 1; $x<365;)
             {
                 $min = $this->minTempDate($sid, $date);
                 
                 //unset ($lilArray);
                 $lilArray = array($x,$min);
                 $phpArray[] = $lilArray;

                 $date = $this->nextDate($date);
                 $x++;
             }

                
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

