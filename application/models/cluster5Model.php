<?php 

class Cluster5Model extends CI_Model
{
    function whichCluster($stationName,$month,$year)
    {
        $q = $this->db->query("SELECT cluster AS a FROM cluster5 WHERE station = ? AND month = ? AND year = ?",array($stationName,$month,$year));
        if($q->row())
        return $q->row()->a;
    return -1;
    }

    function differentClusters($stationName,$year)
    {
        $q = $this->db->query("SELECT COUNT(A) AS a FROM (SELECT DISTINCT(cluster) AS A FROM cluster5 where station = ? AND year = ?) B",array($stationName,$year));
        if($q->row())
        return $q->row()->a;
        return 0;
    }

     function clusterCount($stationName,$year,$cluster)
    {
        $q = $this->db->query("SELECT COUNT(*) AS a FROM cluster5 WHERE station = ? AND year=? AND cluster = ?",array($stationName,$year,$cluster));
        if($q->row())
        return $q->row()->a;
        return 0;
    }

    
}