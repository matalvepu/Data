<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RainlessDay extends CI_Controller
{	
	public function index()
	{


             //echo "HELLO";
            
             $sid  = 19;
             $startYear=1970;
             $endYear = 2009;
             $stationName ="Dhaka";
           
             $data['array'] =  $this->prepareChart($sid,$startYear,$endYear);
             $data['title'] = "Rainless Days in $stationName";

             
             $this->load->view('rainScatterView',$data);
           // echo $this->maxTemp(1, 1, 1953);
        }

        public function distinctRain($sid,$year)
        {
            $q = $this->db->query("SELECT DISTINCT(rainfall) FROM weatherdata WHERE sid = ? AND year(wdate)= ? ORDER BY rainfall",array($sid,$year));

            
             foreach ($q->result() as $row)
            {
                if($row->rainfall == NULL )
                {
                    //$missing++;
                    $ret[] = $row->rainfall;
                }
                else if($row->rainfall == 0)
                {
                    //$zero++;
                    $ret[] = $row->rainfall;
                }
                else
                {
                    $ret[] = $row->rainfall;
                }
            }
            
            return $ret;
        }
        public function countDaysRainingThatMuch($sid,$year,$rain)
        {
            $q = $this->db->query("SELECT COUNT(*) AS a FROM weatherdata WHERE sid = ? AND year(wdate)= ?  AND rainfall = ?",array($sid,$year,$rain));
	    return $q->row()->a;
        }
        public function countUnavailableData($sid,$year)
        {
            $q = $this->db->query("SELECT COUNT(*) AS a FROM weatherdata WHERE sid = ? AND year(wdate)= ?  AND rainfall IS NULL",array($sid,$year));
	    return $q->row()->a;
        }
       
        public function prepareChart($sid,$startYear,$endYear)
        {
             $phpArray[] = array('Year','Rainless Days');

            $unstring="";

             for($year=$startYear;$year <=$endYear;$year++)
             {
                 $rainlessDays = $this->countDaysRainingThatMuch($sid,$year,0);

                 $phpArray[] = array($year,$rainlessDays);
                 
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

