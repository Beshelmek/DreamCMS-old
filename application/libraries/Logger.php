<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logger {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('user_model', 'user');
    }

    public function log($action, $uuid = '[SERVER]', $params = array())
    {
        $params['login'] = $this->CI->user->getAll($uuid)['login'];
        if(strlen($uuid) != 36){
            $uuid = $this->CI->user->getAll($uuid)['uuid'];
        }
        $this->CI->db->insert('dc_logs', array(
            'uuid' => $uuid,
            'action' => $action,
            'time' => time(),
            'params' => json_encode($params)
        ));
    }

    public function getUserLogs($uuid){
        $q = $this->CI->db->get('dc_logs', array('uuid' => $uuid), 50);
        return $q->row_array();
    }

    public function getTimedLogs($user){
        $uuid = $this->CI->user->getAll($user)['uuid'];
        $this->CI->db->order_by('time', 'DESC');

        $q = $this->CI->db->get_where('dc_logs', array('uuid' => $uuid));
        $rarray = array();
        foreach($q->result_array() as $action){
            $date = date('d.m.Y', $action['time']);
            $action = $this->handleAction($action);
            if(isset($action) && !empty($action)){
                $rarray[$date][] = $action;
            }
        }
        return $rarray;
    }

    public function handleAction($action){
        $rarr = array();
        $rarr['time'] = date('H:i:s', $action['time']);
        if($action['action'] == 'auth_login'){
            $rarr['icon'] = 'fa-user bg-blue';
            $rarr['title'] = 'Авторизация по логину';
            $rarr['body'] = print_r(json_decode($action['params'], true), true);
            $rarr['footer'] = '';
        }elseif($action['action'] == 'unitpay_add'){
            $rarr['icon'] = 'fa-usd bg-red';
            $rarr['title'] = 'Пополнение счета';
            $rarr['body'] = print_r(json_decode($action['params'], true), true);
            $rarr['footer'] = '';
        }elseif($action['action'] == 'shop_buyitem'){
            $rarr['icon'] = 'fa-cart-plus bg-yellow';
            $rarr['title'] = 'Покупка предмета';
            $rarr['body'] = print_r(json_decode($action['params'], true), true);
            $rarr['footer'] = '';
        }elseif($action['action'] == 'auth_vk'){
            $rarr['icon'] = 'fa-vk bg-blue';
            $rarr['title'] = 'Авторизация через ВКонтакте';
            $rarr['body'] = print_r(json_decode($action['params'], true), true);
            $rarr['footer'] = '';
        }elseif($action['action'] == 'cart_give'){
            $rarr['icon'] = 'fa-cart-arrow-down bg-yellow';
            $rarr['title'] = 'Выдача предмета';
            $rarr['body'] = print_r(json_decode($action['params'], true), true);
            $rarr['footer'] = '';
        }else{
            $rarr['icon'] = 'fa-question-circle bg-red';
            $rarr['title'] = 'Не известное действие: ' . $action['action'];
            $rarr['body'] = print_r(json_decode($action['params'], true), true);
            $rarr['footer'] = '';
        }

        return $rarr;
    }
}