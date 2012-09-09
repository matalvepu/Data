<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Util extends CI_Controller 
{	
	public function index()
	{
		
            $this->echoRainMissingDays(1);
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

