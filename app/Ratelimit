<?php
namespace App;
use \App\Config;
use Database\Database;

class Ratelimit{
    private $config;
    public function __construct(){
        $Config = new Config();
        $this->config = $Config->config;
        $path =
            str_replace("public", "", $_SERVER["DOCUMENT_ROOT"]) .
            "/lib/" .
            $this->config["dbinfo"]["db"] .
            ".php";
        require_once $path;
        $this->db = new Database($this->config);
    }
    private function getip()
    {
        $ip = "";
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }
        return $ip;
    }
    public function record()
    {
        $json = $this->db->get("RateLimit", "List");
        $ipKey = $this->getip() . "-" . date("Y-m-d H:i");

        if (isset($json[$ipKey])) {
            $json[$ipKey] = $json[$ipKey] + 1;
        } else {
            $json[$ipKey] = 1;
        }

        $this->db->edit("RateLimit", "List", $json);
        return true;
    }
    private function getip_config($ip)
    {
        $json = $this->db->get("RateLimit", "List");
        return $json[$ip . "-" . date("Y-m-d H:i")];
    }
    public function is_freezed()
    {
        $requestCount = $this->getip_config($this->getip());
        $rateLimitThreshold = $this->config['RateLimit'];

        if ($requestCount > $rateLimitThreshold) {
            return true;
        } else {
            return false;
        }
    }
}
