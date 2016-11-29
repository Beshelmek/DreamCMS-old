<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Top extends DCMS_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('top_model' => 'top'));
        $this->load->model(array('economy_model' => 'economy'));
    }

    public function golos(){
        $this->tpl->compile('top/golos', array('players' => $this->top->golos_arr()), 'Топ голосующих');
    }

    public function online(){
        $this->tpl->compile('top/online', array('players' => $this->top->online_arr()), 'Топ активных');
    }

    public function money()
    {
        $this->tpl->compile('top/money', array('players' => $this->top->money_arr()), 'Топ активных');
    }

    private function addBox($uuid){
        $q = $this->db->get_where('dc_box', array(
            'uuid' => $uuid,
            'box' => 9000
        ));

        if($q && $q->num_rows() > 0){
            $count = $q->row_array()['count'];
            $this->db->update('dc_box', array('count' => $count+1), array(
                'uuid' => $uuid,
                'box' => 9000
            ), 1);
        }else{
            $this->db->insert('dc_box', array(
                'uuid' => $uuid,
                'box' => 9000,
                'count' => 1
            ));
        }
    }

    private function addVote($login, $top, $onlyone){
        $time = time();
        $uuid = $this->user->getUUID($login);
        $q = $this->db->get_where('dc_golos', array(
            'uuid' => $uuid
        ), 1);

        if($q && $q->num_rows() > 0){
            $info = $q->row_array();

            if((intval($info['last_' . $top]) + 43200) > $time){
                if($onlyone)
                    $this->common->showError('Time to small!');
            }else{
                $this->addBox($uuid);
            }

            $this->db->update('dc_golos', array(
                'count' => intval($info['count']) + 1,
                'last_'.$top => $time
            ), array(
                'uuid' => $uuid
            ), 1);

        }else{
            $this->db->insert('dc_golos', array(
                'uuid' => $uuid,
                'count' => 1,
                'last_topcraft' => 0,
                'last_mcrate' => 0,
                'last_mctop' => 0,
                'last_fairtop' => 0
            ));

            $this->db->update('dc_golos', array(
                'last_'.$top => $time
            ), array(
                'uuid' => $uuid
            ), 1);
        }

        $this->economy->addMoney($uuid, 500);
        $this->addRefBonus($uuid);

        $this->db->update('dc_members', array(
            'golos'=>'golos+1'
        ), array(
            'uuid' => $uuid
        ), 1);

        $this->logger->log('golos_add', $uuid, array(
            'top' => $top,
            'ip' => $this->input->ip_address()
        ));

        $this->common->showOK('OK!');
    }

    public function topcraft(){
        $seckey = "124b77214a989da96b16c5fac44f5c65";

        $username  = htmlspecialchars($this->input->post('username'));
        $timestamp = $this->input->post('timestamp');
        $signature = $this->input->post('signature');

        if($signature != sha1($username.$timestamp.$seckey)){
            show_error('Ошибка подписи!');
        }else{
            $this->addVote($username, 'topcraft', true);
        }
    }

    public function mctop(){
        $seckey = "a1893bc5665ab6ae183d4f885cc1d6c9";

        $username  = $this->input->get('nickname');
        $signature = $this->input->get('token');

        if($signature != md5($username.$seckey)){
            show_error('Ошибка подписи!');
        }else{
            $this->addVote($username, 'mctop', true);
        }
    }

    public function mcrate(){
        $seckey = "bd8f241afa74cf75";

        $username  = $this->input->post('nick');
        $signature = $this->input->post('hash');

        if($signature != md5(md5($username.$seckey.'mcrate'))){
            show_error('Ошибка подписи!');
        }else{
            $this->addVote($username, 'mcrate', true);
        }
    }

    public function fairtop(){
        $seckey = "HudAwwFiIE9rONy9f3rgKvSjUv0bzbT7";

        $username  = $this->input->post('player');
        $signature = $this->input->post('hash');

        if($signature != md5(sha1($username.':'.$seckey))){
            show_error('Ошибка подписи!');
        }else{
            $this->addVote($username, 'fairtop', true);
        }
    }

    private function addRefBonus($user){
        $user = $this->user->getUUID($this->user->getAll($user)['byurl']);
        if(isset($user) && !empty($user)){
            $this->economy->addMoney($user, 50);
        }
    }
}