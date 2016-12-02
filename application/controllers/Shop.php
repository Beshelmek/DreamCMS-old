<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends DCMS_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('shop_model' => 'shop', 'economy_model' => 'economy', 'cart_model' => 'cart', 'server_model' => 'server', 'page_model' => 'page', 'permissions_model' => 'permissions'));
        $this->checkAuth(true);
    }

    public function index(){
        $this->tpl->compile('static', $this->page->getPage('shop-info'), 'Информация о магазине');
    }

    public function server($shop = 'main', $id = '')
    {
        $group = $this->permissions->getMaxUserGroup($this->usergroups);
        $discount = false;

        if(isset($id) && !empty($id)){
            $item = $this->shop->getItem($id, $shop);
            if(!$item['id']){
                $this->tpl->show_404();
            }
            $this->tpl->compile('shop/buy', array('item' => $item), 'Покупка товара');
        }else{
            $items = $this->shop->getItems($shop);
            if($group == 'Ultima' || $group == 'Deluxe') {
                foreach ($items as $key => $value) {
                    if ($group == 'Ultima') {
                        $value['oldprice'] = $value['price'];
                        $value['price'] = round($value['price'] * 0.7, 2, PHP_ROUND_HALF_UP);
                        $value['olddprice'] = $value['dprice'];
                        $value['dprice'] = round($value['dprice'] * 0.7, 2, PHP_ROUND_HALF_UP);
                    } elseif ($group == 'Deluxe') {
                        $value['oldprice'] = $value['price'];
                        $value['price'] = round($value['price'] * 0.85, 2, PHP_ROUND_HALF_UP);
                        $value['olddprice'] = $value['dprice'];
                        $value['dprice'] = round($value['dprice'] * 0.85, 2, PHP_ROUND_HALF_UP);
                    }
                    $discount = true;
                    $items[$key] = $value;
                }
            }

            $this->tpl->compile('shop/list', array('items' => $items, 'shop' => $shop, 'discount' => $discount), 'Магазин блоков');
        }

    }

    public function buy(){
        $id = intval($this->input->post('id'));
        $count = intval($this->input->post('count'));
        $from = intval($this->input->post('from'));

        $item = $this->shop->getItem($id);
        if(!$item['dname']){
            $this->common->showError('Этот предмет не продается на данном сервере!');
        }

        if($count < 1 || $count > 64){
            $this->common->showError('Введите количество от 1 до 64!');
        }

        if($from < 1 || $from > 2){
            $this->common->showError('Вы не выбрали с какого кошелька платить!');
        }

        $group = $this->permissions->getMaxUserGroup($this->usergroups);

        if($from == 1){
            $price = $count * $item['price'];
            if($price <= 0){
                $this->common->showError('Цена не может быть меньше 0!');
            }

            if($group != 'Player'){
                if($group == 'Ultima'){
                    $price = round($price * 0.7, 2, PHP_ROUND_HALF_UP);
                }elseif($group == 'Deluxe'){
                    $price = round($price * 0.85, 2, PHP_ROUND_HALF_UP);
                }
            }

            if($this->economy->spendRealmoney($this->userinfo['uuid'], $price)){
                $this->cart->addItem($this->userinfo['uuid'], $item['type'], $item['damage'], $count);

                $this->logger->log('shop_buyitem', $this->userinfo['uuid'], array(
                    'item_id' => $item['type'] . '@' . $item['damage'],
                    'count' => $count,
                    'by' => 'realmoney'
                ));

                $this->common->showOk('Вы успешно приобрели этот предмет!');
            }else{
                $this->common->showError('У вас не хватает денег! Необходимо ' . $price . ' рублей');
            }
        }elseif($from == 2){
            //$this->common->showError('Покупка за дримы пока отключена!');
            $price = $count * $item['dprice'];

            if($price <= 0){
                $this->common->showError('Цена не может быть меньше 0!');
            }

            if($group != 'Player'){
                if($group == 'Ultima'){
                    $price = round($price * 0.7, 2, PHP_ROUND_HALF_UP);
                }elseif($group == 'Deluxe'){
                    $price = round($price * 0.85, 2, PHP_ROUND_HALF_UP);
                }
            }

            if($this->economy->spendMoney($this->userinfo['uuid'], $price)){
                $this->cart->addItem($this->userinfo['uuid'], $item['type'], $item['damage'], $count);

                $this->logger->log('shop_buyitem', $this->userinfo['uuid'], array(
                    'item_id' => $item['type'] . '@' . $item['damage'],
                    'count' => $count,
                    'by' => 'money'
                ));

                $this->common->showOk('Вы успешно приобрели этот предмет!');
            }else{
                $this->common->showError('У вас не хватает денег! Необходимо ' . $price . ' дримов');
            }
        }
    }

}