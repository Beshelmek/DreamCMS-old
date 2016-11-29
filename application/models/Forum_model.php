<?php
class Forum_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('word_helper');
    }

    public function getAllThreads()
    {
        $forum = array();
        $query = $this->db->get_where('dc_forum_category', array('active' => 1));
        $catrow = $query->result_array();

        foreach($catrow as $cat){
            $query = $this->db->get_where('dc_forum_threads', array('category' => $cat['id']));
            $threads = $query->result_array();
            foreach($threads as $thread){
                $this->db->where('thread', $thread['id']);
                $this->db->from('dc_forum_topics');
                $count = $this->db->count_all_results();
                $thread['topic_count'] = declOfNum($count, array("тема", "темы", "тем"));
                $forum[$cat['name']][] = $thread;
            }
        }

        return $forum;
    }

    public function getThread($id)
    {
        $query = $this->db->get_where('dc_forum_threads', array('active' => 1, 'id' => $id));
        $thread = $query->row_array();

        $query = $this->db->get_where('dc_forum_topics', array('thread' => $thread['id']));
        foreach($query->result_array() as $topic){
            $this->db->where('topic', $topic['id']);
            $this->db->from('dc_forum_messages');
            $count = $this->db->count_all_results();
            $topic['msg_count'] = declOfNum($count, array("сообщение", "сообщения", "сообщений"));

            if($count > 0) $thread['topics'][] = $topic;
        }

        return $thread;
    }

    public function getTopic($id)
    {
        $this->load->model('user_model', 'user');
        $query = $this->db->get_where('dc_forum_topics', array('id' => $id));
        $topic = $query->row_array();

        $topic['name'] = htmlspecialchars(trim($topic['name']));

        $query = $this->db->get_where('dc_forum_messages', array('topic' => $topic['id']));
        foreach($query->result_array() as $message){
            $message['author_l'] = $this->user->getLogin($message['author']);
            $message['message'] = htmlspecialchars(trim($message['message']));
            $topic['messages'][] = $message;
        }

        return $topic;
    }

    public function getMessage($id)
    {
        $this->load->model('user_model', 'user');
        $query = $this->db->get_where('dc_forum_messages', array('id' => $id));
        $message = $query->row_array();
        $message['author_l'] = $this->user->getLogin($message['author']);
        $message['message'] = htmlspecialchars(trim($message['message']));
        return $message;
    }

    public function getLastMessages()
    {
        $this->db->order_by('date', 'DESC');
        $query = $this->db->get_where('dc_forum_messages', array(), 5);
        $messages = $query->result_array();

        foreach ($messages as $key=>$message){
            $message['author_l'] = $this->user->getLogin($message['author']);
            $message['message'] = htmlspecialchars(trim($message['message']));
            $messages[$key] = $message;
        }

        return $messages;
    }

    public function addMessage($topic, $author, $message){
        $info = array(
            'topic' => $topic,
            'author' => $author,
            'message' => $message,
            'date' => time()
        );
        $this->db->insert('dc_forum_messages', $info);
        return $this->db->get_where('dc_forum_messages', $info)->row_array()['id'];
    }

    public function addTopic($author, $thread, $name, $message){
        $info = array(
            'thread' => $thread,
            'active' => 1,
            'author' => $author,
            'upd_author' => $author,
            'name' => $name,
            'time' => time(),
            'upd_time' => time()
        );
        $this->db->insert('dc_forum_topics', $info);
        $id = $this->db->get_where('dc_forum_topics', $info)->row_array()['id'];
        $this->addMessage($id, $author, $message);
        return $id;
    }

    public function removeMessage($id){
        $this->db->delete('dc_forum_messages', array(
            'id' => $id
        ), 1);
    }

    public function removeTopic($id){
        $this->db->delete('dc_forum_topics', array(
            'id' => $id
        ), 1);
    }

    public function openTopic($id){
        $this->db->update('dc_forum_topics', array(
            'active' => 1
        ), array(
            'id' => $id
        ), 1);
    }
    public function closeTopic($id){
        $this->db->update('dc_forum_topics', array(
            'active' => 0
        ), array(
            'id' => $id
        ), 1);
    }
}