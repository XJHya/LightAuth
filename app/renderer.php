<?php
namespace App;
use App\Config;
use App\User;

class Renderer {
    public $config;
    public function __construct(){
        $user = new User();
        echo $user->$UserName;
        $Config = new Config();
        $this->config = $Config->config;
    }
    public function load($actionName) {
        $path = '../templates/' . $actionName . '.html';
        $html = file_get_contents($path);
        $html = $this->render($html, 'config');
        $html = $this->render($html, 'assets');
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
                            return '<link rel="stylesheet" href="assets/css/' . $file . '.css' . $uri . '">';
                        } elseif ($type === 'js') {
                            return '<script src="assets/js/' . $file . '.js' . $uri . '"></script>';
                        }
                    },
                    $template
                );
            case 'template':
                return preg_replace_callback(
                    '/\${template\.(\w+)}/',
                    function ($matches) {
                        $templateName = $matches[1];
                        $path = '../templates/' . $templateName . '.html';
                        if (file_exists($path)) {
                            $data = file_get_contents($path);
                            $data = $this->render($data, 'config');
                            return $this->render($data, 'assets');
                        } else {
                            die("子模板 -> $path 不存在");
                        }
                    },
                    $template
                );
            default:
                return false;
        }
    }
}
