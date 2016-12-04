<?php
class Integration_model extends CI_Model implements iForumIntegrate {

    protected $CI;
    protected $integrator;

    public function __construct(){
        parent::__construct();
        $this->CI = &get_instance();
        if(!$this->CI->config->item('forum_integration')) return;

        $path = $this->CI->config->item('forum_path');
        $this->integrator = new IPBForumIntegrate($path);
    }

    public function getUser($email){
        $integrator = $this->integrator;
        return $integrator::load($email, 'all', 'email');
    }

    public function registerUser($name, $email, $password, $regtime = 0){
        if($regtime == 0) $regtime = time();

        return IPSMember::create(array(
            'members' => array(
                'email'             => $email,
                'name'                => $name,
                'members_l_username'        => strtolower($name),
                'members_display_name'        => $name,
                'members_l_display_name'    => strtolower($name),
                'joined'            => $regtime,
                'md5_hash_password' => md5($password)
            ),
            'profile_portal' => array(),
            'pfields_content' => array()
        ));
    }

    public function removeUser($id){
        IPSMember::remove($id);
    }

    public function updatePassword($id, $password){
        return IPSMember::updatePassword($id, $password);
    }

    public function findIPAddresses($id){
        return IPSMember::findIPAddresses($id);
    }

    public function authenticateMember($name, $password){
        return TRUE;
    }
}