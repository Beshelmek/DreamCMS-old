<?php

class DCMS_Controller extends CI_Controller {

    public $userinfo;
    public $usergroups;
    //public $dbconfig;

    public function __construct() {
        parent::__construct();

        $uuid = $this->common->getUUID();

        if($this->isAdmin($uuid)){
            //$this->output->enable_profiler(TRUE);
        }
        //$this->dbconfig = $this->load->library('dbconfig');

        if(isset($uuid) && !empty($uuid)){
            $this->userinfo = $this->user->getAll($this->common->getUUID());
            $this->usergroups = $this->groups->allGroups($this->userinfo['uuid']);

            /*$q = $this->db->get_where('dc_bonus', array('uuid' => $this->userinfo['uuid']), 1);
            $row = $q->row_array();
            if(isset($row['uuid'])){
                $this->load->helper('cookie_helper');
                set_cookie('dc_alert', 'Вы получите ваш бонус размером ' . $row['sum'] . ' руб. после того как проведете в игре 3 дня!', 10);
            }*/
        }
        if($this->session->has_userdata('last_activity')) {
            if ($this->session->userdata('last_activity') < (time() - 300)) {
                $this->session->set_userdata('last_activity', time());
            }
        }

    }

    public function isAdmin($uuid = ''){
        if(!isset($uuid) || empty($uuid)){
            $uuid = $this->userinfo['uuid'];
        }
        $arr = $this->dbconfig->admins;
        if(in_array($uuid, $arr)){
            return true;
        }
        return false;
    }

    public function checkAdmin(){
        $uuid = $this->userinfo['uuid'];

        $arr = $this->dbconfig->admins;
        if(!isset($uuid) || empty($uuid) || !in_array($uuid, $arr)){
            if($this->input->post('json_answ')){
                $this->common->showError('Ошибка авторизации! Войдите на сайт!');
            }
            $this->tpl->show_error('Ошибка доступа!', 'Что бы просмотреть эту страницу, Вам нужно войти на сайт!');
            die($this->output->get_output());
        }
    }


    public function checkAuth($need){
        if($need){
            if(!$this->common->isLogged()){
                if($this->input->post('json_answ')){
                    $this->common->showError('Ошибка авторизации! Войдите на сайт!');
                }
                $this->tpl->show_error('Ошибка доступа!', 'Что бы просмотреть эту страницу, Вам нужно войти на сайт!');
                die($this->output->get_output());
            }
        }else{
            if($this->common->isLogged()){
                if($this->input->post('json_answ')){
                    $this->common->showError('Вы уже авторизованы!');
                }
                $this->tpl->show_error('Ошибка доступа!', 'Вы уже вошли на сайт!');
                die($this->output->get_output());
            }
        }
    }

}