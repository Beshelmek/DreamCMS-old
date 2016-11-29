<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Shop_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('server_model' => 'server'));
    }

    public function getAllItems(){
        $query = $this->db->get('dc_shop_items');
        $arr = $query->result_array();

        return $arr;
    }

    public function getSomeItems(){
        $query = $this->db->get_where('dc_shop_items', array('category' => 'thaumcraft'));
        $arr = $query->result_array();

        return $arr;
    }

    public function getItems(){
        $query = $this->db->query("SELECT * FROM dc_shop_items WHERE price > 0");
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

    public function getItem($id){
        $query = $this->db->get_where('dc_shop_items', array('id' => $id), 1);
        $arr = $query->row_array();
        if($arr['damage'] != 0){
            $arr['image'] = '/uploads/items/' . $arr['type'] . '@' . $arr['damage'] . '.PNG';
        }else{
            $arr['image'] = '/uploads/items/' . $arr['type'] . '.PNG';
        }
        return $arr;
    }

    public function addItem($server, $itemid, $name, $price, $dprice, $image, $active = 1){
        $server = strtolower($server);
        $data = array(
            'item_id' => $itemid,
            'name' => $name,
            'price' => $price,
            'dprice' => $dprice,
            'image' => $image,
            'active' => $active
        );
        $this->db->insert('dc_shop_' . $server, $data);
    }

    public function editItem($server, $id, $itemid, $name, $price, $dprice, $image, $active = 1){
        $server = strtolower($server);
        $data = array(
            'item_id' => $itemid,
            'name' => $name,
            'price' => $price,
            'dprice' => $dprice,
            'image' => $image,
            'active' => $active
        );
        $this->db->update('dc_shop_' . $server, $data, array('id' => $id), 1);
    }
}