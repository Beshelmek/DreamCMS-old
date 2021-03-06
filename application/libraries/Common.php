<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Common {
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('user_model', 'user');
        $this->CI->load->helper('url');
    }

    public function getUUID()
    {
        if($this->CI->session->userdata('uuid')){
            return $this->CI->session->userdata('uuid');
        }

        return false;
    }

    public function getLogin()
    {
        if($this->isLogged()){
            return $this->CI->user->getAll($this->getUUID())['login'];
        }
        return false;
    }

    public function isLogged(){
        if($this->getUUID() != '' && !empty($this->getUUID())){
            return true;
        }
        return false;
    }

    public function showError($msg){
        exit(json_encode(array('type' => 'error', 'msg' => $msg)));
    }

    public function showOK($msg, $actions = array()){
        if(count($actions) > 0){
            exit(json_encode(array('type' => 'success', 'msg' => $msg, 'actions' => $actions)));
        }
        exit(json_encode(array('type' => 'success', 'msg' => $msg)));
    }
}