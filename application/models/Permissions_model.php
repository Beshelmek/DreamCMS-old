<?php
class Permissions_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function canSetPrefix($uuid, $server)
    {
        $q = $this->db->get_where('dc_usergroups', array('uuid' => $uuid, 'group' => 'Deluxe', 'server' => $server), 1);
        if($q->num_rows() > 0){
            return TRUE;
        }
        $q = $this->db->get_where('dc_usergroups', array('uuid' => $uuid, 'group' => 'Ultima', 'server' => $server), 1);
        if($q->num_rows() > 0){
            return TRUE;
        }
        return FALSE;
    }

    public function canSetMsgColor($uuid, $server)
    {
        $q = $this->db->get_where('dc_usergroups', array('uuid' => $uuid, 'group' => 'Ultima', 'server' => $server), 1);
        if($q->num_rows() > 0){
            return TRUE;
        }
        return FALSE;
    }

    public function getMaxUserGroup($usergroups)
    {
        $maxgroup = "Player";
        foreach ($usergroups as $row)
        {
            if($row['group'] == 'Ultima'){
                return 'Ultima';
            }
            if($row['group'] == 'Deluxe'){
                $maxgroup = 'Deluxe';
            }
            if($row['group'] == 'Premium' && $maxgroup != 'Deluxe'){
                $maxgroup = 'Premium';
            }
            if($row['group'] == 'VIP' && $maxgroup != 'Premium' && $maxgroup != 'Deluxe'){
                $maxgroup = 'VIP';
            }
        }

        return $maxgroup;
    }

    public function getMaxGroup($uuid)
    {
        $q = $this->db->get_where('dc_usergroups', array('uuid' => $uuid));

        if($q->num_rows() < 1){
            return 'Player';
        }

        $maxgroup = 'VIP';

        foreach ($q->result_array() as $row)
        {
            if($row['group'] == 'Ultima'){
                return 'Ultima';
            }
            if($row['group'] == 'Deluxe'){
                $maxgroup = 'Deluxe';
            }
            if($row['group'] == 'Premium' && $maxgroup != 'Deluxe'){
                $maxgroup = 'Premium';
            }
            if($row['group'] == 'VIP' && $maxgroup != 'Premium' && $maxgroup != 'Deluxe'){
                $maxgroup = 'VIP';
            }
        }

        return $maxgroup;
    }

    public function addPermToGroup($server, $group, $perm)
    {
        $arr = array(
            'name' => strtolower($group),
            'type' => 0,
            'permission' => $perm,
            'world' => '',
            'value' => ''
        );

        $this->db->insert('permissions', $arr);

        $q = $this->db->get('permissions', $arr, 1);
        return $q->row_array()['id'];
    }

    public function getAll($server = FALSE){
        if($server){
            $this->db->where('type', 0);
            $query = $this->db->get('permissions');
            return $query->result_array();
        }else{
            $arr = array();
            foreach($this->server->getAll() as $server){
                $this->db->where('type', 0);
                $query = $this->db->get('permissions');
                $arr[$server['name']] = $query->result_array();
                return $arr;
            }
        }
    }

    /*public function sync(){
        $maindb = 'hitech';
        $dbs = array('magicrpg', 'spellfull', 'technomagic', 'pixelmon');
        $config = $this->getConfig();
        $pexlist = array();

        $config['database'] = $maindb;
        $pex = $this->load->database($config, TRUE);

        $q = $pex->get_where('permissions', array('type' => 0));

        foreach ($q->result_array() as $item) {
            unset($item['id']);
            $pexlist['permissions'][] = $item;
        }

        $q = $pex->get_where('permissions_entity', array('type' => 0));

        foreach ($q->result_array() as $item) {
            unset($item['id']);
            $pexlist['permissions_entity'][] = $item;
        }

        $q = $pex->get_where('permissions_inheritance', array('type' => 0));

        foreach ($q->result_array() as $item) {
            unset($item['id']);
            $pexlist['permissions_inheritance'][] = $item;
        }

        foreach($dbs as $dbserver){
            $config['database'] = $dbserver;
            $tempdb = $this->load->database($config, TRUE);

            $tempdb->delete('permissions', array('type' => 0));
            $tempdb->delete('permissions_entity', array('type' => 0));
            $tempdb->delete('permissions_inheritance', array('type' => 0));

            foreach($pexlist['permissions'] as $item){
                $tempdb->insert('permissions', $item);
            }
            foreach($pexlist['permissions_entity'] as $item){
                $tempdb->insert('permissions_entity', $item);
            }
            foreach($pexlist['permissions_inheritance'] as $item){
                $tempdb->insert('permissions_inheritance', $item);
            }

            $q = $tempdb->get_where('permissions_inheritance', array('type' => 1));

            foreach ($q->result_array() as $item) {
                if($item['parent'] == 'vip' || $item['parent'] == 'premium' || $item['parent'] == 'deluxe' || $item['parent'] == 'ultima') {
                    $g = $this->db->get_where('dc_usergroups', array('server' => $dbserver, 'uuid' => $item['child'], 'group' => $item['parent']), 1);
                    if($g->num_rows() < 1){
                        $tempdb->delete('permissions_inheritance', $item);
                        print_r($item);
                    }
                }
            }
        }
    }*/

    public function removePermFromGroup($id, $server)
    {
        $this->db->delete('permissions', array('id' => intval($id)), 1);
    }


}