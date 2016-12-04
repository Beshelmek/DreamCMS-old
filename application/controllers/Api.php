<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API extends DCMS_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('user_model' => 'user'));
        $this->load->model(array('region_model' => 'region'));
        $this->output->enable_profiler(TRUE);
    }

    public function index(){
        die($this->isAdmin());
    }

    public function not_found(){
        $this->tpl->show_404();
    }

    public function test(){
        die();
        if($this->config->item('ipb_integration')){
            require_once(APPPATH . 'third_party/IPBForumIntegrate.php');
            $ipb = new IPBForumIntegrate(FCPATH . 'forum');

            $users = $this->db->get('dc_members')->result_array();
            foreach ($users as $user){
                $ipb->registerUser($user['login'], $user['email'], $user['password'], $user['reg_time']);
                echo $user['login'] . '</br>';
            }
        }
    }

    /*public function test(){
        $uarr = $this->db->get('dc_members')->result_array();

        foreach($uarr as $user){
            if(isset($user['byurl']) && $user['byurl'] != null && $user['byurl'] != 0 && !empty($user['byurl'])){
                $this->db->update('dc_members', array(
                    'byurl' => $this->user->getUUID($user['byurl'])
                ),array(
                    'login' => $user['login']
                ), 1);
            }
        }
    }*/

    /*public function fill(){
        $this->checkAdmin();

        $path = '/var/www/www-root/data/www/dreamcraft.su/itempanel.csv';
        $lines = file($path, FILE_IGNORE_NEW_LINES);
        foreach($lines as $line){
            if($line == 'Item Name,Item ID,Item meta,Has NBT,Display Name') continue;
            $info = split(',', $line);
            $this->db->insert('dc_shop_items', array(
                'dname' => $info[4],
                'type' => $info[0],
                'damage' => $info[2],
                'sname' => $info[4],
                'price' => 0,
                'dprice' => 0,
                'category' => 'classic'
            ));
        }
    }*/

    /*public function syncperm(){
        $q = $this->db->get('dc_usergroups');
        $na = $q->result_array();

        $groups = array('vip', 'premium', 'deluxe', 'ultima');
        foreach ($groups as $group){
            $this->db->delete('permissions_inheritance', array(
                'parent' => $group,
                'type' => 1
            ));
            $this->db->delete('permissions', array(
                'permission' => 'group-'.$group.'-until'
            ));
        }

        foreach($na as $nowarr){
            $this->db->insert('permissions_inheritance', array(
                'child' => $nowarr['uuid'],
                'parent' => strtolower($nowarr['group']),
                'type' => 1,
            ));
            $this->db->insert('permissions', array(
                'name' => $nowarr['uuid'],
                'type' => 1,
                'permission' => 'group-'.strtolower($nowarr['group']).'-until',
                'world' => '',
                'value' => $nowarr['expire']
            ));
        }
    }*/

}