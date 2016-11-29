<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends Admin_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('page_model', 'page');
	}

	public function index()
	{
		$page = $this->page->getAll();
		$this->tpl->compile('page/list', array('pages' => $page), 'Страницы');
	}

	public function create()
	{
		$this->tpl->compile('page/create', array(), 'Страницы');
	}

	public function edit($id)
	{
		$this->tpl->compile('page/edit', array('page' => $this->page->getPage($id)), 'Страницы');
	}

	public function delete($id)
	{
		$this->page->delete($id);
		$this->tpl->compile('success', array('msg' => 'Страница удалена!', 'url' => 'page'), 'Успешно');
	}

	public function save(){
		$this->page->createNew($this->input->post('id'), $this->input->post('title'), $this->input->post('short'), $this->input->post('parametered'));
		$this->tpl->compile('success', array('msg' => 'Страница создана\обновлена!', 'url' => 'page'), 'Успешно');
	}
}
