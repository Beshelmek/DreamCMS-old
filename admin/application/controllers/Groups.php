<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('groups_model', 'groups');
    }

    public function index()
    {
        $this->tpl->compile('groups/index', array('table' => $this->genTableGroups()), 'Донат группы');
    }

    public function save(){
        $this->groups->save($this->input->post());
        $this->tpl->compile('success', array('msg' => 'Донат группы обновлены!', 'url' => 'groups'), 'Изменение донат групп');
    }

    private function genTableGroups(){
        $this->load->model('groups_model', 'groups');

        $garr = $this->groups->getOrderGroups();
        $parr = $this->groups->getAllPermissions();

        $content = '
<div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Донат группы</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <table class="table table-bordered">
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
            $content .= '<td><input class="form-control" type="text" value="'.$group['price'].'" name="'.strtolower($group['name']).':price'.'"></td>';
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
                    $content .= '<td><input class="form-control" type="text" value="'.$pexgroup[$key].'" name="'.strtolower($group['name']).':'.$key.'"></td>';
                }else{
                    if(isset($pexgroup[$key]) && $pexgroup[$key]){
                        $content .= '<td><input type="checkbox" name="'.strtolower($group['name']).'[]" value="'.strtolower($group['name']).':'.$key.'" checked></td>';
                    }else{
                        $content .= '<td><input type="checkbox" name="'.strtolower($group['name']).'[]" value="'.strtolower($group['name']).':'.$key.'"></td>';
                    }
                }
            }

            $content .= '</tr>';

        }

        $content .= '</tbody>
</table></div></div>';

        return $content;
    }

}
