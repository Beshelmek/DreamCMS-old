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
        $discount = false;

        if(isset($id) && !empty($id)){
            $item = $this->shop->getItem($id, $shop);
            if(!$item['id']){
                $this->tpl->show_404();
            }
            $this->load->view($this->dbconfig->template . '/pattern/shop/buy', array('item' => $item));
        }else{
            $items = $this->shop->getItems($shop);

            $dis15 = $this->permissions->hasPerm($this->userinfo['uuid'], 'dc.shop.discount.15');
            $dis30 = $this->permissions->hasPerm($this->userinfo['uuid'], 'dc.shop.discount.30');
            if($dis15 || $dis30) $discount = true;

            foreach ($items as $key => $item) {
                if($item['discount'] > 0){
                    $ratio = (100 - $item['discount'])/100;

                    $item['oldprice'] = $item['price'];
                    $item['price'] = round($item['price'] * $ratio, 2, PHP_ROUND_HALF_UP);
                    $item['olddprice'] = $item['dprice'];
                    $item['dprice'] = round($item['dprice'] * $ratio, 2, PHP_ROUND_HALF_UP);
                }else{
                    if($dis30 || $dis15){
                        $item['oldprice'] = $item['price'];
                        $item['olddprice'] = $item['dprice'];
                        if ($dis30) {
                            $item['price'] = round($item['price'] * 0.7, 2, PHP_ROUND_HALF_UP);
                            $item['dprice'] = round($item['dprice'] * 0.7, 2, PHP_ROUND_HALF_UP);
                        } elseif ($dis15) {
                            $item['price'] = round($item['price'] * 0.85, 2, PHP_ROUND_HALF_UP);
                            $item['dprice'] = round($item['dprice'] * 0.85, 2, PHP_ROUND_HALF_UP);
                        }
                    }
                }
                $items[$key] = $item;
            }

            $this->tpl->compile('shop/list', array('items' => $items, 'shop' => $shop, 'discount' => $discount), 'Магазин блоков');
        }

    }

    public function buy(){
        $id = intval($this->input->post('id'));
        $count = intval($this->input->post('count'));
        $from = intval($this->input->post('from'));
        $shop = $this->input->post('shop');

        $item = $this->shop->getItem($id, $shop);
        if(!isset($item['type']) || empty($item['type'])){
            $this->common->showError('Этот предмет не продается на данном сервере!');
        }

        if($count < 1 || $count > 64){
            $this->common->showError('Введите количество от 1 до 64!');
        }

        switch ($from) {
            case 1:
                $price = $count * $item['price'];
                break;
            case 2:
                $price = $count * $item['dprice'];
                break;
            default:
                $price = 0;
                $this->common->showError('Вы не выбрали с какого кошелька платить!');
                break;
        }

        if($price <= 0){
            $this->common->showError('Цена не может быть меньше 0!');
        }

        if($item['discount'] > 0){
            $ratio = (100 - $item['discount'])/100;
            $price = round($price * $ratio, 2, PHP_ROUND_HALF_UP);
        }else{
            $dis15 = $this->permissions->hasPerm($this->userinfo['uuid'], 'dc.shop.discount.15');
            $dis30 = $this->permissions->hasPerm($this->userinfo['uuid'], 'dc.shop.discount.30');
            if($dis30 || $dis15){
                if($dis15){
                    $price = round($price * 0.85, 2, PHP_ROUND_HALF_UP);
                }elseif ($dis30){
                    $price = round($price * 0.7, 2, PHP_ROUND_HALF_UP);
                }
            }
        }

        if($from == 1 && $this->economy->spendRealmoney($this->userinfo['uuid'], $price)){
            $this->cart->addItem($this->userinfo['uuid'], $item['type'], $item['damage'], $count);

            $this->logger->log('shop_buyitem', $this->userinfo['uuid'], array(
                'item_id' => $item['type'] . '@' . $item['damage'],
                'count' => $count,
                'by' => 'realmoney'
            ));

            $this->common->showOk('Вы успешно приобрели этот предмет!');
        }elseif ($from == 2 && $this->economy->spendMoney($this->userinfo['uuid'], $price)){
            $this->cart->addItem($this->userinfo['uuid'], $item['type'], $item['damage'], $count);

            $this->logger->log('shop_buyitem', $this->userinfo['uuid'], array(
                'item_id' => $item['type'] . '@' . $item['damage'],
                'count' => $count,
                'by' => 'money'
            ));

            $this->common->showOk('Вы успешно приобрели этот предмет!');
        }else{
            $this->common->showError('У вас не хватает денег! Необходимо ' . $price  . ' ' . ($from == 1 ? 'рублей' : 'монет'));
        }

        $this->common->showError('Что-то пошло не так :(');
    }

}