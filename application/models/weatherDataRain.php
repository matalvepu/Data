<?php 

class WeatherDataRain extends CI_Model
{

    public function totalRainMonthYear($sid,$month,$year)
    {
            $q = $this->db->query("SELECT SUM(rainfall) AS a FROM weatherdata WHERE sid = ? AND MONTH(wdate) = ? AND YEAR(wdate) = ? ",array($sid,$month,$year));
            return $q->row()->a;
    }
    public function totalRainInYear($sid,$year)
        {
            $q = $this->db->query("SELECT SUM(rainfall) AS a FROM weatherdata WHERE sid = ? AND year(wdate)= ? ",array($sid,$year));
	    return $q->row()->a;
        }


        public function countUnavailableData($sid,$year)
        {
            $q = $this->db->query("SELECT COUNT(*) AS a FROM weatherdata WHERE sid = ? AND year(wdate)= ?  AND rainfall IS NULL",array($sid,$year));
	    return $q->row()->a;
        }
       
}