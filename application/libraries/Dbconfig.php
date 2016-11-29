<?php

class Dbconfig {
    const TABLE = 'dc_config';

    private $data;
    private $ci;

    function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->db->order_by('sort', 'asc');
        $q = $this->ci->db->get(self::TABLE);
        foreach ($q->result() as $row)
        {
            $this->data[$row->key] = array('sort' => $row->sort, 'type' => $row->type, 'desc' => $row->desc, 'value' => json_decode($row->value, true));
        }
        $q->free_result();

    }

    function __get($key){
        if($this->data[$key]['type'] == 'option'){
            foreach ($this->data[$key]['value'] as $option){
                if($option['checked']) return $option['name'];
            }
        }
        return $this->data[$key]['value'];
    }

    function __set($key, $value){
        if (isset($this->data[$key])){
            $this->ci->db->where('key', $key);
            $this->ci->db->update(self::TABLE, array('value' => json_encode($value)));
        } else {
            //$this->ci->db->insert(self::TABLE, array('key' => $key, 'value' => json_encode($value)));
        }
        $this->data[$key] = $value;
    }

    function __isset($key) {
        return isset($this->data[$key]);
    }

    function __unset($key) {
        $this->ci->db->delete(self::TABLE, array('key' => $key));
        unset($this->data[$key]);
    }

    function toArray(){
        return $this->data;
    }
}
