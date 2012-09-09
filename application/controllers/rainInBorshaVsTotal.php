

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RainInBorshaVsTotal extends CI_Controller
{

	public function index()
	{

             $sid = 19;
             $startYear = 1970;
             $endYear = 2009;
             $type = 1;
             //echo "here";

             $stationName = "Coxs Bazaar";
             if($type==1)
             {
                 $data['array'] =  $this->prepareChart1($sid,$startYear,$endYear);
                 $data['title'] = "Rain in Borshakal Vs Total Rain(June 14 -> August 13) in $stationName";
             }

            $this->load->view('rainInBorshaView',$data);
           // echo $this->maxTemp(1, 1, 1953);
        }
           public function countUnavailableData($sid,$year)
        {
            $q = $this->db->query("SELECT COUNT(*) AS a FROM weatherdata WHERE sid = ? AND year(wdate)= ?  AND rainfall IS NULL",array($sid,$year));
	    return $q->row()->a;
        }
       
        public function prepareChart1($sid,$startYear,$endYear)
        {
             echo "No data available of Dhaka in 1974.Skipped";

            
             $phpArray[] = array('Year','Rain in Borsha',"Total rain");
          $unstring="<br/>";
             for($year = $startYear; $year<=$endYear; $year++)
             {
                 if($year==1974 && $sid==1) //DHAKA 1974 er data silo na
                     continue;

                 
                 $rain = $this->totalRainInBorsha($sid, $year);

                 $total =  $this->totalRain($sid, $year);

                 

                 $phpArray[] =  array("$year",$rain,$total);
                 $unavailableData = $this->countUnavailableData($sid, $year);
                 if($unavailableData>0)
                 {
                    $unstring.="$year -> $unavailableData<br/>";
                 }
             }

           //  print_r($phpArray);
            $js_array = json_encode($phpArray,JSON_NUMERIC_CHECK);

           // print_r($js_array);
echo $unavailableData;
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

