<?php

class Airport_model extends CI_Model
{
    protected $_table = "airport";

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function listAirport()
    {
        $this->db->select();
        return $this->db->get($this->_table)->result_array();
    }

    public function insertAirport($data_insert)
    {
        $this->db->insert($this->_table, $data_insert);
    }

    public function searchAirportMetaphone($query)
    {
        $sql = "SELECT * FROM `" . $this->db->dbprefix . $this->_table . "` WHERE title_metaphone LIKE CONCAT('%',dm('$query'),'%')";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    public function searchAirportSoundex($query)
    {
        $sql = "SELECT * FROM `" . $this->db->dbprefix . $this->_table . "` WHERE title_soundex LIKE CONCAT('%',SOUNDEX('$query'),'%')";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    public function searchAirportLevenshtein($query)
    {
        $lvArray = getLevenshtein($query);
        $sql = "SELECT * FROM `" . $this->db->dbprefix . $this->_table . "` WHERE";
        foreach ($lvArray as $regex) {
            $sql .= " title LIKE '%" . $regex . "%' OR ";
        }
        $sql = rtrim($sql, ' OR');
        $result = $this->db->query($sql)->result();
        return $result;
    }

}
