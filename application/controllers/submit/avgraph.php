<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avgraph extends CI_Controller
{
     
	public function index()
	{
//AvgMax = -26.4439011985372+2.90626914651495E-02*Year
           
			$sid = 21;
            $syear=1950;
            $eyear = 2009;
	        $smonth=12;
            $emonth=2;
            $ismin=TRUE;
			$c =   66.49;
			$m = -2.62E-02;
			$sm = $this->getMonthString($smonth);
			$em = $this->getMonthString($emonth);
            $this->load->model('station');
            $stationName= $this->station->getName($sid);
		  // $stationName="CoxBazar";

                        $str = "Regression Line Equation : AvgMax = -26.44 + 2.91E-02*Year <br/>";
                        $str.= "R<sup>2</sup> : 0.56<br/>";
                        $str .= "Sens slope : 0.03";
                        echo $str;
            if($ismin)
            {
				$fileName = "avgMin ".$stationName."_".$smonth." to ".$emonth;
				$data['title'] = "Avarage Minimum Temperature(°C) in $stationName during $sm to $em";
			}
			
            else
            {
				$fileName = "avgMax ".$stationName."_".$smonth." to ".$emonth;
				$data['title'] = "Avarage Maximum Temperature(°C) in $stationName during $sm to $em ";
			}
			
           
			             $data['array'] = json_encode($this->avgTemp($sid,$smonth,$emonth,$syear,$eyear,$ismin,$fileName,$m,$c),JSON_NUMERIC_CHECK);
            
			
			
			$data['yAxistitle'] = "Temperature (°C)";
            /*echo "Regression Line Equation : AvgMax = -26.44 + 2.91E-02*Year <br/>";
            echo "R<sup>2</sup> : 0.56<br/>";
            echo "Sen's slope : 0.03";
             
             */


            $this->load->view('lineDefault',$data);

        }
		
		
			function getMonthString($n)
{
    $timestamp = mktime(0, 0, 0, $n, 1, 2005);
    
    return date("M", $timestamp);
}

        public function avgTemp($sid,$smonth,$emonth,$syear,$eyear,$ismin,$fileName,$m,$c)
        {
            $this->load->model('weatherDataTemp');
            $this->weatherDataTemp->avgMinMonthRangeYear($sid,$smonth,$emonth,1953);

            if($ismin)
                $array[] = array('Year','AvgMin','Regression Line');
            else
                 $array[] = array('Year','AvgMax','Regression Line');
            
            for($year = $syear ; $year <= $eyear ; $year++)
            {
				//if($sid==1 && $year=1974) continue;
                if($ismin)
                    $data = $this->weatherDataTemp->avgMinMonthRangeYear($sid,$smonth,$emonth,$year);
                else
                    $data = $this->weatherDataTemp->avgMaxMonthRangeYear($sid,$smonth,$emonth,$year);
				if(!$data) continue;
				
				$y = $m  * $year + $c;	
                $array[] =array($year,$data,$y);
                
            }
			
            return $array;
	}
	
	 
}

