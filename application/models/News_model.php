<?php
class News_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_news($id = FALSE)
    {
        if ($id === FALSE)
        {
            $this->db->order_by('time', 'DESC');
            $query = $this->db->get_where('dc_news', array('active' => '1'));
            return array('news' => $query->result_array());
        }

        $query = $this->db->get_where('dc_news', array('id' => $id, 'active' => '1'), 1);
        if($query->num_rows() < 1) show_404();
        return $query->row_array();
    }

    public function delete($id){
        $this->db->delete('dc_news', array('id' => $id), 1);
    }

    public function createNew($id, $active, $short, $full, $author, $title, $img){
        $this->db->delete('dc_news', array('id' => $id), 1);

        $this->db->insert('dc_news', array(
            'id' => $id,
            'active' => $active,
            'short' => $short,
            'full' => $full,
            'author' => $author,
            'title' => $title,
            'img' => $img,
            'time' => time(),
        ));
    }
}