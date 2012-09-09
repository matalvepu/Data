
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RainInBorsha5 extends CI_Controller
{

	public function index()
	{

             $sid = 1;
             $startYear = 1970;
        
             $type = 1;
             

             $stationName = "Dhaka";
             if($type==1)
             {
                 $data['array'] =  $this->prepareChart1($sid,$startYear,$endYear);
                 $data['title'] = "% of Total Rain in Borshakal (June 14 -> August 13) in $stationName";
             }

            $this->load->view('rainInBorshaView',$data);
           // echo $this->maxTemp(1, 1, 1953);
        }

        public function prepareChart1($sid,$startYear,$endYear)
        {
             echo "No data available of Dhaka in 1974.Skipped";

            
             $phpArray[] = array('Year','% of Rain in Borsha');
        
             for($year = $startYear; $year<=$endYear; $year++)
             {
                 if($year==1974 && $sid==1) //DHAKA 1974 er data silo na
                     continue;

                 
                 $rain = $this->totalRainInBorsha($sid, $year);

                 $total =  $this->totalRain($sid, $year);

                 $percent = ($rain/$total)*100;

                 $phpArray[] =  array("$year",$percent);

             }

           //  print_r($phpArray);
            $js_array = json_encode($phpArray,JSON_NUMERIC_CHECK);

           // print_r($js_array);

            return $js_array;
	}

        
	
	public function totalRainInBorsha($sid,$year)
	{
		$q = $this->db->query("SELECT SUM(rainfall) AS a FROM weatherdata WHERE sid = ? AND  `wdate` >=  '?-6-14' AND  `wdate` <=  '?-8-13'",array($sid,$year,$year));
		return $q->row()->a;
	}

        public function totalRain($sid,$year)
	{
		$q = $this->db->query("SELECT SUM(rainfall) AS a FROM weatherdata WHERE sid = ? AND  YEAR(`wdate`)= ?",array($sid,$year));
		return $q->row()->a;
	}
        

        public function totalMinusOne($sid,$year)
	{
		$q = $this->db->query("SELECT COUNT(*) AS a FROM weatherdata WHERE sid = ? AND  `wdate` >=  '?-6-14' AND  `wdate` <=  '?-8-13' AND rainfall=-1",array($sid,$year,$year));
		return $q->row()->a;
	}
        public function totalNull($sid,$year)
	{
		$q = $this->db->query("SELECT COUNT(*) AS a FROM weatherdata WHERE sid = ? AND  `wdate` >=  '?-6-14' AND  `wdate` <=  '?-8-13' AND rainfall IS NULL",array($sid,$year,$year));
		return $q->row()->a;
	}
        
}

