<?php
namespace App;
error_reporting(0);

use App\Config;

class AssetsLoader {
    public function __construct() {
        $Config = new Config();
        $path = '../templates/' . $Config->config['Template'] . $_GET['file'];

        if (strpos($path, '.css') !== false) {
            header('Content-Type: text/css');
        } elseif (strpos($path, '.js') !== false) {
            header('Content-Type: application/javascript');
        } elseif (strpos($path, '.svg') !== false) {
            header('Content-Type: image/svg+xml');
        }

        echo file_get_contents($path);
    }
}
