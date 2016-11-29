<?php
class Server_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Database Loader
     *
     * @param	mixed	$server		Server name
     *
     * @return	CI_DB_active_record	Database object
     */
    public function getDB($server){
        $info = $this->getAll($server);

        $config['hostname'] = $info['db_host'];
        $config['username'] = $info['db_user'];
        $config['password'] = $info['db_pass'];
        $config['database'] = $info['db_name'];
        $config['dbdriver'] = 'mysqli';
        $config['dbprefix'] = '';
        $config['pconnect'] = FALSE;
        $config['db_debug'] = TRUE;
        $config['cache_on'] = FALSE;
        $config['cachedir'] = '';
        $config['char_set'] = 'utf8';
        $config['dbcollat'] = 'utf8_general_ci';

        return $this->load->database($config, TRUE);

    }

    public function getAll($server = '')
    {
        if(isset($server) && !empty($server)){
            $query = $this->db->get_where('dc_servers', array('name' => $server, 'active' => '1'), 1);
            return $query->row_array();
        }else{
            $query = $this->db->get_where('dc_servers', array('active' => '1'));
            return $query->result_array();
        }
    }

    public function getList()
    {
        $this->db->order_by('sort', 'ASC');
        $query = $this->db->get_where('dc_servers', array('active' => '1'));
        $arr = array();
        foreach ($query->result_array() as $row)
        {
            $arr[] = $row['name'];
        }
        return $arr;
    }

    public function selectServer()
    {
        $o = '';
        $a = $this->getList();
        foreach($a as $v)
        {
            $o .= '<option value="' . $v . '" class="' . $v . '">' . $v . '</option>';
        }
        return $o;
    }

    public function selectColor($tag)
    {
        $o = '';
        $a = array(1,2,3,5,6,7,8,9,'a','b','c','d','e','f');
        foreach($a as $v)
        {
            $o .= strcasecmp($tag, $v) == 0
                ? '<option value="&' . $v . '" class="color' . $v . '" selected="selected">Color #' . $v . '</option>'
                : '<option value="&' . $v . '" class="color' . $v . '">Color #' . $v . '</option>';
        }
        return $o;
    }

    public function sendCmd($cmd, $server = 'all')
    {
        $this->load->library('rcon');
        if(!isset($server) || empty($server) || $server == 'all'){
            $query = $this->db->get_where('dc_servers', array('active' => '1'));
            foreach ($query->result_array() as $server)
            {
                if($server['maxonline'] > 0) {
                    $this->rcon->Connect($server['ip'], $server['rconport'], $server['password']);
                    $this->rcon->Command($cmd);
                    $this->rcon->Disconnect();
                }
            }
        }else{
            $info = $this->getAll($server);

            $this->load->library('rcon');
            $this->rcon->Connect($info['ip'], $info['rconport'], $info['password']);
            $this->rcon->Command($cmd);

            $this->rcon->Disconnect();
        }
    }
}