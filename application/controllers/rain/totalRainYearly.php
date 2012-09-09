<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TotalRainYearly extends CI_Controller
{	
	public function index()
	{


             //echo "HELLO";
            
             $sid  = 1;
             $startYear=1970;
             $endYear = 2009;
             //$stationName ="Cox\'s Bazaar";
             $stationName ="Dhaka";
             $data['array'] =  $this->prepareChart($sid,$startYear,$endYear);
             $data['title'] = "Total rain yearly in $stationName";

             
             $this->load->view('avgDecadeWinterTempRangeView',$data);
           // echo $this->maxTemp(1, 1, 1953);
        }

        public function totalRainInYear($sid,$year)
        {
            $q = $this->db->query("SELECT SUM(rainfall) AS a FROM weatherdata WHERE sid = ? AND year(wdate)= ? ",array($sid,$year));
	    return $q->row()->a;
        }

        
        public function countUnavailableData($sid,$year)
        {
            $q = $this->db->query("SELECT COUNT(*) AS a FROM weatherdata WHERE sid = ? AND year(wdate)= ?  AND rainfall IS NULL",array($sid,$year));
	    return $q->row()->a;
        }
       
        public function prepareChart($sid,$startYear,$endYear)
        {
             $phpArray[] = array('Year','Total Rain');

            $unstring="";

             for($year=$startYear;$year <=$endYear;$year++)
             {
                 $rain = $this->totalRainInYear($sid, $year);

                 $phpArray[] = array("".$year,$rain);
                 
                 $unavailableData = $this->countUnavailableData($sid, $year);
                 if($unavailableData>0)
                 {
                    $unstring.="$year -> $unavailableData<br/>";
                 }
             }
            $js_array = json_encode($phpArray,JSON_NUMERIC_CHECK);

           // print_r($js_array);

            echo "Data Missing:<br/> $unstring";
            //echo "Missing : $missing days' data<br/>No rain in $zero days<br/>";
            return $js_array;
	}
	
	
}

