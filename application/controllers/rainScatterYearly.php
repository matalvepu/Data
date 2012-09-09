<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RainScatterYearly extends CI_Controller
{	
	public function index()
	{


             //echo "HELLO";
            
             $sid  = 1;
             $year = 2009;
             $stationName ="Dhaka";
           
             $data['array'] =  $this->prepareChart($sid,$year);
             $data['title'] = "Distribution of rain(mm) in $stationName in the year $year";

             
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
        public function prepareChart($sid,$year)
        {
             $phpArray[] = array('Rainfall','Days');

             $rains = $this->distinctRain($sid,$year);

             $missing = 0;
             $zero=0;
             foreach ($rains as $rain)
             {

                 $count = $this->countDaysRainingThatMuch($sid,$year, $rain);

                if($rain==NULL )
                {
                    $missing = $count;
                }
                else if($rain == 0)
                {
                    $zero = $count;
                }
                else
                {
                     echo "$rain   ->   $count<br/>";
                     $phpArray[]=array($rain,$count);
                }
             }
                
            $js_array = json_encode($phpArray,JSON_NUMERIC_CHECK);

           // print_r($js_array);

            echo "Missing : $missing days' data<br/>No rain in $zero days<br/>";
            return $js_array;
	}
	
	
}

