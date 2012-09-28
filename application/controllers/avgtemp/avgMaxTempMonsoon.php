<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class avgMaxTempMonsoon extends CI_Controller
{
     
	public function index()
	{
            $sid = 1;
            $syear=1956;
            $eyear = 2009;
	           
            $months=array(6,7,8,9);
            
            $this->load->model('station');
            $stationName= $this->station->getName($sid);
            // $ltl = ($which==1)?"1st":"2nd";

            $fileName = "avgMaxMOnsoon ".$stationName;
            $this->avgMaxTemp($sid,$months,$syear,$eyear,$fileName);

        }

        public function avgMaxTemp($sid,$monthArray,$syear,$eyear,$fileName)
        {
            
            $this->load->model('weatherDataTemp');

            $array[] = array('Year','AvgMax');
            for($year = $syear ; $year <= $eyear ; $year++)
            {
                $avg = 0;
                $count = 0;
                foreach ($monthArray as $month)
                {
                    $avg += $this->weatherDataTemp->avgMaxTempMonthYear($sid,$month,$year);
                    $count++;
                //    echo "$year - $month <br/>";
                }
                $avg /= $count;
                
                $array[] =array($year,$avg);
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

