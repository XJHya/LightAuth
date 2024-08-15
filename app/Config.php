<?php
namespace App;

class Config{
    public $config;
    public function __construct(){
        $this->config = array(
            'title' => '轻雨 Auth',
            'description' => '由轻雨科技团队开发的账号系统，用于账号管理、授权等功能。',
            'keywords' => '账号管理,Auth,轻雨科技,账号系统,授权系统',
            'FileCache' => false,
            'Template' => 'default'
        );
    }
}