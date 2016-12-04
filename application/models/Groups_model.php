<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Groups_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('server_model' => 'server'));
    }

    public function getAllArr(){
        $query = $this->db->get_where('dc_groups', array('active' => '1'));
        return $query->result_array();
    }

    public function getOrderGroups(){
        $query = $this->db->get_where('dc_groups', array('active' => 1, 'order' => 1, 'price >' => 0));
        return $query->result_array();
    }

    public function getAllPermissions(){
        return array(
            'wg_regions' => 'Кол-во приватов {text}',
            'quarry_limit' => '[HiTech] Ограничение карьера {text}',
            'laser_limit' => '[HiTech] Ограничение лазера {text}',
            'rc_loader' => '[HiTech] Мировой якорь {text}',
            'save_inv' => 'Сохранение инвентаря',
            'save_exp' => 'Сохранение опыта после смерти',
            'full_join' => 'Вход на полный сервер',
            'back_cmd' => 'Место смерти: /back',
            'heal_cmd' => 'Вылечить себя: /heal',
            'near_cmd' => 'Игроки рядом: /near',
            'firework_cmd' => 'Запустить фейерверк: /firework',
            'repair_cmd' => 'Починить предмет: /repair',
            'tpahere_cmd' => 'Телепорт к себе /tpahere [НИК]',
            'fly_cmd' => 'Режим полёта: /fly',
            'feed_cmd' => 'Накормить себя: /feed',
            'kit_vip' => 'Пакет ресурсов VIP (раз в месяц)',
            'kit_build' => 'Пакет ресурсов Build (раз в день)',
            'hd_cloak' => 'Установка HD плаща',
            'color_sign' => 'Цветные буквы на табличках)',
            'getpos_cmd' => 'Место нахождения: /getpos',
            'kit_premium' => 'Пакет ресурсов Premium (раз в месяц)',
            'kit_eggs' => 'Пакет ресурсов Eggs (раз в день)',
            'clear_cmd' => 'Очистить свой инвентарь: /clear',
            'ptime_cmd' => 'Персональное время: /ptime',
            'enderchest_cmd' => 'Эндер сундук: /enderchest',
            'god_cmd' => 'Использовать режим бессмертия: /god',
            'hat_cmd' => 'Надеть блок на голову: /hat',
            'ext_cmd' => 'Потушить себя: /ext',
            'chat_color' => 'Цветной чат',
            'kit_deluxe' => 'Пакет ресурсов Deluxe (раз в месяц)',
            'kit_adv' => 'Пакет ресурсов Adv (раз в неделю)',
            'kit_exp' => 'Пакет ресурсов Exp (раз в день)',
            'tppos_cmd' => 'Телепорт по координатам: /tppos x y z',
            'warp_free' => 'Установка бесплатного варпа',
            'char_prefcolor' => 'Сменить цвет префикса',
            'chat_msgcolor' => 'Сменить цвет сообщения',
            'uncraft_table' => '[Spellfull] Стол раскрафта',
            'shop_15discount' => 'Скидка в онлайн-магазине: 15%',
            'pweather_cmd' => 'Установка личной погоды: /pweather',
            'speed_cmd' => 'Установка скорости полёта: /speed 1-10',
            'marker_allowed' => '[HiTech] Использование меткок (карьер)',
            'drillsetup_limit' => '[HiTech] Безлимитные бур. установки',
            'armor_table' => '[Spellfull] Стол наполнения доспехов',
            'uncraft_table2' => '[Spellfull] Тайный реконструктор',
            'mana_pool' => '[Spellfull] Бесконечный бассейн маны',
            'death_arm' => '[Spellfull] Рука смерти',
            'shop_30discount' => 'Скидка в онлайн-магазине: 30%',
        );
    }

    public function getAll($servers){
        $query = $this->db->get_where('dc_groups', array('active' => '1'));
        $arr = $query->result_array();
        foreach($arr as $key => $value){
            $value['servers'] = $servers;
            $arr[$key] = $value;
        }
        return array('groups' => $arr);
    }

    public function getInfo($name){
        $query = $this->db->get_where('dc_groups', array('name' => $name, 'active' => '1'), 1);
        return $query->row_array();
    }

    public function addUserGroupDirect($uuid, $group, $expire, $server = 'all'){
        $this->db->insert('permissions_inheritance', array(
            'child' => $uuid,
            'parent' => strtolower($group),
            'type' => 1,
        ));
        if($expire > 0){
            $data = array(
                'uuid' => $uuid,
                'group' => strtolower($group),
                'server' => $server,
                'time' => time(),
                'expire' => $expire
            );
            $this->db->insert('dc_usergroups', $data);

            $this->db->insert('permissions', array(
                'name' => $uuid,
                'type' => 1,
                'permission' => 'group-'.strtolower($group).'-until',
                'world' => '',
                'value' => $expire
            ));
        }
    }

    public function clearUserGroups($uuid){
        $this->db->delete('permissions_inheritance', array(
            'child' => $uuid,
            'type' => 1
        ));
        $this->db->delete('permissions', array(
            'name' => $uuid,
            'type' => 1
        ));
    }

    public function syncperm(){
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

    public function addUserToGroup($server, $uuid, $group){
        $data = array(
            'uuid' => $uuid,
            'group' => $group['name'],
            'server' => $server,
            'time' => time(),
            'expire' => (time() + $group['expire'])
        );

        $this->clearGroups($server, $uuid);

        $this->db->insert('dc_usergroups', $data);

        $this->syncperm();
    }

    public function clearGroups($server, $uuid){
        $this->db->delete('dc_usergroups', array('uuid' => $uuid));
        $this->server->sendCmd('pex user ' . $uuid . ' delete', $server);
        $this->server->sendCmd('pex user ' . $uuid . ' group set default', $server);
    }

    public function allGroups($uuid){
        $query = $this->db->get_where('dc_usergroups', array('uuid' => $uuid));
        return $query->result_array();
    }

    public function checkExpire(){
        $query = $this->db->get_where('dc_usergroups', array('expire <' => time()));
        $rarr = array();
        foreach($query->result_array() as $arr){
            $rarr[] = array('uuid' => $arr['uuid'], 'group' => $arr['group'], 'server' => $arr['server']);
            $this->clearGroups($arr['server'], $arr['uuid']);
        }
        return $rarr;
    }

    public function save($arr){
        print_r($arr);
    }
}