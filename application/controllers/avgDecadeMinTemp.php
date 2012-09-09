<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AvgDecadeMinTemp extends CI_Controller
{	
	public function index()
	{

            //$years = array(1950,1960,1970,1980,1990,2000);

            $years = array(1950,1955,1960,1965,1970,1975,1980,1985,1990,1995,2000,2005);
            $range = 4;
            $sid = 19;

            $data['array'] = $this->prepareGraph($sid, $years,$range);
            $this->load->view('avgDecadeMinTempView',$data);
            
	}

        public function avgMinTempRangeWinter($sid,$startYear,$endYear)
        {
             $q = $this->db->query("SELECT AVG(mintemp) AS a FROM weatherdata WHERE sid = ? AND MONTH(`wdate`) IN (12, 1, 2) AND YEAR( `wdate` ) >= ? AND YEAR(  `wdate` )<= ?",array($sid,$startYear,$endYear));
             return $q->row()->a;
        }
         public function avgMaxTempRangeWinter($sid,$startYear,$endYear)
        {
             $q = $this->db->query("SELECT AVG(maxtemp) AS a FROM weatherdata WHERE sid = ? AND MONTH(`wdate`) IN (12, 1, 2) AND YEAR( `wdate` ) >= ? AND YEAR(  `wdate` )<= ?",array($sid,$startYear,$endYear));
             return $q->row()->a;
        }

        public function prepareGraph($sid,$years,$range)
        {

            $phpArray[] = array('Year','Min','Max');

                foreach($years as $syear)
                {
                    $syear += 1;
                   $eyear = $syear + $range;
                   $min = $this->avgMinTempRangeWinter($sid, $syear, $eyear);
                   $max = $this->avgMaxTempRangeWinter($sid, $syear, $eyear);

                    $phpArray[] = array("$syear - $eyear",$min,$max);;
                }

       
                $js_array = json_encode($phpArray,JSON_NUMERIC_CHECK);

                return $js_array;
        }

       
       
}

