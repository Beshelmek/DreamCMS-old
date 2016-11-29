<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Top_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('server_model' => 'server'));
        $this->load->model(array('user_model' => 'user'));
    }

    public function golos_arr()
    {
        $this->db->limit(30);
        $this->db->order_by('count', 'DESC');
        $query = $this->db->get('dc_golos');
        $arr = $query->result_array();
        foreach($arr as $key => $value){
            $value['login'] = $this->user->getLogin($value['uuid']);
            if($value['last_topcraft'] > $value['last_mctop']){
                $value['last_time'] = date("d-m-Y H:i:s", $value['last_topcraft']);
            }else{
                $value['last_time'] = date("d-m-Y H:i:s", $value['last_mctop']);
            }
            $arr[$key] = $value;
        }
        return $arr;
    }

    public function online_arr()
    {
        $this->db->limit(30);
        $this->db->order_by('playtime', 'DESC');
        $query = $this->db->get('playTime');
        $arr = $query->result_array();
        foreach($arr as $key => $value){
            $value['playtime'] = round($value['playtime'] / 60);
            $arr[$key] = $value;
        }
        return $arr;
    }

    public function money_arr()
    {
        $this->db->limit(30);
        $this->db->order_by('money', 'DESC');
        $query = $this->db->get('dc_members');
        $arr = $query->result_array();
        return $arr;
    }
}