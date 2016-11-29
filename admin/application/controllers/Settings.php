<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $this->tpl->compile('settings/index', array(
            'config' => $this->dbconfig->toArray()
        ));
    }

    public function create(){
        $this->tpl->compile('settings/edit', array(
            'config' => $this->dbconfig->toArray()
        ));
    }

    public function edit($action){
        if($action == 'remove'){
            $this->db->delete('dc_config', array(
                'key' => $this->input->post('key')
            ), 1);
        }elseif ($action == 'create'){
            $type = $this->input->post('type');
	     $sort = $this->input->post('sort');
            unset($_POST['json_answ']);

            if($type == 'array'){
                $_POST['value'] = json_encode(split('|', $_POST['value']));
            }
            if($type == 'option'){
            	  $options = array();
                $arr = split('<>', $_POST['value']);
                foreach($arr as $option){
                	$info = split('|', $option);
                	$options[] = array(
                		'name' => $info[0],
                		'text' => $info[1],
                		'checked' => false);
                	}
                $_POST['value'] = json_encode($options);
            }
            if($type == 'int'){
                $_POST['value'] = json_encode(0);
            }
		if($sort != -1){
			$this->db->query("UPDATE dc_config SET sort=sort+1 WHERE sort >= {$sort}");
		}else{
			unset($_POST['sort']);
		}
            $this->db->insert('dc_config', $_POST);
        }
        $this->common->showOK("Успешно!");
    }

    public function save(){
        //$this->common->showOK(print_r($_POST, true));
        //Получаем текущий конфиг
        $config = $this->dbconfig->toArray();

        //Обработка тупых чекбоксов, если их нет в массиве, значит сняли галочку
        foreach ($config as $key => $value){
            if($value['type'] == 'boolean'){
                if(!in_array($key, array_keys($_POST))) $this->dbconfig->$key = FALSE;
            }
        }

        //Обрабатываем остальные параметры
        foreach ($_POST as $key => $value){
            if($config[$key]['type'] == 'option'){
                $arr = $config[$key]['value'];
                foreach ($arr as $optkey=>$optvalue){
                    if($optvalue['name'] == $value) {
                        $optvalue['checked'] = TRUE;
                    }else{
                        $optvalue['checked'] = FALSE;
                    }
                    $arr[$optkey] = $optvalue;
                }
                $this->dbconfig->$key = $arr;
            }else{
                $this->dbconfig->$key = $value;
            }
        }
        $this->common->showOK("Настройки успешно сохранены!");
    }
}