<?php
namespace App;
use Database\Database;
use App\Config;

class TempId{
    private $config;
    private $db;
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
    public function create($data){
        $code=uniqid(15);
        $this->db->edit('Tempid',$id,$data);
        return $code;
    }
    public function get($id){
        return $this->db->get('Tempid',$id);
    }
    public function is_id($id){
        return $this->db->IsKey('Tempid',$id);
    }
}
