<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LoadRain extends CI_Controller
{	
	public function index()
	{
            //echo ''.base_url();

            
            $this->load->model('dataTransfer');
            //$this->dataTransfer->insertData();
            //$this->dataTransfer->insertDataOther();
            //$this->dataTransfer->insertMinTempOriginal();
            //$this->dataTransfer->a();
            //$this->dataTransfer->check2();
            //$this->load->view('welcome_view');

            //$this->populate('Mymensingh',13);

           // $this->dataTransfer->updateRain('1970-01-01',1,2.3);

            //
            //
            //$station = 'Tangail';

           
            /*
             *
             * FOR RAINFALL , ADD THE STATION NAME IN ARAY */
             $stations=array("Rajshahi");
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
            $q = $this->db->query("Select * FROM rain WHERE St_name = \"$station\"");

           

        foreach($q->result() as $row)
        {
                    $j=1;
                    foreach ($row as $col)
                    {
                        /*if($j==1)
                            $staion = $col;*/
                        if($j==2)
                        {
                            $year = intval(trim($col));
                            //echo $year."  j -> ".$j." <br/>";
                            //echo "$year -> ";
                        }
                        else if($j==3)
                        {
                            $month = intval(trim($col));
                            //echo $month." i = $i  ";
                        }


                        else if($j>=5)
                        {
                            $rainmm = floatval(trim($col));
                            if($rainmm == -1)
                            {
                                 $date = date("Y-m-d", mktime(0, 0, 0, $month,$j-4,$year));
                                $rainmm =NULL;
                                echo "-1 on $date";
                            }
                            //echo " $j-4 ->$rainmm ";

                            if ( checkdate($month,$j-4,$year) )
                            {
                                $date = date("Y-m-d", mktime(0, 0, 0, $month,$j-4,$year));

                                 //set_time_limit(0);
                                if($this->dataTransfer->checkDateSid($date,$sid))
                                {
                                    //echo "$date present<br/>";
                                    $this->dataTransfer->updateRain($date,$sid,$rainmm);
                                }
                                else
                                {
                                    $this->dataTransfer->insertRain($date,$sid,$rainmm);
                                    //echo "$date Not Present<br/>";
                                }
                                    //echo "$date -> $rainmm<br/>";
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

                    echo '<br/>';

                $i++;

            }
        }
}

