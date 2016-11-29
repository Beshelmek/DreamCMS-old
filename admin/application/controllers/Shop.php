<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('shop_model', 'shop');
        $this->load->model('server_model', 'server');
    }

    public function index()
    {
        $this->tpl->compile('shop/list', array('servers' => $this->server->getAll()), 'Магазин блоков');
    }

    public function server($server){
        $server = strtolower($server);
        $this->tpl->compile('shop/server', $this->shop->getItems($server), 'Магазин блоков');
    }

    public function items(){
        $this->tpl->compile('shop/items', array('items' => $this->shop->getSomeItems()), 'Магазин блоков');
    }

    public function item($server, $id){
        $server = strtolower($server);
        $item = $this->shop->getItem($server, $id);
        $this->tpl->compile('shop/item', array('item' => $item), 'Магазин блоков');
    }

    public function edit_item(){
        $id = $this->input->get_post('id');
        $type = $this->input->get_post('type');
        $value = $this->input->get_post('value');

        $q = $this->db->update('dc_shop_items', array($type => $value), array(
            'id' => $id
        ), 1);

        if($q) $this->common->showOK("Изменено [$id] " . $type . " " . $value);
        $this->common->showError("Ошибка");
    }

    public function edit($server, $id){
        $this->shop->editItem($server, $id, $this->input->post('item_id'), $this->input->post('name'), $this->input->post('price'), $this->input->post('dprice'), $this->input->post('image'));
        $this->tpl->compile('success', array('msg' => 'Предмет изменен!', 'url' => 'shop/server/'.$server), 'Изменение предмета');
    }

    public function add($server){
        $this->tpl->compile('shop/add', array('server' => $server), 'Магазин блоков');
    }

    public function create($server){
        $this->shop->addItem(strtolower($server), $this->input->post('item_id'), $this->input->post('name'), $this->input->post('price'), $this->input->post('dprice'), $this->input->post('image'));
        $this->tpl->compile('success', array('msg' => 'Предмет добавлен!', 'url' => 'shop/add/'.$server), 'Создание предмета');
    }
}
