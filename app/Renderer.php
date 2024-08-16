<?php
namespace App;
use App\Config;
use App\User;

class Renderer {
    public $config;
    public function __construct(){
        $user = new User();
        echo $user->UserName;
        $Config = new Config();
        $this->config = $Config->config;
    }
    public function load($actionName) {
        $path = '../templates/' . $this->config['Template'] . '/' . $actionName . '.html';
        if(is_file($path)){}else{
            die('Template: '.$actionName.' -> 模板不存在');
        }
        $html = file_get_contents($path);
        $html = $this->render($html, 'config');
        $html = $this->render($html, 'assets');
        $html = $this->render($html, 'phrases');
        echo $this->render($html, 'template');
    }
    
    public function render($template, $renderName) {
        switch ($renderName) {
            case 'config':
                $output = preg_replace_callback(
                    '/\${config\.(\w+)}/',
                    function ($matches) {
                        $key = $matches[1];
                        if (array_key_exists($key, $this->config)) {
                            return $this->config[$key];
                        } else {
                            die("config.php -> 配置 $key 不存在");
                        }
                    },
                    $template
                );
                return $output;
            case 'assets':
                $config = $this->config;
                $uri = ($this->config['FileCache'] == false) ? '?' . time() : '';
                return preg_replace_callback(
                    '/\${assets\.(css|js)\.(\w+)}/',
                    function ($matches) use ($config, $uri) {
                        $type = $matches[1];
                        $file = $matches[2];
                        if ($type === 'css') {
                            return '<link rel="stylesheet" href="/assets/css/' . $file . '.css' . $uri . '">';
                        } elseif ($type === 'js') {
                            return '<script src="/assets/js/' . $file . '.js' . $uri . '"></script>';
                        }
                    },
                    $template
                );
            case 'template':
                return preg_replace_callback(
                    '/\${template\.(\w+)}/',
                    function ($matches) {
                        $templateName = $matches[1];
                        $path = '../templates/' . $this->config['Template'] . '/' . $templateName . '.html';
                        if (file_exists($path)) {
                            $data = file_get_contents($path);
                            $data = $this->render($data, 'config');
                            $data = $this->render($data, 'phrases');
                            return $this->render($data, 'assets');
                        } else {
                            die("子模板 -> $path 不存在");
                        }
                    },
                    $template
                );
            case 'phrases':
                return preg_replace_callback(
                    '/\${phrase\.(\w+)}/',
                    function ($matches) {
                        $phraseKey = $matches[1];
                        $phrasePath = '../templates/' . $this->config['Template'] . '/phrases.json';
                        if (file_exists($phrasePath)) {
                            $phrases = json_decode(file_get_contents($phrasePath), true);
                            if (isset($phrases[$phraseKey])) {
                                return $phrases[$phraseKey];
                            } else {
                                die("phrases.json -> 关键字 $phraseKey 不存在");
                            }
                        } else {
                            die("phrases.json 文件不存在");
                        }
                    },
                    $template
                );
            default:
                return false;
        }
    }
}
