<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rcon extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('groups_model', 'groups');
        $this->load->model('server_model', 'server');
        $this->load->helper('MinecraftString');
    }

    public function index()
    {
        if(isset($_POST['server'])){
            $ser = $this->server->getAll($_POST['server']);
            $command = isset($_POST['rcon']) && !empty($_POST['rcon']) ? $_POST['rcon'] : 'version';
            if ($command[0] == '/') {
                $command = substr($command, 1);
            }
            try
            {
                $this->load->library('rconlib');
                $this->rconlib->connect('localhost', $ser['rconport'], $ser['password']);
                $return =  nl2br(minecraft_string($this->rconlib->command($command)));
            }
            catch(Exception $e)
            {
                $return = $e->getMessage();
            }
            die($return);
        }else{
            $servers = $this->server->getList();
            $this->tpl->compile('rcon/index', array('servers' => $servers), 'Консоли серверов');
        }
    }

}
