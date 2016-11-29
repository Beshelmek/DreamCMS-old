<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum extends DCMS_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth_model', 'auth');
        $this->load->model('forum_model', 'forum');
        $this->checkAuth(true);
    }

    public function index(){
        $threads = $this->forum->getAllThreads();
        $this->tpl->compile('forum/index', array('threads' => $threads), 'Форум');
    }

    public function thread($id){
        $thread = $this->forum->getThread($id);
        $this->tpl->compile('forum/thread', array('thread' => $thread), 'Форум >> Тема "' . $thread['name'] . '"');
    }

    public function topic($id, $action = ''){
        $topic = $this->forum->getTopic($id);

        if($action == 'delete' && ($this->isAdmin() || $topic['author'] == $this->userinfo['uuid'])){
            $this->forum->removeTopic($id);
            $this->common->showOK('Удалено!');
        }
        if($action == 'close' && $this->isAdmin()){
            $this->forum->closeTopic($id);
            $this->common->showOK('Топик закрыт!');
        }
        if($action == 'open' && $this->isAdmin()){
            $this->forum->openTopic($id);
            $this->common->showOK('Топик открыт!');
        }

        $this->tpl->compile('forum/topic', array('topic' => $topic), 'Форум >> Топик "' . $topic['name'] . '"');
    }

    public function create_topic($id){
        $message = $this->input->post('message');

        if($message){
            $name = $this->input->post('name');

            if(mb_strlen($message,'UTF-8') < 3){
                $this->common->showError('Длинна сообщения не может быть меньше 3 символов!');
            }

            if(mb_strlen($name,'UTF-8') < 3){
                $this->common->showError('Длинна имени топика не может быть меньше 3 символов!');
            }

            $id = $this->forum->addTopic($this->userinfo['uuid'], $id, $name, $message);
            $this->common->showOK('Вы успешно создали топик!', array(
                'redirect' => '/forum/topic/' . $id
            ));
        }

        $thread = $this->forum->getThread($id);
        $this->tpl->compile('forum/create_topic', array('thread' => $thread), 'Форум >> Создание топика');
    }

    public function delete($type){
        if($type == 'message'){
            $id = intval($this->input->post('message_id'));
            if(($this->forum->getMessage($id)['author'] == $this->userinfo['uuid']) || $this->isAdmin()){
                $this->forum->removeMessage($id);
                $this->common->showOK('Сообщение удалено!', array(
                    'execute' => '$("#comment_' . $id .'").slideUp("slow");'
                ));
            }else{
                $this->common->showError('У вас нет прав!');
            }
        }
    }

    public function message($id){
        $message = $this->input->post('message');

        if(mb_strlen($message,'UTF-8') < 3){
            $this->common->showError('Длинна сообщения не может быть меньше 3 символов!');
        }

        $id = $this->forum->addMessage($id, $this->userinfo['uuid'], $message);
        $this->common->showOK('Сообщение добавлено!', array(
            'execute' => "addForumMessage('".$id."','" . $this->userinfo['login'] . "', '" . date("d.m.Y в H:i:s") . "', '".$this->input->post('message')."');"
        ));
    }
}