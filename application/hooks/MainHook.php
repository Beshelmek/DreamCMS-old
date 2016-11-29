<?php

class MainHook{

    public function MainHook(){
        if(isset($_GET['b'])){
            setcookie('bonus',$_GET['b'],time() + 864000, '/');
        }
        if(isset($_GET['p'])){
            setcookie('refer',$_GET['p'],time() + 8640000, '/');
        }
    }

}