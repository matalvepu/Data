<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MovingTemp extends CI_Controller
{
     
	public function index()
	{

            $sid = 1;
            $syear=1953;
            $eyear = 2009;
	    $month=1;
            
            $this->load->model('station');
            $stationName= $this->station->getName($sid);
          

            echo $stationName."<br/>";
            for($month = 1; $month<=12; $month++)
            {
                echo "$month -> ";
                $this->avgMaxTemp($sid,$month,$syear,$eyear,TRUE);
                $this->avgMaxTemp($sid,$month,$syear,$eyear,FALSE);
            }
        }

        public function avgMaxTemp($sid,$month,$syear,$eyear,$min)
        {
            
            $this->load->model('weatherDataTemp');

            $oldValue = 0;
            $count = 0;
            $sum = 0;
            for($year = $syear ; ($year+9) <= $eyear ; $year++)
            {
                $leftRange1 = $year ;
                $rightRange1 = $leftRange1 + 4;

                $leftRange2 = $year+5 ;
                $rightRange2 = $leftRange2 + 4;


                echo "<br/> $leftRange2->$rightRange2  -  $leftRange1->$rightRange1 ";
                if($min==TRUE)
                {
                    $oldVal = $this->weatherDataTemp->avgMinTempBetwenYear($sid,$leftRange1,$rightRange1,$month);
                    $newVal= $this->weatherDataTemp->avgMinTempBetwenYear($sid,$leftRange2,$rightRange2,$month);
                }
                else
                {
                    $oldVal = $this->weatherDataTemp->avgMaxTempBetwenYear($sid,$leftRange1,$rightRange1,$month);
                    $newVal= $this->weatherDataTemp->avgMaxTempBetwenYear($sid,$leftRange2,$rightRange2,$month);
                }

                
                $diff = ($newVal-$oldValue);
                $sum +=$diff;
                $count++;
               
            }
             if($min==TRUE)
                echo " Mintemp : ". ($sum  / $count)."<br/>";
             else
               echo " Maxtemp : ". ($sum  / $count)."<br/>";

	}
	
	
      
}

