<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RegressionLinearWinterMonthly extends CI_Controller
{
     
	public function index()
	{


            $sid = 1;
            $month=9;
            $syear=1953;
            $eyear = 2009;

            
            $this->load->model('station');
            $stationName= $this->station->getName($sid);
           // $ltl = ($which==1)?"1st":"2nd";
            $fileName = $stationName."_".$month;

            $this->avgMinTempMonthly($sid,$month,$syear,$eyear,$fileName);
            
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

        public function avgMinTempMonthly($sid,$month,$syear,$eyear,$fileName)
        {
            
            $this->load->model('weatherDataTemp');

            $array[] = array('Year','AvgMin');
            for($year = $syear ; $year <= $eyear ; $year++)
            {
                $avgMin = $this->weatherDataTemp->avgMinTempMonthYear($sid,$month,$year);
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

