<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cluster5 extends CI_Controller
{	
	public function index()
	{

            $syear=1970;
            $eyear = 2009;
            $startMonth =1;


            $stationName= "Sylhet";
          

            $title = "Cluster distribution from $syear to $eyear of months ($startMonth - ".($startMonth+3).") in $stationName";
            $yAxistitle = "Cluster";

             
             $data['array'] = $this->clusterDistribution4months($stationName,$syear,$eyear,$startMonth);
             $data['title'] = mysql_real_escape_string($title);
             $data['yAxistitle'] = mysql_real_escape_string($yAxistitle);
             $this->load->view('lineChart',$data);
           
           

        }
       
        public function clusterDistribution4months($stationName,$syear,$eyear,$startMonth)
        {
           
            $this->load->model('cluster5Model');

            $array[] = 'Year';
            for($month=$startMonth;$month<$startMonth+4;$month++)
                $array[]=$month;

            $php_array[]=$array;

            
            
                //echo "Month : $month : <br/>";
            for($year = $syear ; $year <= $eyear ; $year++)
            {
                if($stationName=='Dhaka' && $year==1974)continue;
                if($stationName=='Khulna' && $year==1975)continue;
                if($stationName=='Rajshahi' && $year==1970)continue;
                if($stationName=='Sylhet' && $year==1973)continue;
                unset ($lilArray);
                $lilArray[] = $year;
                for($month=$startMonth;$month<$startMonth+4;$month++)
                {
                    $cluster = $this->cluster5Model->whichCluster($stationName,$month,$year);
                    $lilArray[] = $cluster;
                   // echo " $year -> $cluster <br/>";

                    //$phpArray[] = array("".$year,$avgMin,$avgMax);
                }
                $php_array[] = $lilArray;
            }
            return json_encode($php_array,JSON_NUMERIC_CHECK);;
	}
}

