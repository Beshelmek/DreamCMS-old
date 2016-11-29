<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends DCMS_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('shop_model' => 'shop', 'cart_model' => 'cart', 'server_model' => 'server', 'page_model' => 'page'));
        $this->checkAuth(true);
    }

    public function index(){
        $items = $this->cart->getItems($this->userinfo['uuid']);
        $this->tpl->compile('shop/cart', array('items' => $items), 'Корзина');
    }

    public function server($server = 'main')
    {
        $this->index();
    }
}