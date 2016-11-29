<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Region_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getRegionByName($server, $region, $world){
        $sdb = $this->server->getDB($server);

        $sdb->select('*');
        $sdb->from('wg_region');
        $sdb->where(array(
            'wg_region.id' => $region,
            'wg_region.world_id' => $world
        ));

        $sdb->join('wg_region_cuboid', 'wg_region_cuboid.region_id = wg_region.id AND wg_region_cuboid.world_id = wg_region.world_id');
        $info = $sdb->get()->row_array();

        $info['flags'] = $sdb->get_where('wg_region_flag', array(
            'region_id' => $info['id']
        ))->result_array();

        /*$info['users'] = $sdb->get_where('wg_region_players', array(
            'region_id' => $info['id']
        ))->result_array();*/

        $sdb->select('*');
        $sdb->from('wg_region_players');
        $sdb->where(array(
            'wg_region_players.region_id' => $info['id']
        ));
        $sdb->join('wg_user', 'wg_user.id = wg_region_players.user_id');
        $info['users'] = $sdb->get()->result_array();

        echo "<pre>";
        print_r($info);
        echo "</pre>";
        die();
    }

    private function userIDtoUUID($sdb, $userid){
        $uuid = $sdb->get_where('wg_user', array(
            'id' => $userid
        ))->row_array()['uuid'];
        return $uuid;
    }

}