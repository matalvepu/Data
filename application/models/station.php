<?php 

class Station extends CI_Model
{

    public function getName($sid)
    {
            $q = $this->db->query("SELECT name FROM station WHERE sid = ?  ",$sid);
            return $q->row()->name;
    }
}