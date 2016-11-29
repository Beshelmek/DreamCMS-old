<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends DCMS_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('server_model' , 'server');
        $this->load->model('groups_model' , 'groups');
        $this->load->model('economy_model' , 'economy');
    }

    public function index(){
        $q = $this->db->get_where('dc_time', array('param' => 'cron'), 1);
        $lasttime = $q->row_array()['time'];
        if($lasttime > (time() - 50)){
            die('Следующий запуск через: ' . ($lasttime + 50 - time()) . ' секунд!');
        }else{
            $this->db->update('dc_time', array('time' => time()), array('param' => 'cron'), 1);
        }

        /*if($_SERVER['REMOTE_ADDR'] != '87.250.10.210'){
            exit('Мамка Егора)');
        }*/

        $arrgroups = $this->groups->checkExpire();
        $arrservers = $this->genServerStatus();

        $this->println('Очищены группы:<pre>');
        print_r($arrgroups);
        $this->println('</pre>');

        $this->println('Статус серверов:<pre>');
        print_r($arrservers);
        $this->println('</pre>');

        foreach($arrservers as $sname=>$info) {
                $this->db->update('dc_servers',$info,array('name' => $sname), 1);
            }
         
         $q = $this->db->get_where('dc_time', array('param' => 'stat'), 1);
        $lasttime = $q->row_array()['time'];
        if ($lasttime < (time() - 1800)) {
            $this->db->update('dc_time', array('time' => time()), array('param' => 'stat'), 1);
            foreach($arrservers as $sname=>$info) {
                $this->db->insert('dc_stat', array(
                    'name' => $sname,
                    'type' => 1,
                    'time' => time(),
                    'count' => $info['online']
                ));
            }
        }

        $this->println('Проверка бонусов:<pre>');
        $q = $this->db->query("SELECT * FROM dc_bonus WHERE given = 0");
        foreach($q->result_array() as $info){
            $user = $this->user->getAll($info['uuid']);
            $sq = $this->db->get_where('playTime', array(
                'username' => $user['login']
            ), 1);

            if($sq->num_rows() > 0 && $sq->row_array()['playtime'] > 4320){
                $this->economy->addRealMoney($user['uuid'], $info['sum']);

                $this->db->update('dc_bonus', array(
                    'given' => 1
                ), array(
                    'uuid' => $user['uuid']
                ));
            }
        }
        $this->println('</pre>');

       /* $q = $this->db->query("SELECT * FROM dc_bonus WHERE given = 1");
        foreach($q->result_array() as $info){
            $this->economy->spendRealmoney($info['uuid'], 50);
            $this->db->update('dc_bonus', array(
                'given' => 0
            ), array(
                'uuid' => $info['uuid']
            ));
        }*/

        $this->println('Проверка онлайна:<pre>');
        $q = $this->db->query("SELECT * FROM playTime WHERE playtime > 4320");
        foreach($q->result_array() as $info){
            $user = $this->user->getAll($info['username']);
            if($user['verified'] == 0 && isset($user['byurl']) && !empty($user['byurl'])) $this->economy->addMoney($this->user->getUUID($user['byurl']), 5000);
            $this->db->update('dc_members', array('verified' => 1), array('login' => $info['username']), 1);
            print_r($info);
        }
        $this->println('</pre>');
    }

    public function println($str = ''){
        echo $str;
    }

    public function genServerStatus(){
        $this->load->library('query');

        $rarr = array();
        $arr = $this->server->getAll();

        foreach($arr as $server){
            $Query = new Query();

            try
            {
                $Query->Connect('localhost', intval($server['port']));
                $info = $Query->GetInfo();

                $rarr[$server['name']] = array('online' => intval($info['Players']), 'maxonline' => 100);
            }
            catch( MinecraftQueryException $e )
            {
                $rarr[$server['name']] = array('online' => 0, 'maxonline' => 0);
            }

        }

        return $rarr;
    }

}
