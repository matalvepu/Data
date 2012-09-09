<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avg extends CI_Controller
{
     
	public function index()
	{

            $sid = 21;
            $syear=1950;
            $eyear = 2009;
	        $smonth=12;
            $emonth=2;
            $ismin=TRUE;
            $this->load->model('station');
            $stationName= $this->station->getName($sid);

            if($ismin)
                $fileName = "avgMin ".$stationName."_".$smonth." to ".$emonth;
            else
                $fileName = "avgMax ".$stationName."_".$smonth." to ".$emonth;


            $this->avgTemp($sid,$smonth,$emonth,$syear,$eyear,$ismin,$fileName);

            
        }

        public function avgTemp($sid,$smonth,$emonth,$syear,$eyear,$ismin,$fileName)
        {
            $this->load->model('weatherDataTemp');
            $this->weatherDataTemp->avgMinMonthRangeYear($sid,$smonth,$emonth,1953);
            
            

            if($ismin)
                $array[] = array('Year','AvgMin');
            else
                 $array[] = array('Year','AvgMax');
            
            for($year = $syear ; $year <= $eyear ; $year++)
            {
                if($ismin)
                    $data = $this->weatherDataTemp->avgMinMonthRangeYear($sid,$smonth,$emonth,$year);
                else
                    $data = $this->weatherDataTemp->avgMaxMonthRangeYear($sid,$smonth,$emonth,$year);

                $array[] =array($year,$data);
                
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

