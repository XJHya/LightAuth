<?php
namespace App;
use Database\Database;
use App\Config;

class UserModule
{
    public $UserName;
    private $config;
    private $db;

    public function __construct()
    {
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

    public function login($user, $pw)
    {
        if ($this->RateLimit()==true) {
            return 'ratelimited';
        }
        $this->RateLimitRecord();

        if ($this->is_user($user)) {
            $userData = $this->db->get("UserData", $user);
            if ($userData && $userData["password"] == $this->pw_encrypt($pw)) {
                $authid = uniqid(15);
                $userData['authid'] = $authid;
                $this->db->edit($user,$userData);
                setcookie("username", $user);
                setcookie("authid", $authid);
                return true;
            }
        }
        return false;
    }

    public function pw_encrypt($pw)
    {
        $path =
            str_replace("public", "", $_SERVER["DOCUMENT_ROOT"]) .
            "/lib/encrypt/" .
            $this->config["encrypt"] .
            ".php";
        return encrypt($pw, $this->config["salt"]);
    }

    public function is_user($user)
    {
        return $this->db->iskey("UserData", $user);
    }

    public function GetRealIP()
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
    public function RateLimitRecord()
    {
        $json = $this->db->get("RateLimit", "List");
        $ipKey = $this->GetRealIP() . "-" . date("Y-m-d H:i");

        if (isset($json[$ipKey])) {
            $json[$ipKey] = $json[$ipKey] + 1;
        } else {
            $json[$ipKey] = 1;
        }

        $this->db->edit("RateLimit", "List", $json);
        return true;
    }
    function RateLimitConfig($ip)
    {
        $json = $this->db->get("RateLimit", "List");
        return $json[$ip . "-" . date("Y-m-d H:i")];
    }
    function RateLimit()
    {
        $requestCount = $this->RateLimitConfig($this->GetRealIP());
        $rateLimitThreshold = $this->config['RateLimit'];

        if ($requestCount > $rateLimitThreshold) {
            return true;
        } else {
            return false;
        }
    }
}
