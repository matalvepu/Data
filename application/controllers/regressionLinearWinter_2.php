<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RegressionLinearWinter extends CI_Controller
{
     
	public function index()
	{

           // $x_bar = 1;
            //$y_bar = 1;
           // $xy_bar = 2;
           // $x_sqr_bar = 2;

           // $this->load->library('LinearRegression');
            //$m = $this->get_m($x_bar , $y_bar , $xy_bar , $x_sqr_bar );
           // echo "M -> $m ";

         //   $b = $this->get_b($x_bar , $y_bar , $m);
         //   echo "B -> $b";
            $sid = 1;
            $which=2;
            $month=11;
            $syear=1953;
            $eyear = 2009;

            
            $this->load->model('station');
            $stationName= $this->station->getName($sid);
            $ltl = ($which==1)?"1st":"2nd";
            $fileName = $stationName." ".$ltl;

            $this->avgMinMaxTempWeekly($sid,$which,$month,$syear,$eyear,$fileName);
            
            /*
            $title = "Avg Min and Max temp on $ltl 15days in month #$month from $syear to $eyear in $stationName";
            //echo $title;
            $yAxistitle = "Avg Min and Max temp ( ° Celsius)";
             //$this->load->model('weatherDataTemp');
             //echo 

            
             $data['array'] =  $this->avgMinMaxTempWeekly($sid,$which,$month,$syear,$eyear);
             $data['title'] = mysql_real_escape_string($title);
             $data['yAxistitle'] = mysql_real_escape_string($yAxistitle);
                //echo "var javascript_array = ". $js_array . ";\n";
           // $this->load->view('lineChart',$data);
           // echo $this->maxTemp(1, 1, 1953);
            * */
            
        }

        public function avgMinMaxTempWeekly($sid,$which,$month,$syear,$eyear,$fileName)
        {
            $sdate = ($which==1)?1:16;
            $edate = ($which==1)?15:30;


            $this->load->model('weatherDataTemp');

            $array[] = array('Year','AvgMin');
            for($year = $syear ; $year <= $eyear ; $year++)
            {
                
                 if($which==2)
                $edate=  cal_days_in_month(CAL_GREGORIAN, $month  , $year);
                 
                $avgMin = $this->weatherDataTemp->avgMinTempBetweenTwoDate($sid,$year,$month,$sdate,$year,$month,$edate);
                $array[] =array($year,$avgMin);

                //$phpArray[] = array("".$year,$avgMin,$avgMax);
            }

            $this->array_to_csv($array, $fileName.'\.csv');
	}
	
	function array_to_csv($array, $download = "")
    {
        if ($download != "")
        {
            header('Content-Type: application/csv');
            header('Content-Disposition: attachement; filename="' . $download . '"');
        }

        ob_start();
        $f = fopen('php://output', 'w') or show_error("Can't open php://output");
        $n = 0;
        foreach ($array as $line)
        {
            $n++;
            if ( ! fputcsv($f, $line))
            {
                show_error("Can't write line $n: $line");
            }
        }
        fclose($f) or show_error("Can't close php://output");
        $str = ob_get_contents();
        ob_end_clean();

        if ($download == "")
        {
            return $str;
        }
        else
        {
            echo $str;
        }
    }
      
}

