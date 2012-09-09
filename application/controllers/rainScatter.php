<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RainScatter extends CI_Controller
{	
	public function index()
	{


             echo "HELLO";
            
             $sid = 1;
             $stationName ="Dhaka";
           
             $data['array'] =  $this->prepareChart($sid);
             $data['title'] = "Distribution of rain(mm) in $stationName";

             
             //$this->load->view('rainScatterView',$data);
           // echo $this->maxTemp(1, 1, 1953);
        }

        public function distinctRain($sid)
        {
            $q = $this->db->query("SELECT DISTINCT(rainfall) FROM weatherdata WHERE sid = ? ORDER BY rainfall",$sid);

            foreach ($q->result() as $row)
            {
                if($row->rainfall == NULL )
                {

                }
                else if($row->rainfall == 0)
                {
                    
                }
                else
                {
                    $ret[] = $row->rainfall;
                }
            }
            return $ret;
        }
        public function countDaysRainingThatMuch($sid,$rain)
        {
            $q = $this->db->query("SELECT COUNT(*) AS a FROM weatherdata WHERE sid = ? AND rainfall = ?",array($sid,$rain));
	    return $q->row()->a;
            
        }
        public function prepareChart($sid)
        {
            
             $phpArray[] = array('Rainfall','Days');

             $rains = $this->distinctRain($sid);
             
             foreach ($rains as $rain)
             {

                 $count = $this->countDaysRainingThatMuch($sid, $rain);

                 echo "$rain   ->   $count<br/>";
                 $phpArray[]=array($rain,$count);
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

