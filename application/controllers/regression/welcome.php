<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller
{	
	public function index()
	{
            $sid = 1;
            $week=2;
            $month=12;
            $syear=1953;
            $eyear = 2009;

            $this->load->model('station');
            $stationName= $this->station->getName($sid); ;
            $title = "Avg Min and Max temp on week #$week in month #$month from $syear to $eyear in $stationName";
            $yAxistitle = "Avg Min and Max temp ( ° Celsius)";
             //$this->load->model('weatherDataTemp');
             //echo 

            
             $data['array'] =  $this->avgMinMaxTempWeekly($sid,$week,$month,$syear,$eyear);
             $data['title'] = mysql_real_escape_string($title);
             $data['yAxistitle'] = mysql_real_escape_string($yAxistitle);
                //echo "var javascript_array = ". $js_array . ";\n";
            $this->load->view('lineChart',$data);
           // echo $this->maxTemp(1, 1, 1953);
        }

       
        public function avgMinMaxTempWeekly($sid,$week,$month,$syear,$eyear)
        {
            $sdate = 7*($week-1) + 1;
            $edate = 7*$week;
           

            $this->load->model('weatherDataTemp');

            $phpArray[] = array("Year","Avg Mintemp (° Celsius)","Avg Maxtemp(° Celsius)");
            
            for($year = $syear ; $year <= $eyear ; $year++)
            {
                 if($week==4 )
                $edate=  cal_days_in_month(CAL_GREGORIAN, $month  , $year);
                 
                $avgMin = $this->weatherDataTemp->avgMinTempBetweenTwoDate($sid,$year,$month,$sdate,$year,$month,$edate);
                $avgMax = $this->weatherDataTemp->avgMaxTempBetweenTwoDate($sid,$year,$month,$sdate,$year,$month,$edate);

                $phpArray[] = array("".$year,$avgMin,$avgMax);
            }
                $js_array = json_encode($phpArray,JSON_NUMERIC_CHECK);

                return $js_array;
	}
	
	
      
}

