<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cases extends DCMS_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('economy_model', 'economy');
    }

    public function index(){
        $this->tpl->compile('cases/index', array(), 'Кейсы');
    }

    public function buy(){
        $this->checkAuth(true);

        $cases = array(1 => 20, 2 => 45, 9000 => 10);
        $id = intval($this->input->post('id'));

        if(isset($cases[$id]) && $cases[$id] > 0){
            $price = $cases[$id];
            if($this->economy->spendRealmoney($this->userinfo['uuid'], $price)){
                $arr = $this->db->get_where('dc_box', array(
                    'uuid' => $this->userinfo['uuid'],
                    'box' => $id
                ))->row_array();
                if(isset($arr) && isset($arr['count'])){
                    $count = intval($arr['count']);
                    $this->db->update('dc_box', array(
                        'count' => $count + 1
                    ), array(
                        'uuid' => $this->userinfo['uuid'],
                        'box' => $id)
                    , 1);
                }else{
                    $this->db->insert('dc_box', array(
                        'uuid' => $this->userinfo['uuid'],
                        'box' => $id,
                        'count' => 1
                    ));
                }
                $this->common->showOK('Вы успешно приобрели этот кейс!');
            }else{
                $this->common->showError('У вас недостаточно средств!');
            }
        }else{
            $this->common->showError('Этот кейс ['.$id.'] временно не продается!');
        }
    }

}