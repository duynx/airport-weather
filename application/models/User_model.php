<?php

class User_model extends CI_Model
{
    protected $_table = "users";

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function login_user($username, $password)
    {
        $query = $this->db->query("SELECT password FROM " . $this->db->dbprefix . $this->_table . " WHERE username='$username'");
        $result = $query->result();
        if(empty($result)){
            return false;
        }else{
            $hashedPass = $result[0]->password;
            if(verify_password($password,$hashedPass)){
                return true;
            }else{
                return false;
            }
        }
    }
}
