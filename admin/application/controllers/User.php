<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model', 'user');
        $this->load->model('server_model', 'server');
    }

    public function index()
    {
        $this->tpl->compile('user/index', array(), 'Поиск пользователей');
    }

    public function edit($user = ''){
        $info = $this->user->getAll($user);
        if(isset($info) && !empty($info) && count($info) > 1){
            $this->tpl->compile('user/edit', array('info' => $info, 'logs' => $this->logger->getTimedLogs($user), 'servers' => $this->server->getList()), 'Редактирование пользователя');
        }else{
            $this->tpl->compile('success', array('msg' => 'Пользователь не найден!', 'url' => 'user'), 'Ошибка');
        }
    }

    public function block()
    {
        $uuid = $this->input->post('uuid');
        $this->common->showOK("Пользователь [$uuid] забанен!");
    }

    public function cases(){
        $id = $this->input->post('id');
        $count = $this->input->post('count');
        $this->common->showOK("Вы успешно выдали $count кейсов!");
    }

    public function giveitem(){
        $uuid = $this->input->post('uuid');
        $id = $this->input->post('id');
        $count = $this->input->post('count');
        $damage = 0;

        if(substr_count($id, ':') > 0){
            $info = split(':', $id);
            $id = $info[0];
            $damage = intval($info[1]);
        }

        $this->cart->addItem($uuid, $id, $damage, $count);
    }

    public function givegroup(){
        $uuid = $this->input->post('uuid');
        $id = $this->input->post('id');
        $count = $this->input->post('count');

        if($count >= 0){
            if($count != 0)
                $count = time() + (60 * 60 * 24 * $count);
            $this->groups->addUserGroupDirect($uuid, $id, $count);
            $this->common->showOK('Вы успешно выдали привилегию!');
        }else{
            $this->groups->clearUserGroups($uuid);
            $this->common->showOK('Все привилегии игрока сняты!');
        }
    }

    public function gadisable(){
        $uuid = $this->input->post('uuid');
        $this->db->update('dc_members', array(
            'ga_secret' => null
        ), array(
            'uuid' => $uuid
        ), 1);

        $this->common->showOK('Двухэтапная авторизация отключена!');
    }

    public function verify(){
        $uuid = $this->input->post('uuid');
        $this->db->update('dc_members', array(
            'verified' => 1
        ), array(
            'uuid' => $uuid
        ), 1);

        $this->common->showOK('Игрок верифицированн!');
    }

    public function clearkits(){
        $uuid = $this->input->post('uuid');
        $this->db->delete('kit_time', array(
            'uuid' => $uuid
        ));

        $this->common->showOK('Игрок вновь может получить все киты!');
    }

    public function server($server, $user){
        require APPPATH . 'third_party/NBT.php';
        $user = $this->user->getAll($user);
        $uuid = $user['uuid'];
        $NBT = new NBT();
        $NBT->loadFile('/root/servers/'.$server.'/world/playerdata/' . $uuid . '.dat');

        $needarr = array('Dimension', 'Pos', 'Inventory');
        $rarr = array();

        foreach($NBT->root[0]['value'] as $tag){
            if(in_array($tag['name'], $needarr)){
                if($tag['type'] == 3){
                    $rarr[$tag['name']] = $tag['value'];
                }else if($tag['type'] == 9){
                    if($tag['name'] == 'Inventory'){
                        $rarr[$tag['name']] = $this->parseInventory($tag['value']['value']);
                    }else{
                        $rarr[$tag['name']] = $tag['value']['value'];
                    }
                }
            }
        }
        $this->tpl->compile('user/server', array('info' => $rarr, 'server' => $server), 'Редактирование пользователя');
    }

    protected function parseInventory($invarr){
        $rarr = array();
        foreach($invarr as $key=>$item){
            foreach($item as $tag){
                $rarr[$key][$tag['name']] = $tag['value'];
            }
        }
        return $rarr;
    }

}
