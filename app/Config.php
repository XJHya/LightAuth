<?php
namespace App;

class Config{
    public $config;
    public function __construct(){
        $this->config = json_decode(file_get_contents(str_replace('/public','',$_SERVER['DOCUMENT_ROOT'].'/config.json')),true);
    }
    public function edit($key,$value){
        $this->config[$key] = $value;
        file_put_contents(str_replace('/public','',$_SERVER['DOCUMENT_ROOT'].'/config.json'),json_encode($this->config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
