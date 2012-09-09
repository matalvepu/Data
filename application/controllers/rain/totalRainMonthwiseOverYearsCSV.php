<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TotalRainMonthwiseOverYearsCSV extends CI_Controller
{	
	public function index()
	{


             //echo "HELLO";
            
             $sid  = 21;
             $startYear=1970;
             $endYear = 2009;
             $this->load->model('station');
             $stationName= $this->station->getName($sid);

             $fileName = "Monthwise Rain".$stationName;

             $this->avgMinMaxTempWeekly($sid,$startYear,$endYear,$fileName);
           // echo $this->maxTemp(1, 1, 1953);
        }


        public function avgMinMaxTempWeekly($sid,$syear,$eyear,$fileName)
        {
      
            $this->load->model('weatherDataRain');

            $array[] = array('Year','Rainfall');
            for($year = $syear ; $year <= $eyear ; $year++)
            {
                for($month=1;$month<=12;$month++)
                {
                    $avgRain = $this->weatherDataRain->totalRainMonthYear($sid,$month,$year);
                    $array[] =array($year." - ".$month,$avgRain);
                }
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

