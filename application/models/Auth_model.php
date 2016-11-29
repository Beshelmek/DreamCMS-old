<?php
class Auth_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function registerUser($login, $pass, $ip = '0.0.0.0', $byurl = 'Admin'){
        $data = array(
            'login' => $login,
            'password' => md5(sha1($pass)),
            'email' => $login . '@dreamcraft.su',
            'reg_ip' => $ip,
            'reg_time' => time(),
            'last_time' => time(),
            'realmoney' => '0.00',
            'money' => '0.00',
            'byurl' => $byurl,
            'name' => '',
            'gender' => 'not_stated'
        );
        if($this->db->insert('dc_members', $data)){
            return TRUE;
        }
        return FALSE;
    }

    public function addRefInfo($ip, $uuid, $refer = '', $bonus = ''){

        if(empty($refer))$refer = 'dir';
        if(empty($bonus))$bonus = 'none';

        $data = array(
            'ip' => $ip,
            'uuid' => $uuid,
            'refer' => $refer,
            'bonus' => $bonus,
        );
        $this->db->insert('dc_refer', $data);

        if($bonus == 'mcrate9'){
            $this->db->insert('dc_bonus', array(
                'uuid' => $uuid,
                'time' => time(),
                'sum' => 50
            ));
        }
    }

    public function setPassword($login, $pass){
        $data = array(
            'password' => md5(sha1($pass))
        );

        $this->db->where('login', $login);
        if($this->db->update('dc_members', $data)){
            return TRUE;
        }
        return FALSE;
    }

    public function setEmail($login, $email){
        $data = array(
            'email' => $email
        );

        $this->db->where('login', $login);
        if($this->db->update('dc_members', $data)){
            return TRUE;
        }
        return FALSE;
    }

    public function sendPassword($login){
        $query = $this->db->get_where('dc_members', array('login' => $login), 1);
        $row = $query->row_array();

        if (isset($row)) {
            $this->load->helper('string');
            require_once APPPATH . 'libraries/SmtpApi.php';

            $key = random_string('md5');
            $message = 'Для изменения пароля игрока '.$row['login'].', пройдите по ссылке: http://dreamcraft.su/auth/key/' . $key;

            $api = new SmtpApi();
            $aData = array(
               'html' => '',
               'text' => $message,
               'subject' => 'DreamCraft - Смена пароля',
               'encoding' => 'utf8',
               'from' => array(
                   'email' => 'votyakov1404@gmail.com',
                   'name' => 'DreamCraft.Su',
               ),
               'to' => array(
                  array(
                       'email' => $row['email'],
                       'name' => $row['login']
                  )
               )
            );
            $api->send_email($aData);

            $this->db->update('dc_members', array('sendkey' => $key), array('email' => $row['email']), 1);
            return TRUE;
        }
        return FALSE;
    }

    public function checkUser($login, $pass) {
        $this->db->where('login', $login);
        $this->db->where('password', md5(sha1($pass)));
        $query = $this->db->get('dc_members');
        if($query->num_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    public function checkLogin($login){
        $this->db->where('login', $login);
        $query = $this->db->get('dc_members');
        if ($query->num_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    public function checkIP($ip){
        if($ip == '87.250.10.210') return false;
        $this->db->where('reg_ip', $ip);
        $query = $this->db->get('dc_members');
        if ($query->num_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    public function checkKey($login, $key){
        if(empty($key)) return FALSE;
        $this->db->where('sendkey', $key);
        $this->db->where('login', $login);
        $query = $this->db->get('dc_members');
        if ($query->num_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    public function checkEmail($email){
        $this->db->where('email', $email);
        $query = $this->db->get('dc_members');
        if ($query->num_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    public function userInfo($login) {
        if(strlen($login) == 36){
            $this->db->where('uuid', $login);
            $query = $this->db->get('dc_members');
        }else{
            $this->db->where('login', $login);
            $query = $this->db->get('dc_members');
        }
        return $query->row_array();
    }

    public function validateKey($key) {
        $this->load->helper('string');

        $newpass = random_string('alnum', 8);

        $query = $this->db->get_where('dc_members', array('sendkey' => $key));
        $row = $query->row_array();
        if (isset($row)) {

            if($this->setPassword($row['login'], $newpass)){
                require_once APPPATH . 'libraries/SmtpApi.php';

                $message = 'Ваш логин: '.$row['login'].', ваш новый пароль: ' . $newpass;

                $api = new SmtpApi();
                $aData = array(
                    'html' => '',
                    'text' => $message,
                    'subject' => 'DreamCraft - Смена пароля',
                    'encoding' => 'utf8',
                    'from' => array(
                        'email' => 'votyakov1404@gmail.com',
                        'name' => 'DreamCraft.Su',
                    ),
                    'to' => array(
                        array(
                            'email' => $row['email'],
                            'name' => $row['login']
                        )
                    )
                );
                $api->send_email($aData);
                
                $this->db->where('login', $row['login']);
                $this->db->update('dc_members', array('sendkey' => ''));

                return $row;
            }
        }
        return '';
    }
}