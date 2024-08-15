<?php
namespace App;
use App\Renderer;

class Loader {
    public function __construct() {
        $actionName = isset($_GET['do']) ? htmlspecialchars($_GET['do']) : 'index';
        $app = new Renderer();
        $app->load($actionName);
    }
}
