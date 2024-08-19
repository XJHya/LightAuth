<?php
namespace App;
use \App\Config;

class PhraseHandler
{
    private $config;
    private $phrases;

    public function __construct()
    {
        $Config = new Config();
        $this->config = $Config->config;
        $this->phrases = null;
        $path = '../templates/' . $this->config['Template'] . '/phrases.json';
        if (file_exists($path)) {
            $this->phrases=json_decode(file_get_contents($path), true);
        } else {
            die("phrases.json 文件不存在");
        }
    }

    public function get($key)
    {
        if (isset($this->phrases[$key])) {
            return $this->phrases[$key];
        } else {
            die("phrases.json -> 关键字 $key 不存在");
        }
        return $this->phrases[$key];
    }
}
