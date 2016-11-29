<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends DCMS_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth_model', 'auth');
        $this->load->model('economy_model', 'economy');
        $this->load->helper('url');
        $this->load->helper('email');
    }

    public function login()
    {
        $this->checkAuth(false);

        $err = array();

        if(!$this->input->post('login') || !$this->input->post('pass')){
            $err[] = "Введите логин и пароль";
        }

        $login = trim($this->input->post('login'));
        $pass =  $this->input->post('pass');
        $ip = $this->input->ip_address();

        $q = $this->db->get_where('dc_brute', array('ip' => $ip), 1);
        if($q->num_rows() > 0){
            $row = $q->row_array();
            if($row['bantime'] > time()){
                $this->common->showError('Много попыток входа! Повторите через 5 минут!');
            }else{
                if($row['bantime'] != 0){
                    $this->db->update('dc_brute', array('count' => 0, 'bantime' => 0), array('ip' => $ip), 1);
                }
            }
        }

        if(count($err) > 0){
            $this->common->showError(implode("</br>", $err));
        }

        if($this->auth->checkUser($login, $pass)) {
            $data = $this->auth->userInfo($login);

            if(isset($data['ga_secret']) && !empty($data['ga_secret'])){
                $this->session->set_flashdata('auth_uuid', $data['uuid']);
                $this->common->showOK('Переадресация на страницу двухэтапной аутентификации!', array(
                    'redirect' => site_url('auth/ga_auth')
                ));
            }else{
                $ses_data = array(
                    'login' => $data['login'],
                    'uuid' => $data['uuid'],
                    'authtime' => time()
                );

                $this->session->set_userdata($ses_data);

                $this->logger->log('auth_login', $data['uuid'], array(
                    'ip' => $this->input->ip_address(),
                    'login' => $data['login']
                ));

                $this->common->showOK('Вы успешно вошли!', array(
                    'reload' => 'false'
                ));
            }
        } else {
            $q = $this->db->get_where('dc_brute', array('ip' => $ip), 1);
            if($q->num_rows() > 0){
                $row = $q->row_array();
                $this->db->update('dc_brute', array('count' => ($row['count'] + 1)), array('ip' => $ip), 1);
                if($row['count'] >= 2){
                    if($row['bantime'] < time()){
                        $this->db->update('dc_brute', array('bantime' => time() + 300), array('ip' => $ip), 1);
                    }
                }
            }else{
                $row['count'] = 0;
                $this->db->insert('dc_brute', array(
                    'ip' => $ip,
                    'count' => 1,
                    'bantime' => 0
                ));
            }

            $this->common->showError('Неверный логин или пароль [' . $row['count'] . ']');
        }
    }

    public function ga_auth($action = ''){
        require_once(APPPATH . 'third_party' . DIRECTORY_SEPARATOR . 'GoogleAuthenticator.php');
        $ga = new GoogleAuthenticator();

        if (!empty($action)){
            $this->checkAuth(true);
            if ($action == 'enable'){
                $code = $this->input->post('ga_code');
                $secret = $this->session->userdata('ga_temp');

                $this->session->unset_userdata('ga_temp');

                if($ga->checkCode($secret, $code)){
                    $this->db->update('dc_members', array(
                        'ga_secret' => $secret
                    ), array(
                        'uuid' => $this->userinfo['uuid']
                    ), 1);

                    $this->db->insert('dc_otp', array(
                        'secret' => $secret,
                        'uuid' => $this->userinfo['uuid'],
                        'active' => 1
                    ));

                    $this->common->showOK('Защита включена!');
                }

                $this->common->showError('Код не подходит!');
            }elseif ($action == 'disable'){
                $this->db->update('dc_members', array(
                    'ga_secret' => null
                ), array(
                    'uuid' => $this->userinfo['uuid']
                ), 1);

                $this->db->delete('dc_otp', array(
                    'uuid' => $this->userinfo['uuid']
                ));

                $this->common->showOK('Защита отключена!');
            }
        }

        if($this->input->post('ga_code')){
        	$this->checkAuth(false);
            $uuid = $this->session->flashdata('auth_uuid');

            $user = $this->db->get_where('dc_members', array(
                'uuid' => $uuid
            ), 1)->row_array();
            $secret = $user['ga_secret'];

            if($ga->checkCode($secret, $this->input->post('ga_code'))){
                $ses_data = array(
                    'login' => $user['login'],
                    'uuid' => $user['uuid'],
                    'authtime' => time()
                );

                $this->session->set_userdata($ses_data);

                $this->logger->log('auth_ga', $user['uuid'], array(
                    'ip' => $this->input->ip_address(),
                    'login' => $user['login'],
                    'uuid' => $user['uuid']
                ));

                redirect(base_url());
            }else{
                redirect(base_url());
            }
        }else{
            $this->session->set_flashdata('auth_uuid', $this->session->flashdata('auth_uuid'));
            $this->tpl->compile('profile/otp_auth');
        }
    }

    public function logout()
    {
        if($this->common->isLogged()){
            $this->session->sess_destroy();
        }
        redirect(base_url());
    }

    public function register()
    {
        $this->checkAuth(false);

        $log['login'] = $this->input->post('login');
        $log['pass'] =  $this->input->post('pass');
        $log['rpass'] =  $this->input->post('rpass');
        $log['key'] =  $this->input->post('g-recaptcha-response');
        $log['ip'] =  $this->input->ip_address();
        $log['byurl'] =  $this->input->cookie('refer');
        $log['bonus'] =  $this->input->cookie('bonus');

        $err = array();

        if(strlen($log['login']) > 32 || strlen($log['login']) < 3){
            $err[] = 'Логин должен быть длинной от 3 до 32 символов!';
        }

        if(strlen($log['pass']) > 32 || strlen($log['pass']) < 6){
            $err[] = 'Пароль должен быть длинной от 6 до 32 символов!';
        }

        if(preg_match('/[^a-z0-9\-\_\.]+/i', $log['login']))
        {
            $err[] = 'Логин может содержать только латинские буквы, числа, символы ("-","_",".")!';
        }

        if(preg_match('/[^a-z0-9\-\_\.]+/i', $log['pass']))
        {
            $err[] = 'Пароль может содержать только латинские буквы, числа, символы ("-","_",".")!';
        }

        if($log['pass'] <> $log['rpass']){
            $err[] = 'Пароль и повтор пароля не совпадают!';
        }

        /*if(!valid_email($log['email'])){
            $err[] = 'Не валидная почта! Введите реальную почту!';
        }*/

        if($this->auth->checkLogin($log['login'])){
            $err[] = "Игрок с таким ником уже зарегистрирован!";
        }

        /*if($this->auth->checkEmail($log['email'])){
            $err[] = "Игрок с этой почтой уже есть!";
        }*/

        if(count($err) < 1) {
            $myCurl = curl_init();
            curl_setopt_array($myCurl, array(
                CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query(array(
                    'secret' => '6Lcz2BATAAAAAHlFl4tkgBEz324j_Vjgn0DWaRDL', 'response' => $log['key']
                ))
            ));
            $response = curl_exec($myCurl);
            curl_close($myCurl);
            $json = json_decode($response, true);

            if (!$json['success']) {
                $err[] = "Извините, система приняла Вас за бота! Если это ошибка, сообщите Администрации!";
            }
        }

        if(count($err) < 1){
            if($this->auth->registerUser($log['login'], $log['pass'], $log['ip'], $log['byurl'])){
                $data = $this->auth->userInfo($log['login']);

                $ses_data = array(
                    'login' => $data['login'],
                    'uuid' => $data['uuid'],
                    'authtime' => time()
                );

                $this->session->set_userdata($ses_data);

                $this->auth->addRefInfo($this->input->ip_address(), $data['uuid'], $log['byurl'], $log['bonus']);

                $this->common->showOK('Вы успешно прошли регистрацию!', array(
                    'reload' => 'false'
                ));
            }
        }else{
            $this->common->showError(implode('</br>', $err));
        }
    }

    public function change_password(){
        $this->checkAuth(true);

        $log['login'] =  $this->userinfo['login'];
        $log['uuid'] =  $this->userinfo['uuid'];
        $log['pass'] =  $this->input->post('pass');
        $log['newpass'] =  $this->input->post('newpass');
        $log['rnewpass'] =  $this->input->post('rnewpass');
        $log['email'] =  $this->input->post('email');
        $log['key'] =  $this->input->post('g-recaptcha-response');

        if(!empty($log['newpass']) && !empty($log['email'])){
            $err1 = $this->save_pass($log);
            $err2 = $this->save_email($log, TRUE);

            $err = array_merge($err1, $err2);
            if(count($err) < 1){
                $this->logger->log('change_password_mail', $log['uuid'], array(
                    'ip' => $this->input->ip_address(),
                    'login' => $log['login']
                ));

                $this->common->showOK('Вы успешно изменили пароль и почту!');
            }else{
                $this->common->showError(implode('</br>', $err));
            }
        }elseif(!empty($log['newpass'])){
            $err = $this->save_pass($log);
            if(count($err) < 1){
                $this->logger->log('change_password', $log['uuid'], array(
                    'ip' => $this->input->ip_address(),
                    'login' => $log['login']
                ));

                $this->common->showOK('Вы успешно изменили пароль!');
            }else{
                $this->common->showError(implode('</br>', $err));
            }
        }elseif(!empty($log['email'])){
            $err = $this->save_email($log);
            if(count($err) < 1){
                $this->logger->log('change_mail', $log['uuid'], array(
                    'ip' => $this->input->ip_address(),
                    'login' => $log['login']
                ));

                $this->common->showOK('Вы успешно изменили почту!');
            }else{
                $this->common->showError(implode('</br>', $err));
            }
        }else{
            $this->common->showError('Вы ничего не изменили!');
        }
    }

    private function save_email($log, $bypass = FALSE)
    {
        $this->checkAuth(true);

        $err = array();

        if(!valid_email($log['email'])){
            $err[] = "Почта не соответствует формату!";
        }

        if(!$bypass){
            if(!$this->auth->checkUser($log['login'], $log['pass'])){
                $err[] = "Неверный пароль!";
            }
        }
        
        if(count($err) < 1){
            if($this->auth->setEmail($log['login'], $log['email'])){
                return array();
            }else{
                return array('Что-то пошло не так. Ошибка базы данных!');
            }
        }else{
            return $err;
        }
    }

    private function save_pass($log)
    {
        $this->checkAuth(true);

        $err = array();

        if(strlen($log['newpass']) > 32 || strlen($log['newpass']) < 5){
            $err[] = 'Пароль должен быть длинной от 5 до 32 символов!';
        }

        if($log['pass'] == $log['newpass']){
            $err[] = 'Пароли совпадают =_= зачем его менять?';
        }

        if(preg_match('/[^a-z0-9\-\_\.]+/i', $log['newpass']))
        {
            $err[] = 'Пароль может содержать только латинские буквы, числа, символы ("-","_",".")!';
        }

        if($log['rnewpass'] != $log['newpass']){
            $err[] = 'Новый пароль и повтор пароля не совпадают!';
        }


        if(!$this->auth->checkUser($log['login'], $log['pass'])) {
            $err[] = "Неверный пароль!";
        }

        if(count($err) < 1){
            if($this->auth->setPassword($log['login'], $log['newpass'])){
                return array();
            }else{
                return array('Что-то пошло не так. Ошибка базы данных!');
            }
        }else{
            return $err;
        }
    }

    public function sendpass(){
        $this->checkAuth(false);

        $this->tpl->compile('profile/sendpass', array(), 'Восстановление пароля');
    }

    public function sendpassword()
    {
        $data =  $this->input->post('email');
        $key =  $this->input->post('g-recaptcha-response');

        $this->checkAuth(false);

        $err = array();

        if(!$this->auth->checkEmail($data)){
            if(!$this->auth->checkLogin($data)){
                $err[] = "Такого пользователя нет!";
            }else{
                $q = $this->db->get_where('dc_members', array('login' => $data), 1);
                $user = $q->row_array();
            }
        }else{
            $q = $this->db->get_where('dc_members', array('email' => $data), 1);
            $user = $q->row_array();
        }

        if(count($err) < 1) {
            $myCurl = curl_init();
            curl_setopt_array($myCurl, array(
                CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query(array(
                    'secret' => '6Lcz2BATAAAAAHlFl4tkgBEz324j_Vjgn0DWaRDL', 'response' =>$key
                ))
            ));
            $response = curl_exec($myCurl);
            curl_close($myCurl);
            $json = json_decode($response, true);

            if (!$json['success']) {
                $err[] = "Извините, система приняла Вас за бота! Если это ошибка, сообщите Администрации!";
            }
        }

        if(count($err) < 1){
            if($this->auth->sendPassword($user['login'])){
                $this->logger->log('send_pass', $user['uuid'], array(
                    'ip' => $this->input->ip_address(),
                    'login' => $user['login']
                ));

                $this->common->showOK('Новый пароль отправлен Вам на почту!');
            }else{
                $this->common->showError('Ошибка на стороне сервера! Сообщите администрации код: ' . time());
            }
        }else{
            $this->common->showError(implode('</br>', $err));
        }
    }

    public function key($key = ""){
        if(!empty($key)){
            $login = $this->auth->validateKey($key);
            if(isset($login) && !empty($login)){
                $this->logger->log('send_pass_new', $login['uuid'], array(
                    'ip' => $this->input->ip_address(),
                    'key' => $key
                ));
                $this->tpl->compile('success', array('msg' => 'Новый пароль отправлен Вам на почту!'), 'Восстановление пароля');
            }else{
                $this->tpl->compile('error', array('msg' => 'Ключ пустой или не верный!'), 'Восстановление пароля');
            }
        }else{
            $this->tpl->compile('error', array('msg' => 'Ключ пустой или не верный!'), 'Восстановление пароля');
        }
    }
}
