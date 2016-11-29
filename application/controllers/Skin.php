<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Skin extends DCMS_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('skinlib');
    }

    public function index(){
        $dir = array_diff(scandir(FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'skins'), array('..', '.'));

        foreach($dir as $key=>$value){
            $dir[$key] = str_replace('.png', '', $value);
        }

        $this->tpl->compile('profile/skin', array('list' => $dir), 'Галерея скинов');
    }

    public function get($username = 'default', $side = 'front')
    {
        if(strlen($username) != 36){
            $username = $this->user->getUUID($username);
        }
        if (file_exists(FCPATH . 'uploads'.DIRECTORY_SEPARATOR.'skins' . DIRECTORY_SEPARATOR . $username . '.png')) {
            $skin = FCPATH . 'uploads'.DIRECTORY_SEPARATOR.'skins' . DIRECTORY_SEPARATOR . $username . '.png';
        } else {
            $skin = FCPATH . 'uploads'.DIRECTORY_SEPARATOR.'skins'.DIRECTORY_SEPARATOR.'default.png';
        }

        $img = $this->skinlib->createPreview($skin, false, $side);
        header('Content-type: image/png');
        imagepng($img);
    }

    public function head($username = 'default', $size = 100)
    {
        if(strlen($username) != 36){
            $username = $this->user->getUUID($username);
        }
        if (file_exists(FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'skins'. DIRECTORY_SEPARATOR . $username . '.png')) {
            $path = FCPATH . 'uploads'.DIRECTORY_SEPARATOR.'skins' . DIRECTORY_SEPARATOR . $username . '.png';
        } else {
            $path = FCPATH . 'uploads'.DIRECTORY_SEPARATOR.'skins'.DIRECTORY_SEPARATOR.'default.png';
        }
        $img = $this->skinlib->createHead($path, $size);
        header('Content-type: image/png');
        header("Cache-Control: max-age=86600");
        imagepng($img);
    }

    public function catalog($username = '1', $side = 'front'){
        if (!empty($username) && file_exists(FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'skins' . DIRECTORY_SEPARATOR . $username . '.png')) {
            $skin = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'skins' . DIRECTORY_SEPARATOR . $username . '.png';
        } else {
            $skin = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'skins' . DIRECTORY_SEPARATOR;
        }

        $img = $this->skinlib->createPreview($skin, false, $side);
        header('Content-type: image/png');
        imagepng($img);
    }

    public function set($name){
        $dest = FCPATH . 'uploads'.DIRECTORY_SEPARATOR.'skins'.DIRECTORY_SEPARATOR . $this->userinfo['uuid'] . '.png';
        $src = FCPATH . 'assets'.DIRECTORY_SEPARATOR.'skins'.DIRECTORY_SEPARATOR . $name . '.png';

        if(file_exists($dest)){
            unlink($dest);
        }
        
        copy($src, $dest);

        $this->tpl->compile('success', array('msg' => 'Вы успешно установили скин из галереи!'), 'Установка скина');
    }
}