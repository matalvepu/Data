<?php 

class DataTransfer extends CI_Model
{

    // CHECKS IF DATA FOR GIVEN DATE AND STATION EXISTS OR NOT

    function getSid($station)
    {
        $q = $this->db->query('Select sid FROM station WHERE name= ?',$station);

         if ($q->num_rows() > 0)
         {
              $row = $q->row();

               
               //echo $station . ' ' .$row->sid;
               return $row->sid;
         }
         else
             false;
    }

    function insertStation($station)
    {
         $q = $this->db->query('INSERT INTO station(name) VALUES(?)',$station);
    }


    function checkDateSid($date,$sid)
    {
         $q = $this->db->query('Select * FROM weatherdata WHERE wdate = ? AND sid = ?',array($date,$sid));

         if ($q->num_rows() > 0)
         {
             return true;
         }
         else
             false;
    }

    function updateMaxTemp($date,$sid,$maxtemp)
    {
        $q = $this->db->query("UPDATE weatherdata  SET maxtemp=? WHERE wdate = ? AND sid=?",array($maxtemp,$date,$sid));
    }
    function updateMinTemp($date,$sid,$mintemp)
    {
        $q = $this->db->query("UPDATE weatherdata  SET mintemp=? WHERE wdate = ? AND sid=?",array($mintemp,$date,$sid));
    }
    function updateRain($date,$sid,$rainmm)
    {
        $q = $this->db->query("UPDATE weatherdata  SET rainfall=? WHERE wdate = ? AND sid=?",array($rainmm,$date,$sid));
    }

    function insertMinTemp($date,$sid,$mintemp)
    {
        $q = $this->db->query("INSERT INTO weatherdata(wdate,sid,mintemp) VALUES(?,?,?)",array($date,$sid,$mintemp));
    }

    function insertMaxTemp($date,$sid,$maxtemp)
    {
        $q = $this->db->query("INSERT INTO weatherdata(wdate,sid,maxtemp) VALUES(?,?,?)",array($date,$sid,$maxtemp));
    }
    
    function insertRain($date,$sid,$rainmm)
    {
        $q = $this->db->query("INSERT INTO weatherdata(wdate,sid,rainfall) VALUES(?,?,?)",array($date,$sid,$rainmm));
    }


    function check()
    {
        //checks stations
        for($month=1;$month<13;$month++)
        {
            for($day=1;$day<32;$day++)
            {
                if(checkdate($month,$day,2010))
                {
                    $date = date("Y-m-d", mktime(0, 0, 0, $month,$day,2010));
                    $q = $this->db->query('Select * FROM raindata WHERE date = ?',$date);

                    if($q->num_rows()!= 35)
                    {
                        echo $date.' '.$q->num_rows();
                        echo '<br/>';
                    }
                }
            }
        }
    }

    function check2()
    {
        $i=0;
        //checks whitch date have no data
        for($month=1;$month<13;$month++)
        {
            for($day=1;$day<32;$day++)
            {
                if(checkdate($month,$day,2010))
                {
                    $date = date("Y-m-d", mktime(0, 0, 0, $month,$day,2010));
                    $q = $this->db->query('Select * FROM raindata WHERE date = ?',$date);

                    if($q->num_rows()== 0)
                    {
                        echo $date.' '.$q->num_rows();
                        echo '<br/>';
                        $i++;
                    }
                }
            }
        }
        echo '<br/> COUNT : '.$i.'<br/>';
    }

