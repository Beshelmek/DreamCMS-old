<?php
class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAll($user)
    {
        if(strlen($user) == 36){
            $query = $this->db->get_where('dc_members', array('uuid' => $user), 1);
        }else{
            $query = $this->db->get_where('dc_members', array('login' => $user), 1);
        }
        return $query->row_array();
    }

    public function getLogin($uuid)
    {
        $query = $this->db->get_where('dc_members', array('uuid' => $uuid), 1);

        if(!empty($query->row_array())){
            return $query->row_array()['login'];
        }

        return 'ERR_UUID_NOT_PRESENT';
    }

    public function getUUID($login)
    {
        if(strlen($login) == 36){
            return $login;
        }

        $query = $this->db->get_where('dc_members', array('login' => $login), 1);

        if(!empty($query->row_array())){
            return $query->row_array()['uuid'];
        }

        return '00000000-0000-0000-0000-000000000000';
    }
}