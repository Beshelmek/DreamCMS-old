<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cart_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('server_model' => 'server'));
        $this->load->library('query');
    }

    public function getItems($uuid){
        $this->db->select('*');
        $this->db->where('uuid', $this->common->getUUID());
        $this->db->from('dc_cart');
        $this->db->join('dc_shop_items', 'dc_cart.type = dc_shop_items.type AND dc_cart.damage = dc_shop_items.damage');

        $query = $this->db->get();

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

    public function addItem($uuid, $type, $damage, $count){
        $data = array(
            'uuid' => $uuid,
            'type' => $type,
            'damage' => $damage,
            'count' => $count
        );

        $this->db->insert('dc_cart', $data);
    }

    public function getInfo($server, $id){
        $que = $this->db->get_where('dc_shop_' . strtolower($server), array('item_id' => $id), 1);
        $arr = $que->row_array();
        return $arr;
    }

    /*public function give($id){
        $query = $this->db->get_where('dc_cart', array('uuid' => $this->common->getUUID(), 'id' => $id), 1);

        if($query->num_rows() < 1){
            $this->common->showError('У вас нет этого предмета в корзине!');
        }

        $info = $query->row_array();
        $this->load->model('server_model', 'server');

        $Query = new Query();

        try
        {
            $Query->Connect('localhost', $this->server->getAll($info['server'])['port']);
            $players = $Query->GetPlayers();

            if(in_array($this->common->getLogin(), array_values($players))){
                $this->server->sendCmd('give ' . $this->common->getLogin() . ' ' . $info['item_id'] . ' ' . $info['count'], $info['server']);
                $this->db->delete('dc_cart', array('uuid' => $this->common->getUUID(), 'id' => $id));

                return $info;
            }else{
                $this->common->showError('Для получения предмета, вы должны быть на сервере!');
            }
        }
        catch(MinecraftQueryException $e)
        {
            $this->common->showError('Сервер недоступен! Попробуйте позже!');
        }
    }*/

}