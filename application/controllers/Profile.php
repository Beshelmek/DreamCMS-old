<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends DCMS_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('server_model' , 'server');
        $this->load->model('permissions_model' , 'permissions');
        $this->load->model('groups_model' , 'groups');
        $this->load->model('economy_model' , 'economy');
        $this->checkAuth(true);
    }

    public function index()
    {
        $profile = array(
            'reg_time' => date("d-m-Y H:i:s", $this->userinfo['reg_time']),
            'last_time' => date("d-m-Y H:i:s", $this->userinfo['last_time']),
            'usergroups' => $this->usergroups,
            'groups' => $this->groups->getAllArr(),
            'servers' => $this->server->getAll(),
            'maxgroup' => $this->permissions->getMaxUserGroup($this->usergroups)
        );

        if(isset($this->userinfo['byurl']) && !empty($this->userinfo['byurl']))
            $profile['inviter'] = $this->user->getLogin($this->userinfo['byurl']);

        $this->tpl->compile('profile/profile', array('profile' => $profile), 'Профиль ' . $this->userinfo['login']);
    }

    public function view($login)
    {
        $profile = array(
            'profile' => $login,
            'reg_time' => date("d-m-Y H:i:s", $this->userinfo['reg_time']),
            'byurl' => $this->userinfo['byurl'],
            'last_time' => date("d-m-Y H:i:s", $this->userinfo['last_time']),
        );

        $this->tpl->compile('profile/view', $profile, 'Профиль ' . $this->userinfo['login']);
    }

    public function upload()
    {
        $type = $this->input->post('type');

        if($type == 'skin'){
            $config['upload_path'] = FCPATH . 'uploads'.DIRECTORY_SEPARATOR.'skins';
        }elseif($type == 'cloak'){
            $config['upload_path'] = FCPATH . 'uploads'.DIRECTORY_SEPARATOR.'cloaks';
        }else{
            $config['upload_path'] = '/dev/null';
        }

        $config['max_size']             = 5000;
        $config['max_width']            = 1024;
        $config['min_width']            = 64;
        $config['max_height']           = 512;
        $config['min_height']           = 32;

        $config['allowed_types']        = 'png';
        $config['overwrite']            = TRUE;
        $config['remove_spaces']        = TRUE;
        $config['file_name']            = $this->userinfo['uuid'] . '.png';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('userfile') || $this->upload->data()['is_image'] != 1)
        {
            print_r($this->upload->error_msg);
            $this->tpl->compile('error', array('msg' => 'Произошла ошибка!'), 'Загрузка скина\плаща');
        }
        else
        {
            $this->tpl->compile('success', array('msg' => 'Успешно загруженно!'), 'Загрузка скина\плаща');
        }
    }

    public function prefix(){
        $uuid  = $this->userinfo['uuid'];
        $server = $this->server->getAll($this->input->post('server'));
        $pcolor = $this->input->post('pcolor');
        $pref   = $this->input->post('prefix');
        $ncolor = $this->input->post('ncolor');
        $mcolor = $this->input->post('mcolor');

        $prefix =  '&8[&'. $pcolor . $pref . '&r&8]&r&' . $ncolor;

        $err = array();

        if(strlen($pref) < 3){
            $err[] = "Префикс должен быть более 1 символа!";
        }

        if(strlen($pcolor) != 1 || strlen($ncolor) != 1 || strlen($pref) > 10){
            $err[] = "Префикс должен быть не более 10 латинских или 5 русских символов!";
        }

        if(substr_count($pref, "&k") > 0 || substr_count($pcolor, "k") > 0 || substr_count($pcolor, "k") > 0 || substr_count($mcolor, "k") > 0){
            $err[] = "Цвет &k запрещен!";
        }

        if(substr_count($pref, "&0") > 0 || substr_count($pcolor, "0") > 0 || substr_count($pcolor, "0") > 0 || substr_count($mcolor, "0") > 0){
            $err[] = "Цвет &0 запрещен!";
        }

        if(substr_count($pref, "&4") > 0 || substr_count($pcolor, "4") > 0 || substr_count($pcolor, "4") > 0 || substr_count($mcolor, "4") > 0){
            $err[] = "Цвет &4 запрещен!";
        }

        $free = false;
        if($this->permissions->canSetPrefix($uuid, $server['name'])){
            $free = true;
        }

        if(count($err) < 1){
            if(!$free){
                if(!$this->economy->spendRealmoney($this->userinfo['uuid'], 50)){
                    $this->common->showError("У вас нет прав для смены префикса на этом сервере!");
                }
            }

            $this->server->sendCmd('pex user ' . $uuid .' prefix "' . $prefix . '"', $server['name']);
            $this->logger->log('prefix_chat', $uuid, array(
                'prefix' => $prefix,
                'server' => $server['name']
            ));
            if($free && $this->permissions->canSetMsgColor($uuid, $server['name'])){
                $this->server->sendCmd('pex user ' . $uuid .' suffix "&' . $mcolor . '"', $server['name']);
                $this->server->sendCmd('pex reload', $server['name']);
                $this->common->showOK('Вы успешно изменили префикс и цвет чата!');
            }else{
                $this->server->sendCmd('pex user ' . $uuid .' suffix "&f"', $server['name']);
                $this->server->sendCmd('pex reload', $server['name']);
                $this->common->showOK('Вы успешно изменили префикс! Цвет чата доступен только для Ultima!');
            }
        }else{
            $this->common->showError(implode('</br>', $err));
        }
    }

    public function exchange(){
        $uuid = $this->userinfo['uuid'];
        $count = intval($this->input->post('count'));

        $money = $count * 100;

        $err = array();

        if($count < 1){
            $err[] = 'Вы не можете обменять менее 1 монеты!';
        }else{
            if($this->economy->spendRealMoney($uuid, $count)){
                $this->economy->addMoney($uuid, $money);
            }else{
                $err[] = 'У вас не хватает монет!';
            }
        }

        if(count($err) < 1){
            $this->logger->log('exchange_realmoney', $uuid, array(
                'count' => $count
            ));
            $this->common->showOK('Вы успешно обменяли монеты!');
        }else{
            $this->common->showError(implode('</br>', $err));
        }
    }

    public function buygroup(){
        $uuid = $this->userinfo['uuid'];
        $group = $this->groups->getInfo($this->input->post('group'));

        $err = array();

        if(empty($group['name'])){
            $err[] = "Такой привилегии не существует!";
        }

        if(count($err) < 1){
            if($this->economy->spendRealmoney($uuid, $group['price'])){
                $this->groups->addUserToGroup("HiTech", $uuid, $group);

                $this->logger->log('group_buy', $uuid, array(
                    'group' => $group['name'],
                    'server' => "all"
                ));
                $this->syncperm();
                $this->common->showOK('Вы успешно купили ' . $group['name'] . ' на всех серверах!');
            }else{
                $this->common->showError('У вас недостаточно средств!');
            }
        }else{
            $this->common->showError(implode('</br>', $err));
        }
    }

    private function syncperm(){
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
    }

    public function save(){
        $uuid = $this->userinfo['uuid'];
        $name = $this->input->post('name');
        $gender = $this->input->post('gender');

        if($gender != 'female' && $gender != 'male'){
            $this->common->showError('Выберите пол!');
        }

        $this->db->update('dc_members', array('name' => $name, 'gender' => $gender), array('uuid' => $uuid));
        $this->common->showOK('Вы успешно изменили информацию о себе!');
    }
}
