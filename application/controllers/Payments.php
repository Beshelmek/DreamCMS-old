<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('economy_model', 'economy');
    }

    public function success(){
        $this->tpl->compile('success', array('msg' => 'Ваш счет успешно пополнен!'), 'Пополнение счета');
    }

    private function getSignature($method, $params, $secretKey) {
        ksort($params);
        unset($params['sign']);
        unset($params['signature']);
        array_push($params, $secretKey);
        array_unshift($params, $method);

        return hash('sha256', join('{up}', $params));
    }

    public function unitpay(){
        $request = $_GET;
        $method = $request['method'];
        $params = $request['params'];
        $secretKey = 'ab700a2bd1fad936b26cb82a2a95c0a5';

        if(!in_array($this->input->ip_address(), array(
            "31.186.100.49", "178.132.203.105", "52.29.152.23", "52.19.56.234"
        ))){
            exit(json_encode(array('error'=>array('message' => 'Поддельный IP адрес!'))));
        }

        $sign = $params['signature'];

        if($sign !== $this->getSignature($method, $params, $secretKey)){
            exit(json_encode(array('error'=>array('message' => 'Неверная подпись!'))));
        }

        if (empty($request['method']) || empty($request['params']) || !is_array($request['params']))
        {
            exit(json_encode(array('error'=>array('message' => 'Неверные параметры!'))));
        }

        if($method == 'check'){
            exit(json_encode(array('result'=>array('message' => 'Успешная проверка!'))));
        }else if($method == 'pay') {
            $this->economy->addRealMoney($params['account'], intval($params['sum']));
            $this->logger->log('unitpay_add', $params['account'], $params);
            $this->addRefBonus($params['account'], intval($params['sum']));
            exit(json_encode(array('result'=>array('message' => 'Успешно!'))));
        }else{
            exit(json_encode(array('error'=>array('message' => 'Неизвестный метод!'))));
        }
    }

    private function addRefBonus($user, $count){
        $user = $this->user->getAll($user)['byurl'];
        if(isset($user) && !empty($user)){
            $this->economy->addRealMoney($user, round($count * 0.15));
        }
    }
}