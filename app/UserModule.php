<?php
namespace App;
use Database\Database;
use App\Config;
use App\Ratelimit;

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
        $Ratelimit = new Ratelimit();
        if ($Ratelimit->is_freezed()==true) {
            return 'freezed';
        }
        $Ratelimit->record();

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
    
    public function register($email,$username,$pw,$captcha){
        
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

}
