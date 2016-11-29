<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tpl {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('server_model', 'server');
    }

    public function compile($name, $data = array(), $stitle = 'DreamCraft.Su')
    {
        $data['stitle'] = $stitle;
        $data['login'] = $this->CI->common->getLogin();
        $data['uuid'] = $this->CI->common->getUUID();
        $data['logged'] = $this->CI->common->isLogged();
        $data['money'] = $this->CI->common->getMoney();
        $data['realmoney'] = $this->CI->common->getRealMoney();
        $data['monitoring'] = $this->genMonitor();
        $data['isadmin'] = in_array($data['uuid'], $this->CI->dbconfig->admins);
        $data['meta'] = array(
            'description' => 'Комплекс Minecraft серверов без вайпов с минимальными ограничениями для тебя! Начни играть прямо сейчас!',
            'keywords' => 'Minecraft, Minecraft проект, майнкрафт проект, играть в майнкрафт, комплекс майнкрафт, комплекс серверов, Minecraft, Minecraft сервер, майнкрафт сервер, играть на проекте майнкрафта, дримкрафт, дреамкрафт, dreamcraft',
            'generator' => 'DreamWebEngineV2'
        );
        $data['csrf'] = array(
            'name' => $this->CI->security->get_csrf_token_name(),
            'hash' => $this->CI->security->get_csrf_hash()
        );
        $data['fcsrf'] = '<input type="hidden" name="'.$data['csrf']['name'].'" value="'.$data['csrf']['hash'].'"/>';
        $data['color_opt']   = $this->CI->server->selectColor('f');
        $data['server_opt']  = $this->CI->server->selectServer();
        $this->CI->load->view('header', $data);
        $this->CI->load->view($name,    $data);
        $this->CI->load->view('footer', $data);
    }

    public function show_404(){
        $this->compile('errors/404', array(), 'DreamCraft.Su - Ошибка 404');
    }

    public function show_error($header, $message){
        $this->compile('errors/custom', array('header' => $header, 'message' => $message), 'DreamCraft.Su - Ошибка');
    }

    public function genMonitor(){
        $arr = $this->CI->server->getAll();
        $content = '';

        $curonline = 0;
        $curmaxonline = 0;

        foreach($arr as $server){

            if($server['maxonline'] > 0)
            {
                $serveronline = intval($server['online']);
                $servermaxonline = intval($server['maxonline']);

                /*if($serveronline < 3 && $serveronline > 0){
                    $serveronline = $serveronline - 1;
                }*/

                $curonline = intval($curonline) + $serveronline;
                $curmaxonline = intval($curmaxonline) + $servermaxonline;


                $content .= '<h3 class="heading-xs">
                            <a href="/page/'.$server['name'].'">'.$server['name'].'</a>
                            <span class="pull-right color-green">'.$serveronline . ' / ' . $servermaxonline .'</span>
                        </h3>
                        <div class="progress progress-u progress-xxs">
                            <div style="width: '. round(($server['online'] / $server['maxonline']) * 100) .'%" role="progressbar" class="progress-bar progress-bar-green"></div>
                        </div>';
            } else {
                $content .= '<h3 class="heading-xs">
                            '.$server['name'].'
                            <span class="pull-right color-red">Выключен</span>
                        </h3>
                        <div class="progress progress-u progress-xxs">
                            <div style="width: 100%" role="progressbar" class="progress-bar progress-bar-red"></div>
                        </div>';
            }

        }

        $content .= '<div class="tt">
                        <h3 class="heading-xs"><i class="fa fa-group"></i>Общий онлайн
                            <span class="pull-right">'. $curonline . '/' . round($curmaxonline) .'</span></h3>
                        <div class="progress progress-u progress-xxs margin-bottom-40">
                            <div style="width: '. round(($curonline / $curmaxonline) * 100) .'%" role="progressbar" class="progress-bar progress-bar-dark">
                            </div>
                        </div>
                    </div>';

        return $content;
    }

}