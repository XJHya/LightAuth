<?php
/* 登录模块 */
namespace App\User;
use App\UserModule;
use App\Renderer;
use App\PhraseHandler;

class Login{
    public function __construct(){
        $this->PhraseHandler = new PhraseHandler();
        $app = new Renderer(); // 加载渲染器
        $app->load("/api/login"); // 加载模板
        $UserModule = new UserModule();
        $login_result = $UserModule->login($_POST['username'],$_POST['pw']); // 获取登录信息并调用登录模块
        if($login_result=='freezed') { // 激活频率限制
            $app->relocate("/",3); // 返回登录页面
            $app->replace("\${api.return.statusIcon}","/assets/img/xmark.svg"); // 加载状态图标-错误
            $app->replace("\${api.return.loginstatus}", $this->PhraseHandler->get('login_failed')); // 返回登录状态
            $app->replace("\${api.return.info}", $this->PhraseHandler->get('login_freezed')); // 返回登录状态信息
        } else if($login_result==true){ // 登录成功
            $app->replace("\${api.return.statusIcon}","/assets/img/success.svg"); // 加载状态图标-成功
            $app->replace("\${api.return.loginstatus}", $this->PhraseHandler->get('login_success')); // 返回登录状态
            $app->replace("\${api.return.info}", ''); // 返回登录状态信息-空
        } else if ($login_result==false) {
            $app->relocate("/",3); // 返回登录页面
            $app->replace("\${api.return.statusIcon}","/assets/img/xmark.svg"); // 加载状态图标-错误
            $app->replace("\${api.return.loginstatus}", $this->PhraseHandler->get('login_failed')); // 返回登录状态
            $app->replace("\${api.return.info}", $this->PhraseHandler->get('login_info_incorrect')); // 返回登录状态信息
        }
        $app->display(); // 显示模板
    }
}
