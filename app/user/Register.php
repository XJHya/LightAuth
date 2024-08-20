<?php
/* 登录模块 */
namespace App\User;
use App\UserModule;
use App\Renderer;
use App\PhraseHandler;
use App\Config;
use Lib\Captcha;
use Lib\SMTP\Mailer;

class Register{
    private $config;
    public function __construct(){
        $this->PhraseHandler = new PhraseHandler();
        $app = new Renderer();
        $Config = new Config();
        $this->config = $Config->config;
        $Mailer = new Mailer();
        $Mailer->SendMail('light-team@foxmail.com','测试','测试');
        die();
        if($this->config['captcha']==true){
            $CaptchaModule = new Captcha();
            if($CaptchaModule->VerifyCaptcha($_POST['captcha'])==false){
                $app = new Renderer();
                $app->load("/api/register");
                $app->relocate("/register/",3); // 返回注册页面
                $app->replace("\${api.return.statusIcon}","/assets/img/xmark.svg"); // 加载状态图标-错误
                $app->replace("\${api.return.loginstatus}", $this->PhraseHandler->get('register_failed')); // 返回注册状态
                $app->replace("\${api.return.info}", $this->PhraseHandler->get('incorrect_captcha')); // 返回注册状态信息
                $app->display();
                exit;
            }
        }
        $app = new Renderer();
        $app->load("/api/register");
        $UserModule = new UserModule();
        $UserModule->register($_POST['email'],$_POST['username'],$_POST['password'],$_POST['captcha']);
        $app->display(); // 显示模板
    }
}
