<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Refer_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getRefers($login){
        $q = $this->db->get_where('dc_members', array('byurl' => $login));
        return $q->result_array();
    }

}