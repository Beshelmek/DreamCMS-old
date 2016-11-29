<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('news_model', 'news');
    }

	public function index()
	{
		$news = $this->news->get_news();
        $this->tpl->compile('news/list', $news, 'Новости');
	}

	public function edit($id = '')
	{
		if(empty($id))$this->index();
		$news = $this->news->get_news($id);
		$this->tpl->compile('news/edit', $news, 'Редактировать новость');
	}

	public function create(){
		$this->tpl->compile('news/create', array(), 'Создать новость');
	}

	public function delete($id){
		$this->news->delete($id);
		$this->tpl->compile('success', array('msg' => 'Новость удалена!'), 'Успешно');
	}

	public function save(){
		$this->news->createNew($this->input->post('id'), $this->input->post('active'), $this->input->post('short'), $this->input->post('full'), $this->common->getLogin(), $this->input->post('title'), $this->input->post('img'));
		$this->tpl->compile('success', array('msg' => 'Новость создана!'), 'Успешно');
	}
}
