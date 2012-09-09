<?php 

class WeatherDataTemp extends CI_Model
{
    

    function avgMinMonthRangeYear($sid,$smonth,$emonth,$year)
    {

        if($smonth<$emonth)
            $query ="SELECT AVG(mintemp) AS a FROM weatherdata WHERE sid = $sid AND YEAR(wdate) =$year  AND MONTH(wdate) >= $smonth AND MONTH(wdate) <= $emonth";
        else
            $query = "SELECT AVG(mintemp) AS a FROM weatherdata WHERE sid = $sid AND YEAR(wdate) =$year  AND (MONTH(wdate) >= $smonth OR MONTH(wdate) <= $emonth)";

        //echo $query."<br/>";
         $q =  $this->db->query($query);
        return $q->row()->a;
    }
    function avgMaxMonthRangeYear($sid,$smonth,$emonth,$year)
    {

        if($smonth<$emonth)
            $query ="SELECT AVG(maxtemp) AS a FROM weatherdata WHERE sid = $sid AND YEAR(wdate) =$year  AND MONTH(wdate) >= $smonth AND MONTH(wdate) <= $emonth";
        else
            $query = "SELECT AVG(maxtemp) AS a FROM weatherdata WHERE sid = $sid AND YEAR(wdate) =$year  AND (MONTH(wdate) >= $smonth OR MONTH(wdate) <= $emonth)";

       // echo $query."<br/>";
         $q =  $this->db->query($query);
        return $q->row()->a;
    }

    
    function avgMinTempBetwenYear($sid,$syear,$eyear,$month)
    {
        $q = $this->db->query("SELECT AVG(mintemp) AS a FROM weatherdata WHERE sid = ? AND YEAR(wdate) >=? AND YEAR(wdate) <= ? AND MONTH(wdate) = ?",array($sid,$syear,$eyear,$month));
        return $q->row()->a;
    }

    function avgMaxTempBetwenYear($sid,$syear,$eyear,$month)
    {
        $q = $this->db->query("SELECT AVG(maxtemp) AS a FROM weatherdata WHERE sid = ? AND YEAR(wdate) >=? AND YEAR(wdate) <= ? AND MONTH(wdate) = ?",array($sid,$syear,$eyear,$month));
        return $q->row()->a;
    }

    function avgMinTempMonthYear($sid,$month,$year)
    {
        $q = $this->db->query("SELECT AVG( mintemp ) AS a FROM weatherdata WHERE sid = ? AND MONTH( wdate ) = ? AND YEAR( wdate ) = ?",array($sid,$month,$year));
        return $q->row()->a;
    }
	    function avgMaxTempMonthYear($sid,$month,$year)
    {
        $q = $this->db->query("SELECT AVG( maxtemp ) AS a FROM weatherdata WHERE sid = ? AND MONTH( wdate ) = ? AND YEAR( wdate ) = ?",array($sid,$month,$year));
        return $q->row()->a;
    }

    function minimumMinTempMonthYear($sid,$month,$year)
    {
        $q = $this->db->query("SELECT MIN( mintemp ) AS a FROM weatherdata WHERE sid = ? AND MONTH( wdate ) = ? AND YEAR( wdate ) = ?",array($sid,$month,$year));
        return $q->row()->a;
    }
    function maximumMaxTempMonthYear($sid,$month,$year)
    {
        $q = $this->db->query("SELECT MAX( maxtemp ) AS a FROM weatherdata WHERE sid = ? AND MONTH( wdate ) = ? AND YEAR( wdate ) = ?",array($sid,$month,$year));
        return $q->row()->a;
    }

    function avgMinTempBetweenTwoDate($sid,$syear,$smonth,$sdate,$eyear,$emonth,$edate)
    {
        $q = $this->db->query("SELECT AVG(mintemp) AS a FROM weatherdata WHERE sid = ? AND wdate >=  '?-?-?' AND wdate <=  '?-?-?'",array($sid,$syear,$smonth,$sdate,$eyear,$emonth,$edate));
        return $q->row()->a;
    }

    function avgMaxTempBetweenTwoDate($sid,$syear,$smonth,$sdate,$eyear,$emonth,$edate)
    {
         $q = $this->db->query("SELECT AVG(maxtemp) AS a FROM weatherdata WHERE sid = ? AND wdate >=  '?-?-?' AND wdate <=  '?-?-?'",array($sid,$syear,$smonth,$sdate,$eyear,$emonth,$edate));
        return $q->row()->a;
    }
}