<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends DCMS_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('page_model', 'page');
	}


	public function view($id)
	{
		$page = $this->page->getPage($id);

		if($page['parametered']){
			$params = $this->getParameters();
			foreach($params as $param){
				$page['short'] = str_replace($param[0], $param[1], $page['short']);
			}
		}

		$this->tpl->compile('static', $page, $page['title']);
	}

	private function getParameters(){
		return array(
			array('{groups_table}', $this->genTableGroups()),
			array('{login}', (!isset($this->userinfo['login']) || empty($this->userinfo['login']))?'гость':$this->userinfo['login'])
		);
	}

	private function genTableGroups(){
		$this->load->model('groups_model', 'groups');

		$garr = $this->groups->getAllArr();
		$parr = $this->groups->getAllPermissions();

		$content = '<table class="features-table">
    <thead>
        <tr>
            <td></td>';

		foreach($garr as $group){
			$content .= '<td>'.$group['name'].'</td>';
		}

		$content .= '</tr>
    </thead>
    <tfoot>
        <tr>
            <td></td>';

		foreach($garr as $group){
			$content .= '<td>'.$group['price'].' р.</td>';
		}

		$content .= '</tr>
    </tfoot>
    <tbody>';

		foreach($parr as $key=>$value){

			$content .= '<tr>
            <td>'.str_replace('{text}', '', $value).'</td>';

			foreach($garr as $group){
				$pexgroup = json_decode($group['permissions'], true);
				if(substr_count($value, '{text}')){
						$content .= '<td>'.$pexgroup[$key].'</td>';
				}else{
					if(isset($pexgroup[$key]) && $pexgroup[$key]){
						$content .= '<td><img src="/assets/img/yes.png" width="16" height="16" alt="check"></td>';
					}else{
						$content .= '<td><img src="/assets/img/no.png" width="16" height="16" alt="check"></td>';
					}
				}
			}

			$content .= '</tr>';

		}

		$content .= '</tbody>
</table>';

		return $content;
	}
}
