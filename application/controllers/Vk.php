<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vk extends DCMS_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->checkAuth(true);
        $this->load->helper('url');
    }

    public function index(){
        if(isset($this->userinfo['vk_uid']) && !empty($this->userinfo['vk_uid']) && $this->userinfo['vk_uid'] != 0){
            $this->tpl->show_error('Ошибка привязки', 'Вы уже привязали страницу ВКонтакте!');
        }
        $this->tpl->compile('profile/vk', array(), 'Привязка ВКонтакте');
    }

    public function validate(){
        if(isset($this->userinfo['vk_uid']) && !empty($this->userinfo['vk_uid']) && $this->userinfo['vk_uid'] != 0){
            $this->tpl->show_error('Ошибка привязки', 'Вы уже привязали страницу ВКонтакте!');
        }
        $code = $this->input->get('code');
        $result = false;
        if (isset($code) && !empty($code)) {
            $params = array(
                'client_id' => 5426721,
                'client_secret' => 'DhpCqro5Bgsczdow3pS3',
                'code' => $code,
                'redirect_uri' => site_url('vk/validate')
            );
            $json = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);

            if (isset($json['access_token']) && !empty($json['access_token'])) {
                $params = array(
                    'uids'         => $json['user_id'],
                    'fields'       => 'uid,first_name,last_name,screen_name,sex,bdate,photo_big',
                    'access_token' => $json['access_token']
                );

                $user = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);

                if (isset($user['response'][0]['uid'])) {
                    $user = $user['response'][0];
                    $this->db->update('dc_members', array(
                        'vk_uid' => $user['uid'],
                        'vk_info' => json_encode($user)
                    ), array(
                        'uuid' => $this->userinfo['uuid']
                    ), 1);
                    $result = true;
                    $this->tpl->show_error('Успешно!', 'Вы привязали свою страницу ВКонтакте!');
                }
            }
        }
        if(!$result) $this->tpl->show_error('Ошибка привязки', 'Что-то пошло не так. Попробуйте позже!');
    }
}