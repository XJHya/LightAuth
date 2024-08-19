<?php
namespace App;
use App\Renderer;
use App\Config;

class Loader {
    public function __construct() {
        $Config = new Config();
        if($Config->config['IsInstall']==false){
            header('location: /install/');
        }
        $actionName = isset($_GET['do']) ? htmlspecialchars($_GET['do']) : 'index';
        $actionName = str_replace('/','',$actionName);
        $app = new Renderer();
        $app->load($actionName);
        $app->display();
    }
}
