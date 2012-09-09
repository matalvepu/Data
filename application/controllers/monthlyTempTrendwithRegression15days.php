<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MonthlyTempTrendwithRegression15days extends CI_Controller
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
            $which=1;
            $month=2;
            $syear=1953;
            $eyear = 2009;

            $this->load->model('station');
            $stationName= $this->station->getName($sid);
            $ltl = ($which==1)?"1st":"2nd";
            $title = "Avg Min and Max temp on $ltl 15days in month #$month from $syear to $eyear in $stationName";
            //echo $title;
            $yAxistitle = "Avg Min and Max temp ( ° Celsius)";
             //$this->load->model('weatherDataTemp');
             //echo 

            
             $data['array'] =  $this->avgMinMaxTempWeekly($sid,$which,$month,$syear,$eyear);
             $data['title'] = mysql_real_escape_string($title);
             $data['yAxistitle'] = mysql_real_escape_string($yAxistitle);
                //echo "var javascript_array = ". $js_array . ";\n";
            $this->load->view('lineChart',$data);
           // echo $this->maxTemp(1, 1, 1953);
        }
    public function get_m($x_bar , $y_bar , $xy_bar , $x_sqr_bar )
    {

        $lob = ($x_bar * $y_bar) - $xy_bar ;
        $hor = ($x_bar * $x_bar) - $x_sqr_bar;

        return $lob/$hor;

    }

    public function get_b($x_bar , $y_bar , $m)
    {
        return ($y_bar - $m * $x_bar);
    }
       
        public function avgMinMaxTempWeekly($sid,$which,$month,$syear,$eyear)
        {
            $sdate = ($which==1)?1:16;
            $edate = ($which==1)?15:30;

            $count1=$count2=0;
            $x1=0;
            $x2=0;
            $y1=0;
            $y2=0;
            $xy1=0;
            $xy2=0;
            $x_sqr_1=0;
            $x_sqr_2=0;

            $this->load->model('weatherDataTemp');

            $phpArray[] = array("Year","Avg Mintemp (° Celsius)","Avg Min Temp Regression Line","Avg Maxtemp(° Celsius)","Avg Max Temp Regression Line");
            
            for($year = $syear ; $year <= $eyear ; $year++)
            {
                
                 if($which==2)
                $edate=  cal_days_in_month(CAL_GREGORIAN, $month  , $year);
                 
                $avgMin = $this->weatherDataTemp->avgMinTempBetweenTwoDate($sid,$year,$month,$sdate,$year,$month,$edate);

                echo $avgMin." ";
                if($avgMin!=NULL)
                {
                   $x1 += $year;
                   $y1 += $avgMin;
                   $xy1 += ($x1*$y1) ;
                   $x_sqr_1 += ($x1*$x1);

                   $x1_array[$count1]=$year;
                   $y1_array[$count1]=$avgMin;
                   $count1++;
  
                }
                $avgMax = $this->weatherDataTemp->avgMaxTempBetweenTwoDate($sid,$year,$month,$sdate,$year,$month,$edate);
                if($avgMax!=NULL)
                {
                    $x2 += $year;
                   $y2 += $avgMax;
                   $xy2 += ($x2*$y2) ;
                   $x_sqr_2 += ($x2*$x2);
                   $y2_array[$count2]=$avgMax;
                   $count2++;

                   
                }

                //$phpArray[] = array("".$year,$avgMin,$avgMax);
            }

            $x_bar = $x1 /$count1;
            $y1_bar = $y1 /$count1;
            $xy1_bar = $xy1 / $count1;
            $x_sqr_bar = $x_sqr_1/$count1;

            $y2_bar = $y2 / $count1;
            
            $xy2_bar = $xy2/ $count1;
            

            $m1 = $this->get_m($x_bar, $y1_bar, $xy1_bar, $x_sqr_bar);
            $b1 = $this->get_b($x_bar, $y1_bar, $m1);

            $m2 = $this->get_m($x_bar, $y2_bar, $xy2_bar, $x_sqr_bar);
            $b2 = $this->get_b($x_bar, $y2_bar, $m2);

            echo "EQUATION FROM MIN : y = $m1 x + $b1 <br/>EQUATION FROM MAX : y = $m2 x + $b2 <br/>";
            $SE_y_bar_1 = 0;
            $SE_y_bar_2 = 0;


            $SE_y_1 = 0;
            $SE_y_2 = 0;
            for($x = 0;$x<$count1;$x++)
            {
                $SE_y_bar_1 += ($y1_array[$x] - $y1_bar)*($y1_array[$x] - $y1_bar);
                $SE_y_bar_2 += ($y2_array[$x] - $y2_bar)*($y2_array[$x] - $y2_bar);

                $y1_regLine = ($m1*$x1_array[$x] + $b1);
                $y2_regLine = ($m2*$x1_array[$x] + $b2);

                $SE_y_1  += ($y1_array[$x] - $y1_regLine)*($y1_array[$x] - $y1_regLine);
                $SE_y_2  += ($y2_array[$x] - $y2_regLine)*($y2_array[$x] - $y2_regLine);

                
                //$y1_array[$x],
                
                
                $phpArray[]=array("".$x1_array[$x],$y1_array[$x],$y1_regLine,$y2_array[$x],$y2_regLine);
            }

            $r_sqr_1 = (1-($SE_y_1/ $SE_y_bar_1))*100;
            $r_sqr_2 = (1-($SE_y_2/ $SE_y_bar_2))*100;

            echo "R SQUARE FOR MIN $r_sqr_1 AND MAX $r_sqr_2<br/>";
                $js_array = json_encode($phpArray,JSON_NUMERIC_CHECK);

                return $js_array;
	}
	
	
      
}

