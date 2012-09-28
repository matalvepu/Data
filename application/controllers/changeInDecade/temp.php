<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Temp extends CI_Controller
{
     
	public function index()
	{

            $sid = 1;
            $syear=1950;
            $eyear = 2009;
	    $month=1;
			
            $avgMaxMonsoon=0;
            $avgMinWinter=0;
            
            $this->load->model('station');
            $stationName= $this->station->getName($sid);
            //$stationName="CoxBazar";

            unset($min);
            unset($max);
            unset($phpArray);

            $phpArray[] = array("Month","Max Temp","Min Temp");
            echo $stationName."<br/>";
            for($month = 1; $month<=12; $month++)
            {
                $monthName = $this->getMonthString($month);
                
                $min = $this->avgTemp($sid,$month,$syear,$eyear,TRUE);
                $max = $this->avgTemp($sid, $month, $syear, $eyear, False);
				
                if($month>5 & $month<12 )
                {
                  $avgMaxMonsoon+=$max;
                }
                if($month>11 | $month<3 )
                {
                  $avgMinWinter+=$min;
                }
				
                
                 $phpArray[] = array($monthName,$max,$min);
                 
                echo "$monthName -> Min : $min Max : $max<br/>";
            }

            $avgMaxMonsoon/=6;
            $avgMinWinter/=3;
            echo "<br/> Avg Monsoon Maxtemp Increase per decade".$avgMaxMonsoon;
            echo "<br/> Avg WInter Mintemp Increase per decade".$avgMinWinter;
			
            $data['array'] = json_encode($phpArray,JSON_NUMERIC_CHECK);
            $data['title'] = "Change in temp ( °C/decade) in $stationName";
            $data['yAxistitle'] = " °C/decade";
			          
            $this->load->view('lineDefault',$data);

        }
        function getMonthString($n)
        {
            $timestamp = mktime(0, 0, 0, $n, 1, 2005);

            return date("M", $timestamp);
        }

        public function avgTemp($sid,$month,$syear,$eyear,$min)
        {
            
            $this->load->model('weatherDataTemp');

            $oldValue = 0;
            $count = 0;
            $sum = 0;
            for($year = $syear ; $year <= $eyear ; $year+=10)
            {
                $lyear = $year + 9;
                if($lyear>$eyear)$lyear = $eyear;

                    //echo "<br/>range $year -> $lyear";

                    
                if($min==TRUE)
                    $newVal= $this->weatherDataTemp->avgMinTempBetwenYear($sid,$year,$lyear,$month);
                else
                    $newVal= $this->weatherDataTemp->avgMaxTempBetwenYear($sid,$year,$lyear,$month);

                if($oldValue != 0)
                {
                    $diff = ($newVal-$oldValue);
                    $sum +=$diff;
                    $count++;
                }

                $oldValue = $newVal;
            }
             /*if($min==TRUE)
                echo " Mintemp : ". ($sum  / $count)."<br/>";
             else
               echo " Maxtemp : ". ($sum  / $count)."<br/>";*/

            return ($sum  / $count) ;

	}
	      
}

