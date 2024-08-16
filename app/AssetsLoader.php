<?php
namespace App;
use App\Config;

class AssetsLoader{
    public function __construct(){
        $Config = new Config();
        $path = '../templates/'.$Config->config['Template'].$_GET['file'];
        if (strpos($path, '.css') !== false) {
            header('Content-Type: text/css');
            
        } else if (strpos($path, '.js') !== false) {
            header('Content-Type: application/javascript');
        
        }
        echo file_get_contents($path);
    }
}
