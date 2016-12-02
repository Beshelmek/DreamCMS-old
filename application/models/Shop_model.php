<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Shop_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('server_model' => 'server'));
    }

    public function getAllItems($shop){
        $query = $this->db->get('dc_shop_' . strtolower($shop));
        $arr = $query->result_array();
        return $arr;
    }

    public function getSomeItems($shop){
        $query = $this->db->get_where('dc_shop_' . strtolower($shop), array('category' => 'thaumcraft'));
        $arr = $query->result_array();
        return $arr;
    }

    public function getItems($shop){
        $query = $this->db->get_where('dc_shop_' . strtolower($shop), array('price' => '>0'));
        $arr = $query->result_array();
        foreach($arr as $key => $value){
            if($value['damage'] != 0){
                $value['image'] = '/uploads/items/' . $value['type'] . '@' . $value['damage'] . '.PNG';
            }else{
                $value['image'] = '/uploads/items/' . $value['type'] . '.PNG';
            }
            $arr[$key] = $value;
        }
        return $arr;
    }

    public function getItem($id, $shop){
        $query = $this->db->get_where('dc_shop_' . strtolower($shop), array('id' => $id), 1);
        $arr = $query->row_array();
        if($arr['damage'] != 0){
            $arr['image'] = '/uploads/items/' . $arr['type'] . '@' . $arr['damage'] . '.PNG';
        }else{
            $arr['image'] = '/uploads/items/' . $arr['type'] . '.PNG';
        }
        return $arr;
    }

    public function addItem($shop, $itemtype, $damage, $dname, $sname, $price, $dprice, $discount = 0, $category = 'main'){
        $shop = strtolower($shop);
        $data = array(
            'dname' => $dname,
            'type' => $itemtype,
            'damage' => $damage,
            'sname' => $sname,
            'price' => $price,
            'dprice' => $dprice,
            'discount' => $discount,
            'category' => $category
        );
        $this->db->insert('dc_shop_' . $shop, $data);
    }

    public function editItem($shop, $id, $itemtype, $damage, $dname, $sname, $price, $dprice, $discount = 0, $category = 'main'){
        $shop = strtolower($shop);
        $data = array(
            'dname' => $dname,
            'type' => $itemtype,
            'damage' => $damage,
            'sname' => $sname,
            'price' => $price,
            'dprice' => $dprice,
            'discount' => $discount,
            'category' => $category
        );
        $this->db->update('dc_shop_' . $shop, $data, array('id' => $id), 1);
    }
}