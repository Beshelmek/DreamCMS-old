<?php
class Economy_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function setBalance($uuid, $money, $realmoney){
        $this->db->where('uuid', $uuid);
        if($this->db->update('dc_members', array('money'=>$money, 'realmoney'=>$realmoney))){
            return TRUE;
        }
        return FALSE;
    }

    public function spendMoney($uuid, $count){
        if($count <= 0) return false;
        $query = $this->db->get_where('dc_members', array('uuid' => $uuid));
        $row = $query->row_array();
        if (isset($row)) {
            $balance = $row['money'];
            if($balance >= $count){
                $this->db->where('uuid', $uuid);
                $this->db->update('dc_members', array('money' => $balance - $count));
                return TRUE;
            }
        }
        return FALSE;
    }

    public function spendRealmoney($uuid, $count){
        if($count <= 0) return false;
        $query = $this->db->get_where('dc_members', array('uuid' => $uuid));
        $row = $query->row_array();
        if (isset($row)) {
            $balance = $row['realmoney'];
            if($balance >= $count){
                $this->db->where('uuid', $uuid);
                $this->db->update('dc_members', array('realmoney' => $balance - $count));
                return TRUE;
            }
        }
        return FALSE;
    }

    public function addMoney($uuid, $count){
        $query = $this->db->get_where('dc_members', array('uuid' => $uuid));
        $row = $query->row_array();
        if (isset($row)) {
            $balance = $row['money'];
            $this->db->where('uuid', $uuid);
            $this->db->update('dc_members', array('money' => $balance + $count));
            return TRUE;
        }
        return FALSE;
    }

    public function addRealMoney($uuid, $count){
        $query = $this->db->get_where('dc_members', array('uuid' => $uuid));
        $row = $query->row_array();
        if (isset($row)) {
            $balance = $row['realmoney'];
            $this->db->where('uuid', $uuid);
            $this->db->update('dc_members', array('realmoney' => $balance + $count));
            return TRUE;
        }
        return FALSE;
    }

}