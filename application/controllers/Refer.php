<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Refer extends DCMS_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('refer_model', 'refer');
        $this->checkAuth(true);
    }

    public function index()
    {
        $this->tpl->compile('profile/refer', array('players' => $this->refer->getRefers($this->userinfo['uuid'])), 'Реферальная система');
    }

}