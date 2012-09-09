
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RainInBorsha5 extends CI_Controller
{

	public function index()
	{

             $sid = 1;
             $year = 1971;
             $type=1;
             
             $stationName = "Dhaka";
             if($type==1)
             {
                 $data['array'] =  $this->prepareChart1($sid,$year);
                 $data['title'] = "Rainfall in Different Months in $stationName in $year";
             }

            $this->load->view('rainInBorshaView',$data);
           // echo $this->maxTemp(1, 1, 1953);
        }

        public function prepareChart1($sid,$year)
        {
             $phpArray[] = array('Month','Rainfall');
        
             for($month = 1; $month<=12; $month++)
             {
                 $phpArray[] =  array("$month",  $this->totalRainMonthly($sid, $month, $year));
             }

           //  print_r($phpArray);
            $js_array = json_encode($phpArray,JSON_NUMERIC_CHECK);

           // print_r($js_array);

            return $js_array;
	}

  
        public function totalRainMonthly($sid,$month,$year)
	{
		$q = $this->db->query("SELECT SUM(rainfall) AS a FROM weatherdata WHERE sid = ? AND MONTH(wdate) = ? AND YEAR(wdate) = ? ",array($sid,$month,$year));
		return $q->row()->a;

	}
        

        
}

