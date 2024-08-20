<?php
namespace App;
use Lib\Captcha;
use App\Config;
use App\Renderer;
use App\UserModule;
use App\PhraseHandler;
use App\User\Login;
use App\User\Register;

class Api{
    private $config;
    private $phrase;
    private $PhraseHandler;
    public function __construct(){
        $Config = new Config();
        $this->config = $Config->config;
        $this->PhraseHandler = new PhraseHandler();
        $do=str_replace('/','',$_GET['do']);
        $do=str_replace('api','',$do);
        switch($do){
            case('captcha'):
                if($this->config['captcha']==false)die("验证码Api没有开启~");
                $Captcha=new Captcha();
                $Captcha->LoadCaptcha();
                break;
            case('login'):
                $app = new Login();
                break;
            case ('register'):
                $app = new Register();
                break;
            default:
                die("找不到目标的Api~");
        }
    }
}
