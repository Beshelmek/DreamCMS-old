<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Telegram extends CI_Controller {

    private $superAdmin = 232754916;

    private $accessID = array(
        232754916, 292645746, 220065433, 292877986, 1707549, 279635556, 260674019
    );

    private $chatID = -1001087692720;

    private $arrhelp = array(
        '/online' => 'Показать онлайн на всех серверах',
        '/forum' => 'Последние сообщения с форума',
        '/list [server]' => 'Показать список игроков на определенном сервере',
        '/finditem [FIND]' => 'Показать все предметы которые содержат "FIND" в названии',
        '/uuid [nickname]' => 'Получить UUID игрока',
        '/cmd [server\all] [cmd]' => 'Выполнить команду "cmd" на сервере "server" или на всех ("аll")',
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('telegram_model', 'telegram');
    }

    public function index(){
        if(!$this->telegram->text_contains('/')){
            return;
        }

        if(!in_array($this->telegram->user->id, $this->accessID)){
            $this->telegram->send->text("У вас нет доступа к боту! Сообщите Ваш ID [{$this->telegram->user->id}] администратору!")->send();
            return;
        }

        if($this->telegram->text_command("online")){
            $servers = $this->server->getAll();
            $message[] = 'Текущий онлайн:';
            $message[] = ' ';

            $online = 0;
            $maxonline = 0;

            foreach ($servers as $server){
                $online += $server['online'];
                $maxonline += $server['maxonline'];
                $message[] = $server['name'] . ' ' . $server['online'] . '/' . $server['maxonline'];
            }
            $message[] = ' ';
            $message[] = 'Общий онлайн: ' . $online . '/' . $maxonline;
            $this->telegram->send->text($message)->notification(FALSE)->send();
        }

        if($this->telegram->text_command("forum")){
            $this->load->model('forum_model', 'forum');
            $messages = $this->forum->getLastMessages();

            $message[] = 'Последние сообщения с форума:';
            $message[] = ' ';

            foreach ($messages as $msg){
                $message[] = ' ';
                $topic = $this->forum->getTopic($msg['topic']);
                $message[] = '<b>' . $msg['author_l'] . ' в </b><a href="https://dreamcraft.su/forum/topic/'.$msg['topic'].'">' .$topic['name'] . '</a>: ';
                $message[] = $msg['message'];
            }
            $this->telegram->send->text($message, 'HTML')->notification(FALSE)->disable_web_page_preview(TRUE)->send();
        }

        if($this->telegram->text_command("list")){
            $this->load->library('query');
            $server = $this->server->getAll($this->telegram->words(1));

            if(!$server){
                $this->telegram->send->text('Такого сервера нет!')->notification(FALSE)->send();
                return;
            }

            $message[] = 'Игроки на сервере ' . $server['name'] . ':';
            $message[] = ' ';

            $Query = new Query();
            try
            {
                $Query->Connect('localhost', intval($server['port']));
                foreach ($Query->GetPlayers() as $player){
                    $message[] = $player;
                }
                $this->telegram->send->text($message)->notification(FALSE)->send();
            }
            catch( MinecraftQueryException $e )
            {
                $this->telegram->send->text('Сервер недоступен!')->notification(FALSE)->disable_web_page_preview(TRUE)->send();
            }
        }

        if($this->telegram->text_command("finditem")){
            $keyword = $this->telegram->words(1);
            $this->db->like('dname', $keyword);
            $items = $this->db->get('dc_shop_items')->result_array();

            $message[] = 'По вашему запросу найдено:';
            $message[] = ' ';

            foreach ($items as $item){
                $message[] = $item['dname'] . ' - ' . $item['type'] . ' [' . $item['damage'] . ']';
            }
            $this->telegram->send->text($message)->notification(FALSE)->send();
        }

        if($this->telegram->text_command("uuid")){
            $user = $this->user->getAll($this->telegram->words(1));

            $message[] = 'UUID игрока '.$user['login'].':';
            $message[] = $user['uuid'];

            $this->telegram->send->text($message)->notification(FALSE)->send();
        }

        if($this->telegram->text_command("cmd")){
            if($this->telegram->user->id != $this->superAdmin){
                $this->telegram->send->text("Недостаточно прав!")->send();
                return;
            }

            $server = $this->telegram->words(1);
            $command = trim(str_replace('/cmd', '', str_replace($server, '', $this->telegram->text())));

            if(empty($server) || empty($command)){
                $this->telegram->send->text("Введены не все данные! " . $server . ':' . $command)->send();
                return;
            }

            $this->server->sendCmd($command, $server);

            $this->telegram->send->text('Команда ['.$command.'] исполнена!')->notification(FALSE)->send();
        }

        if($this->telegram->text_command("help")){
            $message[] = 'Помощь по командам:';
            $message[] = ' ';
            foreach ($this->arrhelp as $cmd=>$desc){
                $message[] = '<b>' . $cmd . '</b> - ' . $desc . '';
            }
            $this->telegram->send->text($message, 'HTML')->send();
        }

        $message[] = ' ';
        $message[] = 'Введена команда: ' . $this->telegram->text();
        $message[] = 'Пользователь [' . $this->telegram->user->id . ']: ' . $this->telegram->user->first_name . ' ' . $this->telegram->user->last_name;
        $this->telegram->send->chat($this->superAdmin)->notification(FALSE)->text($message)->send();
    }
}