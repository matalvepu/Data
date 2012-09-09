<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cluster1 extends CI_Controller
{	
	public function index()
	{

            $syear=1970;
            $eyear = 2009;



            $stationName= "Dhaka";
            $cluster=2;

            $title = "cluster distribution from $syear to $eyear of months (sep-dec) in $stationName";
            //$title = "Change of appearance of cluster $cluster from $syear to $eyear in $stationName";
            //echo $title;
            $yAxistitle = "Cluster #";
             //$this->load->model('weatherDataTemp');
             //echo

             $month = 5;
             
             $data['array'] = $this->avgMinMaxTempWeekly($stationName,$syear,$eyear);
             //$data['array'] = $this->clusterMonthwise($stationName,$syear,$eyear,$month);
			 //$data['array'] = $this->differentClusters($stationName,$syear,$eyear);
             //$data['array'] = $this->clusterCount($stationName,$syear,$eyear,$cluster);
             
             $data['title'] = mysql_real_escape_string($title);
             $data['yAxistitle'] = mysql_real_escape_string($yAxistitle);
                //echo "var javascript_array = ". $js_array . ";\n";
           $this->load->view('lineChart',$data);
           
           

        }
         public function clusterCount($stationName,$syear,$eyear,$cluster)
        {

            $this->load->model('cluster3');

            $php_array[]=array('year',"# of cluster $cluster");

                //echo "Month : $month : <br/>";
            for($year = $syear ; $year <= $eyear ; $year++)
            {
                if($stationName=='Dhaka' && $year==1974)continue;

                unset ($lilArray);
                $lilArray[] = $year;

                    $count = $this->cluster3->clusterCount($stationName,$year,$cluster);
                    $lilArray[] = $count;
                   // echo " $year -> $cluster <br/>";

                    //$phpArray[] = array("".$year,$avgMin,$avgMax);

                $php_array[] = $lilArray;
            }
            return json_encode($php_array,JSON_NUMERIC_CHECK);;
	}
         public function differentClusters($stationName,$syear,$eyear)
        {

            $this->load->model('cluster3');




            $php_array[]=array('year','cluster count');



                //echo "Month : $month : <br/>";
            for($year = $syear ; $year <= $eyear ; $year++)
            {
                if($stationName=='Dhaka' && $year==1974)continue;

                unset ($lilArray);
                $lilArray[] = $year;

                    $cluster = $this->cluster3->clusterCount($stationName,$year);
                    $lilArray[] = $cluster;
                   // echo " $year -> $cluster <br/>";

                    //$phpArray[] = array("".$year,$avgMin,$avgMax);

                $php_array[] = $lilArray;
            }
            return json_encode($php_array,JSON_NUMERIC_CHECK);;
	}
        public function clusterMonthwise($stationName,$syear,$eyear,$month)
        {

            $this->load->model('cluster3');
            $php_array[]=array('year',$month);



                //echo "Month : $month : <br/>";
            for($year = $syear ; $year <= $eyear ; $year++)
            {
                if($stationName=='Dhaka' && $year==1974)continue;

                unset ($lilArray);
                $lilArray[] = $year;
               
                    $cluster = $this->cluster3->whichCluster($stationName,$month,$year);
                    $lilArray[] = $cluster;
                   // echo " $year -> $cluster <br/>";

                    //$phpArray[] = array("".$year,$avgMin,$avgMax);
                
                $php_array[] = $lilArray;
            }
            return json_encode($php_array,JSON_NUMERIC_CHECK);;
	}
        public function avgMinMaxTempWeekly($stationName,$syear,$eyear)
        {
           
            $this->load->model('cluster3');

            $array[] = 'Year';
            for($month=9;$month<=12;$month++)
                $array[]=$month;

            $php_array[]=$array;

            
            
                //echo "Month : $month : <br/>";
            for($year = $syear ; $year <= $eyear ; $year++)
            {
                if($stationName=='Dhaka' && $year==1974)continue;
         
                unset ($lilArray);
                $lilArray[] = $year;
                for($month=9;$month<=12;$month++)
                {
                    $cluster = $this->cluster3->whichCluster($stationName,$month,$year);
                    $lilArray[] = $cluster;
                   // echo " $year -> $cluster <br/>";

                    //$phpArray[] = array("".$year,$avgMin,$avgMax);
                }
                $php_array[] = $lilArray;
            }
            return json_encode($php_array,JSON_NUMERIC_CHECK);;
	}
}

