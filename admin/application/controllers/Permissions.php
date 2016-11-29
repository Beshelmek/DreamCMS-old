<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('permissions_model', 'permissions');
    }

    public function index()
    {
        $this->tpl->compile('pex/index', array('servers' => $this->server->getAll()), 'PermissionsEx редактор');
    }

    public function edit($server = ''){
        if(!empty($server))
            $this->tpl->compile('pex/list', array('pexlist' => $this->permissions->getAll($server), 'server' => $server), 'PermissionsEx редактор');
    }

    public function sync(){
        $this->permissions->sync();
        $this->tpl->compile('success', array('msg' => '', 'url' => 'permissions'), 'PermissionsEx редактор');
    }

    public function add(){
        $id = $this->permissions->addPermToGroup($this->input->post('server'), $this->input->post('group'), $this->input->post('perm'));
        $this->common->showOK('Добавлено!', array('id' => $id));
    }

    public function remove(){
        $this->permissions->removePermFromGroup($this->input->post('id'), $this->input->post('server'));
        $this->common->showOK('Удалено!');
    }

}
