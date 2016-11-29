<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends DCMS_Controller {

	public function __construct()
	{
        parent::__construct();
		$this->load->model('news_model', 'news');
	}

	public function index()
	{
		$news = $this->news->get_news();
		$this->tpl->compile('news/short', $news, 'Новости');
	}

	public function view($id = '')
	{
		if(empty($id))$this->index();
		$news = $this->news->get_news($id);
		$this->tpl->compile('news/full', $news, 'Полная новость');
	}
}
