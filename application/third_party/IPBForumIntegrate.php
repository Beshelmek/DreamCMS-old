<?php
require_once 'iForumIntegrate.php';
class IPBForumIntegrate implements iForumIntegrate {
    protected $path;
    protected $ipbRegistry;

    public function __construct($path){
        $this->path = $path;

        define('IPS_ENFORCE_ACCESS', TRUE);
        define('IPB_THIS_SCRIPT', 'public');

        require_once( $this->path . '/initdata.php' );
        require_once( IPS_ROOT_PATH . 'sources/base/ipsRegistry.php' );
        require_once( IPS_ROOT_PATH . 'sources/base/ipsController.php' );

        $this->ipbRegistry = ipsRegistry::instance();
        $this->ipbRegistry->init();
    }

    public function getUser($email){
        return IPSMember::load($email, 'all', 'email');
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
        return IPSMember::remove($id);
    }

    public function updatePassword($id, $password){
        return IPSMember::updatePassword($id, $password);
    }

    public function updateEmail($id, $email){
        return IPSMember::save($id, array(
            'members' => array(
                'email'             => $email
            ))
        );
    }

    public function findIPAddresses($id){
        return IPSMember::findIPAddresses($id);
    }

    public function authenticateMember($name, $password){
        return TRUE;
    }
}