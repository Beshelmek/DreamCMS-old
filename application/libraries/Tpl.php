<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tpl {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('server_model', 'server');
        $this->CI->load->model('user_model', 'user');
    }

    public function compile($name, $data = array(), $userinfo = array(), $stitle = '')
    {
        $template = $this->CI->dbconfig->template;

        if(empty($stitle)) $stitle = $this->CI->dbconfig->site_title;
        if(!(is_array($userinfo) && count($userinfo) > 0)) $userinfo = $this->CI->user->getAll($this->CI->common->getUUID());

        $data['stitle'] = $stitle;

        $data['tpl'] = config_item('base_url') . 'templates/' . $template;
        $data['logged'] = $this->CI->common->isLogged();
        $data['monitoring'] = $this->genMonitor();

        if($data['logged']){
            $data['userinfo']['admin'] = in_array($userinfo['uuid'], $this->CI->dbconfig->admins);
        }else $data['userinfo']['admin'] = false;

        $data['userinfo'] = $userinfo;

        $data['meta'] = array(
            'description' => $this->CI->dbconfig->site_desc,
            'keywords' => implode(', ', $this->CI->dbconfig->keywords),
            'generator' => 'DreamWebEngineV2'
        );

        $data['csrf'] = array(
            'name' => $this->CI->security->get_csrf_token_name(),
            'hash' => $this->CI->security->get_csrf_hash()
        );
        $data['fcsrf'] = '<input type="hidden" name="'.$data['csrf']['name'].'" value="'.$data['csrf']['hash'].'"/>';

        $data['color_opt']   = $this->CI->server->selectColor('f');
        $data['server_opt']  = $this->CI->server->selectServer();

        $data['version']  = rand(0, PHP_INT_MAX);

        $data['dbconfig']  = $this->CI->dbconfig;

        $this->CI->load->view($template . '/pattern/header', $data);
        $this->CI->load->view($template . '/pattern/' . $name,    $data);
        $this->CI->load->view($template . '/pattern/footer', $data);
    }

    public function show_404(){
        header("HTTP/1.0 404 Not Found");
        $this->compile('errors/404', array(), 'Не найдено - Ошибка 404');
        die($this->CI->output->get_output());
    }

    public function show_error($header, $message){
        header("HTTP/1.0 500 Application error");
        $this->compile('errors/custom', array('header' => $header, 'message' => $message), 'Произошла ошибка');
        die($this->CI->output->get_output());
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

                $curonline = intval($curonline) + $serveronline;
                $curmaxonline = intval($curmaxonline) + $servermaxonline;

                $percent = round(($server['online'] / $server['maxonline']) * 100);

                $content .= '<h5 class="heading-xs"> <a href="/page/'.$server['name'].'">'.$server['name'].'</a>
                                <span class="pull-right color-green">'.$serveronline . ' / ' . $servermaxonline .'</span>
                            </h5>
                            <progress class="progress progress-info" value="'.$percent.'" max="100">'.$percent.'</progress>
                            ';
            } else {
                $content .= '<h5 class="heading-xs">'.$server['name'].'
                                <span class="pull-right color-red">Выключен</span>
                            </h5>
                        <progress class="progress progress-danger" value="100" max="100">0%</progress>';
            }

        }

        $content .= '<div class="tt">
                        <h5 class="heading-xs"><i class="fa fa-group"></i>Общий онлайн
                            <span class="pull-right">'. $curonline . '/' . round($curmaxonline) .'</span></h5>
                        <progress class="progress progress-info" value="'. round(($curonline / $curmaxonline) * 100) .'" max="100"></progress>
                    </div>';

        return $content;
    }

}