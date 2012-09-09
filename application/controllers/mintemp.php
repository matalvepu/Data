<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mintemp extends CI_Controller
{	
	public function index()
	{
            //echo ''.base_url();

            
            $this->load->model('dataTransfer');
            
            $stations=array("Tangail","Mymensingh","Faridpur","Madaripur","Srimangal","Bogra","Dinajpur","Rangpur","Hatiya","Ctg_patenga","Ctg_Ambagan","Jessore","Mongla","Bhola","Chandpur","Teknaf","Sitakunda","Sandwip","Rangamati");
            foreach($stations as $station)
            {
                //echo "$station<br/>";

                if($sid = $this->dataTransfer->getSid($station))
                {
                    echo "$station -> $sid<br/>";
                }
                else
                {
                    $this->dataTransfer->insertStation($station);
                    $sid = $this->dataTransfer->getSid($station);
                    echo "Created $station -> $sid<br/>";
                    //echo 'not present<br/>';
                }

                $this->populate($station, $sid);
            }
             

            /*
            

            */
	}


        /*
       

         */
        public function populate($station,$sid)
        {
            $i=1;

            $this->load->model('dataTransfer');
            
            set_time_limit(0);
            $q = $this->db->query("Select * FROM newmintemp WHERE Station = \"$station\"");

           

        foreach($q->result() as $row)
        {
                    $j=1;
                    foreach ($row as $col)
                    {
                        /*if($j==1)
                            $staion = $col;*/
                        if($j==3)
                        {
                            $year = intval(trim($col));
                            //echo $year."  j -> ".$j." <br/>";
                            //echo "$year -> ";
                        }
                        else if($j==4)
                        {
                            $month = intval(trim($col));
                            //echo $month." i = $i  ";
                        }


                        else if($j>=5)
                        {
                            $mintemp = floatval(trim($col));


                            
                            //echo " $j-4 ->$mintemp ";

                             if ( checkdate($month,$j-4,$year) )
                             {
                                    
                                $date = date("Y-m-d", mktime(0, 0, 0, $month,$j-5,$year));

                                 if( $mintemp == "")
                                {
                                    //echo "EMPTY \"\" : $date<br/>";
                                }
                                else if($mintemp == NULL)
                                {
                                    //echo "NULL : $date<br/>";
                                }
                                else if($mintemp <0)
                                {
                                    echo "<0 : $date<br/>";
									$mintemp = NULL;
                                }
                                 //set_time_limit(0);
                                else if($this->dataTransfer->checkDateSid($date,$sid))
                                {
                                    //echo "$date -> $mintemp<br/>";
                                    //echo "$date present<br/>";
                                    //$this->dataTransfer->updateRain($date,$sid,$mintemp);
                                    $this->dataTransfer->updateMinTemp($date,$sid,$mintemp);
                                }
                                else
                                {
                                   // $this->dataTransfer->insertRain($date,$sid,$mintemp);
                                    $this->dataTransfer->insertMinTemp($date,$sid,$mintemp);
                                    //echo "$date Not Present<br/>";
                                }
                                //echo "$date -> $mintemp<br/>";
                                    //echo "$date -> $mintemp<br/>";
                            }
                        }

                        

                        /*
                        
                        else
                        {

                            if ( checkdate($month,$j-3,$year) )
                            {

                                echo $staion;
                                echo ' ';
                                echo date("Y-m-d", mktime(0, 0, 0, $month,$j-2,2010));
                                echo ' ';
                                echo $col;
                                echo '<br/>';


                                $date = date("Y-m-d", mktime(0, 0, 0, $month,$j-3,$year));

                                $cs = trim($col);
                                if(empty($cs))
                                {
                                    $tmp = -123;
                                }
                                else
                                {
                                    $tmp = floatval($cs);
                                }

                                $query = 'INSERT INTO mintempv VALUES(?,?,?)';
                                $pstdata = array(0 => $staion, $date , $tmp);
                                //print_r($pstdata);

                                $q = $this->db->query($query,$pstdata);
                            }
                            else
                            {

                                    //echo 'Invalid Date <br/>';
                                    //echo $month;
                                    echo 'Invalid Date : '.$year.' '.$month.' '.($j-3).' : '.$staion.' <br/>';
                            }

                        }

                        */
                        $j++;
                            //echo 'Station Name '.$col.' ';

                    }

                    //echo '<br/>';

                $i++;

            }
        }
}

