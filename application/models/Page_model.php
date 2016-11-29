<?php
class Page_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(){
        $query = $this->db->get('dc_articles');
        return $query->result_array();
    }

    public function getPage($id = FALSE)
    {
        $query = $this->db->get_where('dc_articles', array('id' => $id), 1);
        if($query->num_rows() < 1) show_404();
        return $query->row_array();
    }

    public function delete($id){
        $this->db->delete('dc_articles', array('id' => $id), 1);
    }

    public function createNew($url, $title, $short, $param = 0){
        $this->db->delete('dc_articles', array('id' => $url), 1);

        $data = array(
            'id' => $url,
            'title' => $title,
            'short' => $short,
            'time' => time(),
            'parametered' => $param
        );

        $this->db->insert('dc_articles', $data);
    }
}