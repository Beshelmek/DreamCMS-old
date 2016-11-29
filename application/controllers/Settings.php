<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends DCMS_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->checkAuth(true);
    }

    public function index(){
        require_once(APPPATH . 'third_party' . DIRECTORY_SEPARATOR . 'GoogleAuthenticator.php');
        $ga = new GoogleAuthenticator();

        $ga_temp = $ga->generateSecret();
        $this->session->set_userdata('ga_temp', $ga_temp);
        $this->tpl->compile('profile/settings', array('user' => $this->userinfo, 'ga_temp' => $ga_temp), 'Настройки аккаунта');
    }
}