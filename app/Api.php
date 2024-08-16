<?php
namespace App;
use Lib\Captcha;
use App\Config;

class Api{
    public $config;
    public function __construct(){
        $Config = new Config();
        $this->config = $Config->config;
        $do=str_replace('/','',$_GET['do']);
        $do=str_replace('api','',$do);
        switch($do){
            case('captcha'):
                if($this->config['captcha']==false)die("验证码Api没有开启~");
                $Captcha = new Captcha();
                $Captcha -> LoadCaptcha();
            default:
                die("找不到目标的Api~");
        }
    }
}
