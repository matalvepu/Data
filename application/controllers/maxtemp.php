<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maxtemp extends CI_Controller
{	
	public function index()
	{
            $this->load->model('dataTransfer');
            
             // FOR MAXTEMP , ADD THE STATION NAME IN ARAY
			 /*
             $stations=array("Tangail","Mymensingh","Faridpur","Madaripur","Srimangal","Bogra","Dinajpur","Rangpur","Hatiya","Ctg_patenga","Ctg_Ambagan","Jessore","Mongla","Bhola","Chandpur","Teknaf","Sitakunda","Sandwip","Rangamati");
			 */
			 
			 $stations=array("Teknaf");
            foreach($stations as $station)
            {
                
                if($sid = $this->dataTransfer->getSid($station))
                {
                    echo "$station already exists , sid -> $sid<br/>";
                }
                else
                {
                    $this->dataTransfer->insertStation($station);
                    $sid = $this->dataTransfer->getSid($station);
                    echo "Created $station -> sid: $sid<br/>";
                    //echo 'not present<br/>';
                }

                $this->populate($station, $sid);
            }
             
	}


        public function populate($station,$sid)
        {
            $i=1;
            
            set_time_limit(0);
            $q = $this->db->query("Select * FROM newmaxtemp WHERE Station = \"$station\"");

        foreach($q->result() as $row)
        {
                    $j=1;
                    foreach ($row as $col)
                    {

                        if($j==3)
                        {
                            $year = intval(trim($col));
                        }
                        else if($j==4)
                        {
                            $month = intval(trim($col));
                        }
                        else if($j>=5)
                        {
                            $newmaxtemp = floatval(trim($col));

                             if ( checkdate($month,$j-4,$year) )
                             {
                                    
                                $date = date("Y-m-d", mktime(0, 0, 0, $month,$j-4,$year));

                                 if( $newmaxtemp == "")
                                {
                                    //echo "EMPTY \"\" : $date<br/>";
                                }
                                else if($newmaxtemp == NULL)
                                {
                                    //echo "NULL : $date<br/>";
                                }
                                else if($newmaxtemp <0)
                                {
                                    echo "temp less than 0 : $date<br/>";
									$newmaxtemp = NULL;
                                }
                                else if($this->dataTransfer->checkDateSid($date,$sid))
                                {
                                    $this->dataTransfer->updateMaxTemp($date,$sid,$newmaxtemp);
                                }
                                else
                                {
                                    $this->dataTransfer->insertMaxTemp($date,$sid,$newmaxtemp);
                                }                                
								}
                        }

                        $j++;
                    }
                $i++;
            }
        }
}