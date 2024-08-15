<?php
namespace App;
include '../config.php';

class Renderer {
    public function load($actionName) {
        $path = '../templates/' . $actionName . '.html';
        $templateContent = file_get_contents($path);
        echo $this->render($templateContent, 'config');
    }
    
    public function render($template, $renderName) {
        switch ($renderName) {
            case 'config':
                $output = preg_replace_callback(
                    '/\${config\.(\w+)}/',
                    function ($matches) {
                        global $config;
                        $key = $matches[1];
                        if (array_key_exists($key, $config)) {
                            return $config[$key];
                        } else {
                            die("config.php -> 配置 $key 不存在");
                        }
                    },
                    $template
                );
                
                return $output;
            default:
                return $template;
        }
    }
}
