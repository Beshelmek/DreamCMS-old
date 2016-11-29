<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Launcher extends DCMS_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth_model', 'auth');
        $this->load->model('server_model', 'server');
        $this->load->model('permissions_model', 'permissions');
        $this->load->helper('string');

        header('Content-Type: text/html; charset=utf-8');
    }

    public function servers(){
        $rarr = array();

        foreach($this->server->getAll() as $server){
            $rarr[] = array(
                $server['name'], $server['ip'], $server['port'], '1.7.10', $server['online'], $server['maxonline'], 'null'
            );
        }

        die($this->arrToStr($rarr));
    }

    private function toUUID($s){
        return substr($s, 0, 8) . '-' . substr($s, 8, 4) . '-' . substr($s, 12, 4) . '-' . substr($s, 16, 4) . '-' . substr($s, -12);
    }

    public function s(){
        $md5 = $_GET['user'];

        $capeurl = 'http://skins.dreamcraft.su/uploads/cloaks/';
        $uploaddirp = '/var/www/beshelmek/data/www/dreamcraft.su/uploads/cloaks';
        $uploaddirs = '/var/www/beshelmek/data/www/dreamcraft.su/uploads/skins';
        $skinurl = 'http://skins.dreamcraft.su/uploads/skins/';


        if (!preg_match("/^[a-zA-Z0-9_-]+$/", $md5)){
            //exit;
        }

        $q = $this->db->get_where('dc_members', array('uuid' => $this->toUUID($md5)), 1);
        $row = $q->row_array();
        $realUser = $row['login'];

        $time = time();
        $exists1 = file_exists($uploaddirp.'/'.$realUser.'.png');
        $exists2 = file_exists($uploaddirs.'/'.$realUser.'.png');
        if ($exists1) {
            $cape =
                '
		        "CAPE":
				{
					"url":"'.$capeurl.'/'.$realUser.'.png"
				}';
        } else {
            $cape = '';
        }
        if ($exists2) {
            $skin =
                '
		        "SKIN":
				{
					"url":"'.$skinurl.$realUser.'.png"
				}';
        } else {
            $skin = '';
        }
        if ($exists1 && $exists2) {
            $spl = ',';
        } else {
            $spl = '';
        }

        $base64 ='
		{
			"timestamp":"'.$time.'","profileId":"'.$md5.'","profileName":"'.$realUser.'","textures":
			{
				'.$skin.$spl.$cape.'
			}
		}';
        echo '
		{
			"id":"'.$md5.'","name":"'.$realUser.'","properties":
			[
			{
				"name":"textures","value":"'.base64_encode($base64).'"
			}
			]
		}';
    }

    public function h(){
        $user     = $_GET['username'];
        $serverid = $_GET['serverId'];

        $bad = array('error' => "Bad login",'errorMessage' => "Bad login [H]");

        if (!preg_match("/^[a-zA-Z0-9_-]+$/", $user) || !preg_match("/^[a-zA-Z0-9_-]+$/", $serverid)){
           // exit(json_encode($bad));
        }

        $q = $this->db->get_where('dc_members', array('login' => $user, 'serverID' => $serverid), 1);
        $row = $q->row_array();
        $realUser = $row['login'];
        $md5 = str_replace('-', '', $row['uuid']);

        $capeurl = 'http://skins.dreamcraft.su/uploads/cloaks/';
        $uploaddirp = '/var/www/beshelmek/data/www/dreamcraft.su/uploads/cloaks';
        $skinurl = 'http://skins.dreamcraft.su/uploads/skins/';

        if($user == $realUser)
        {
            $time = time();
            $file = $capeurl.$realUser.'.png';
            $exists = file_exists($uploaddirp.'/'.$realUser.'.png');
            if ($exists) {
                $cape =
                    ',
			        "CAPE":
					{
						"url":"'.$capeurl.'?/'.$realUser.'$"
					}';
            } else {
                $cape = '';
            }
            $base64 ='
			{
				"timestamp":"'.$time.'","profileId":"'.$md5.'","profileName":"'.$realUser.'","textures":
				{
					"SKIN":
					{
						"url":"'.$skinurl.$realUser.'.png"
					}'.$cape.'
				}
			}';
            echo '
			{
				"id":"'.$md5.'","name":"'.$realUser.'","properties":
				[
				{
					"name":"textures","value":"'.base64_encode($base64).'","signature":"Cg=="
				}
				]
			}';
        }
    }

    public function j(){
        if (($_SERVER['REQUEST_METHOD'] == 'POST' ) && (stripos($_SERVER["CONTENT_TYPE"], "application/json") === 0)) {
            $json = json_decode(file_get_contents('php://input'));
        }

        $md5 = $json->selectedProfile;
        $sessionid = $json->accessToken;
        $serverid = $json->serverId;

        $bad = array('error' => "Bad login",'errorMessage' => "Bad login [J]");

        if (!preg_match("/^[a-zA-Z0-9_-]+$/", $md5) || !preg_match("/^[a-zA-Z0-9:_-]+$/", $sessionid) || !preg_match("/^[a-zA-Z0-9_-]+$/", $serverid)){
            //exit(json_encode($bad));
        }

        $q = $this->db->get_where('dc_members', array('uuid' => $this->toUUID($md5), 'sessionId' => $sessionid), 1);
        $row = $q->row_array();

        $realmd5  = str_replace('-', '', $row['uuid']);
        $realUser = $row['login'];

        $ok = array('id' => $realmd5, 'name' => $realUser);

        if($realmd5 == $md5)
        {
            $q2 = $this->db->update('dc_members', array('serverID' => $serverid), array('sessionId' => $sessionid, 'uuid' => $this->toUUID($md5)), 1);
            if($q2) {
                die(json_encode($ok));
            }
        }

        die(json_encode($bad));
    }

    public function launcher(){
        $this->launch();
    }

    public function skin(){
        $this->launch();
    }

    public function sver(){
        die('1.2');
    }

    public function listuuid(){
        $q = $this->db->get('dc_members');
        $r = '';
        foreach($q->result_array() as $user){
            $r = $r . strtolower($user['login']) . '<>' . strtolower($user['uuid']) . '<:>';
        }
        die(substr($r, 0, -3));
    }

    public function crash(){
        $crash = $this->input->post('crash', false);

        $fp = fopen('/var/www/beshelmek/data/www/dreamcraft.su/launcher/crash-reports/' . time() . '.txt', 'w');
        $test = fwrite($fp, $crash);
        if ($test) echo 'Данные в файл успешно занесены.';
        else echo 'Ошибка при записи в файл.';
        fclose($fp);
    }

    public function md5(){
        die(md5_file('/var/www/beshelmek/data/www/dreamcraft.su/launcher/clients/launcher.jar'));
    }

    public function get(){
        $file = '/var/www/beshelmek/data/www/dreamcraft.su/launcher/clients/launcher' . $_GET['f'];
        if (file_exists($file)) {
            if (ob_get_level()) {
                ob_end_clean();
            }
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }

    public function launch(){
        $key1          = 'e8807800e8807800';
        $key2          = '808077a6808077a6';
        $protectionKey = 'f7f82d13f7f82d13';
        $masterversion = '1.3';

        $action = $this->input->post('action');
        if(isset($action) && !empty($action)){
            $action = str_replace(" ", "+", $action);
            $action = $this->decrypt($action, $key2);

            if($action == null) {
                exit($this->encrypt("badhash<$>", $key1));
            }

            @list($action, $client, $login, $password, $md5, $token, $hwid, $shaders) = explode(':', $action);

            if (!preg_match("/^[a-zA-Z0-9_-]+$/", $login) || !preg_match("/^[a-zA-Z0-9_-]+$/", $password) || !preg_match("/^[a-zA-Z0-9_-]+$/", $action)) {
               // exit($this->encrypt("errorLogin<$>", $key1));
            }

            $user = $this->user->getAll($login);
            $ip = $this->input->ip_address();

            if($token == 'null' || empty($token)){
                if($ip != '87.250.10.210'){
                    $q = $this->db->get_where('dc_brute', array('ip' => $ip), 1);
                    if($q->num_rows() > 0){
                        $row = $q->row_array();
                        if($row['bantime'] > time()){
                            exit($this->encrypt("temp<$>", $key1));
                        }else{
                            if($row['bantime'] != 0){
                                $this->db->update('dc_brute', array('count' => 0, 'bantime' => 0), array('ip' => $ip), 1);
                            }
                        }
                    }
                }
                if(!$this->doAuth($login, $password)){
                    $q = $this->db->get_where('dc_brute', array('ip' => $ip), 1);
                    if($q->num_rows() > 0){
                        $row = $q->row_array();
                        $this->db->update('dc_brute', array('count' => $row['count'] + 1), array('ip' => $ip), 1);
                        if(($row['count']+1) >= 3){
                            if($row['bantime'] < time()){
                                $this->db->update('dc_brute', array('bantime' => time() + 300), array('ip' => $ip), 1);
                            }
                        }
                    }else{
                        $this->db->insert('dc_brute', array(
                            'ip' => $ip,
                            'count' => 1,
                            'bantime' => 0
                        ));
                    }

                    exit($this->encrypt("errorLogin<$>", $key1));
                }

                $atoken = random_string('md5');
            }else{
                $atoken = $password;
                if($user['token'] != $atoken){
                    exit($this->encrypt("errorLogin<$>", $key1));
                }
            }

            $sessionId = random_string('md5');
            $login = $user['login'];

            if($action == 'auth'){
                $this->db->update('dc_members', array(
                    'sessionId' => $sessionId,
                    'token' => $atoken,
                ), array('login' => $login), 1);

                $uuid     = $user['uuid'];
                $md5zip      = @md5_file("launcher/clients/" . $client . "/config.zip");
                $md5ass      = @md5_file("launcher/clients/assets.zip");
                $sizezip     = @filesize("launcher/clients/" . $client . "/config.zip");
                $sizeass     = @filesize("launcher/clients/assets.zip");
                $usrsessions = "$masterversion<:>$uuid<:>" . $md5zip . "<>" . $sizezip . "<:>" . $md5ass . "<>" . $sizeass . "<br>" . $login . '<:>' . $this->strtoint($this->xorencode($sessionId, $protectionKey)) . '<br>' . $atoken . '<br>';

                $hash_md5 = str_replace("\\", "/", $this->checkfiles('launcher/clients/' . $client . '/bin/') . $this->checkfiles('launcher/clients/' . $client . '/mods/') . $this->checkfiles('launcher/clients/' . $client . '/coremods/') . $this->checkfiles('launcher/clients/' . $client . '/natives/')) . '<::>' . $client . '/bin<:b:>' . $client . '/mods<:b:>' . $client . '/coremods<:b:>' . $client . '/natives<:b:>';

                echo $this->encrypt($usrsessions . $hash_md5, $key1);
            }elseif($action == 'getpersonal'){
                $realmoney = $user['realmoney'];
                $iconmoney = $user['money'];
                $jobname = "nojob";
                $joblvl = -1;
                $jobexp = -1;

                $datetoexpire = 0;
                $ugroup = $this->permissions->getMaxGroup($login);

                $canUploadSkin 		= 1;
                $canUploadCloak		= 1;
                $canBuyVip	   		= 1;
                $canBuyPremium 		= 1;
                $canBuyUnban   		= 1;
                $canActivateVaucher = 0;
                $canExchangeMoney	= 1;
                die("$canUploadSkin$canUploadCloak$canBuyVip$canBuyPremium$canBuyUnban$canActivateVaucher$canExchangeMoney<:>$iconmoney<:>$realmoney<:>0<:>120<:>230<:>299<:>100<:>$ugroup<:>$datetoexpire<:>$jobname<:>$joblvl<:>$jobexp");
            }else{
                exit($this->encrypt("badhash<$>", $key1));
            }

        }else{
            die('Пуста!');
        }
    }

    private function xorencode($str, $key) {
        while(strlen($key) < strlen($str)) {
            $key .= $key;
        }
        return $str ^ $key;
    }

    private function strtoint($text) {
        $res = "";
        for ($i = 0; $i < strlen($text); $i++) $res .= ord($text{$i}) . "-";
        $res = substr($res, 0, -1);
        return $res;
    }

    private function encrypt($input, $key) {

        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $input = $this->pkcs5_pad($input, $size);
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);
        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);
        return $data;
    }

    private function pkcs5_pad ($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    private function decrypt($sStr, $sKey) {
        $decrypted= mcrypt_decrypt(
            MCRYPT_RIJNDAEL_128,
            $sKey,
            base64_decode($sStr),
            MCRYPT_MODE_ECB
        );
        $dec_s = strlen($decrypted);
        $padding = ord($decrypted[$dec_s-1]);
        $decrypted = substr($decrypted, 0, -$padding);
        return $decrypted;
    }

    private function checkfiles($path)
    {
        $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
        $massive = "";
        foreach ($objects as $name => $object) {
            $basename = basename($name);
            $isdir    = is_dir($name);
            if ($basename != "." and $basename != ".." and !is_dir($name)) {
                $str     = str_replace('launcher/clients/', "", str_replace($basename, "", $name));
                $massive = $massive . $str . $basename . ':>' . md5_file($name) . ':>' . filesize($name) . '<:>';
            }
        }
        return $massive;
    }

    private function doAuth($login, $password){
        return $this->auth->checkUser($login, $password);
    }

    private function arrToStr($arr = array()){
        $rstr = '';

        foreach($arr as $item){
            if(is_array($item)){
                foreach($item as $item2){
                    $rstr .= $item2 . '<:>';
                }
                $rstr = substr($rstr, 0, -3);
                $rstr .= '<::>';
            }else{
                $rstr .= $item . '<::>';
            }
        }

        return $rstr;
    }

}