   /*
    function insertMinTemp()
    {
       
        $i=0;
        $q = $this->db->query('Select * FROM `table 13`');

         $year = 9999;
         $month = 12;
                        
        foreach($q->result() as $row)
        {
                    $j=1;
                    foreach ($row as $col)
                    {
                        if($j==1)
                            $staion = $col;
                        else if($j==2)
                        {
                            $year = intval(trim($col));
                        }
                             
                        else if($j==3)
                        {
                            $month = intval(trim($col));
                        }
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
                        $j++;
                            //echo 'Station Name '.$col.' ';
                    }

                    echo '<br/>';

                $i++;

        }


        return NULL;
    }
*/
    function insertMain()
    {

        $i=0;

        $pstdata['sid'] = 6;
        
        $pstdata['date'] = $this->input->post('date');

	$pstdata['eid'] = 1;
        $query = 'INSERT INTO data_archive VALUES(?,?,?,?,?,?)';
        


        
        for($year=1980;$year<1995;$year++){
        for($month=1;$month<12;$month++)
        {
            for($date=1;$date<31;$date++)
            {
                if(checkdate($month,$date,$year))
                {
                    $pstdata['mintemp'] = $this->input->post('mintemp');
                    $pstdata['maxtemp'] = $this->input->post('maxtemp');
                    $pstdata['rainfall'] = $this->input->post('rainfall');
                    $q = $this->db->query($query,$pstdata);
                }
            }
        }
        }
        /*
        $q = $this->db->query('Select * FROM `table 16` WHERE `Division` LIKE \'Chittagong\'');//AND year = 2009 AND Month = 12

         $year = 9999;
         $month = 12;
        $staion = 'Chittagong';
        foreach($q->result() as $row)
        {
                    $j=1;
                    foreach ($row as $col)
                    {
                        if($j==1)
                        {
                            //$staion = $col;

                        }

                        else if($j==2)
                        {
                            $year = intval(trim($col));
                        }

                        else if($j==3)
                        {
                            $month = intval(trim($col));
                        }
                        else
                        {

                            if ( checkdate($month,$j-3,$year) )
                            {
                                /*
                                echo $staion;
                                echo ' ';
                                echo date("Y-m-d", mktime(0, 0, 0, $month,$j-2,2010));
                                echo ' ';
                                echo $col;
                                echo '<br/>';

                                */
        /*
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

                                $query = 'INSERT INTO maxtemp VALUES(?,?,?)';
                                $pstdata = array(0 => $staion, $date , $tmp);
                                //print_r($pstdata);

                                $q = $this->db->query($query,$pstdata);
                            }
                            else
                            {

                            }

                        }
                        $j++;
                            //echo 'Station Name '.$col.' ';
                    }

                    echo '<br/>';

                $i++;

        }

*/
        return NULL;
    }
    /*INSERTS FLOAT TYPE*/
    function insertMinTempOriginal()
    {

        $i=0;
        $q = $this->db->query('Select * FROM `table 16` WHERE `Division` LIKE \'Chittagong\'');//AND year = 2009 AND Month = 12

         $year = 9999;
         $month = 12;
        $staion = 'Chittagong';
        foreach($q->result() as $row)
        {
                    $j=1;
                    foreach ($row as $col)
                    {
                        if($j==1)
                        {
                            //$staion = $col;

                        }

                        else if($j==2)
                        {
                            $year = intval(trim($col));
                        }

                        else if($j==3)
                        {
                            $month = intval(trim($col));
                        }
                        else
                        {

                            if ( checkdate($month,$j-3,$year) )
                            {
                                /*
                                echo $staion;
                                echo ' ';
                                echo date("Y-m-d", mktime(0, 0, 0, $month,$j-2,2010));
                                echo ' ';
                                echo $col;
                                echo '<br/>';

                                */
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

                                $query = 'INSERT INTO maxtemp VALUES(?,?,?)';
                                $pstdata = array(0 => $staion, $date , $tmp);
                                //print_r($pstdata);

                                $q = $this->db->query($query,$pstdata);
                            }
                            else
                            {

                            }

                        }
                        $j++;
                            //echo 'Station Name '.$col.' ';
                    }

                    echo '<br/>';

                $i++;

        }


        return NULL;
    }
    function insertDataOther()
    {

  
        $i=0;
        $q = $this->db->query('Select * FROM `table 8`');

        
        if($q->num_rows() > 0)
        {
                        foreach($q->result() as $row)
                        {
                                
                               echo 'PRINTING MAIN : '.$i .' <br/>';

                               if($i!=1)
                               {
                                    $j=1;
                                    foreach ($row as $col)
                                    {
                                        
                                        if($j==1)
                                            $year = intval(trim($col));
                                        else if($j==2)
                                            $month = intval(trim($col));
                                        else if($j==3)
                                            $staion = trim($col);
                                        
                                        else
                                        {
                                            if ( checkdate($month,$j-3,$year) )
                                            {
                                                /*
                                                echo $staion;
                                                echo ' ';
                                                echo date("Y-m-d", mktime(0, 0, 0, $month,$j-3,2010));
                                                echo ' ';
                                                echo $col;
                                                echo '<br/>';

                                                    */

                                                $query = 'INSERT INTO raindata VALUES(?,?,?)';
                                                $pstdata = array(0 => $staion, date("Y-m-d", mktime(0, 0, 0, $month,$j-3,$year)), $col);
                                                $q = $this->db->query($query,$pstdata);
                                            }
                                            else
                                            {
                                                echo 'Invalid Date : '.date("Y-m-d", mktime(0, 0, 0, $month,$j-4,$year)).' : '.$staion.' <br/>';
                                            }

                                        }
                                        $j++;
                                            //echo 'Station Name '.$col.' ';
                                    }

                                    echo '<br/>';
                               }
                                $i++;

                        }




        }
        return NULL;
    }
    /*function insertStation($pstdata)
    {
        //print_r($pstdata);


        $query = 'INSERT INTO stations(name,division,builttime,longitude,latitude,state) VALUES(?,?,?,?,?,?)';
        if($pstdata['working']=='yes')
            $pstdata['working']=1;
        else
            $pstdata['working']=0;

        $q = $this->db->query($query,$pstdata);

        //if($q->num_rows() > 0)
        //{
         //   echo 'inserted';
        //}

        //echo $pstdata['working'];
    }*/

    function a()
    {
        $q= $this->db->query('SELECT station FROM raindata GROUP BY station');
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $row)
            {
                foreach($row as $col)
                {
                    echo $col.'<br/> ';
                }
            }
        }
    }
	function fetchStations()
	{
		
		
		$q = $this->db->query('Select name FROM stations');
		
		
		if($q->num_rows() > 0)
		{
				foreach($q->result() as $row)
				{
					$data[] = $row;
				}
				
				return $data;
			
		}
		return NULL;
	}
	
	function fetchStationID($station)
	{
		
		$query = 'Select sid FROM stations WHERE name = ?';
		
		$q = $this->db->query($query,$station);
		
		
		
		if($q->num_rows() > 0)
		{
			//print_r($q->result());
			
				foreach($q->result() as $row)
				{
					return $row->sid;
				//	$data[] = $row;
					//echo $row;
				
				}
				
				//return $data = ;
			
		}
		return NULL;
	}

}