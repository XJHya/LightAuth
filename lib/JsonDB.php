<?php
/*
本模块负责对接JsonDB
*/
namespace Database;
use JsonDB\JsonDB;

require_once(__DIR__.'/db/JsonDB.php');

class Database{
    private $db;
    public function __construct($config){
        $this->db = new JsonDB();
        $this->db->connect($config['dbinfo']['dbname']);
        return true;
    }
    public function edit($table,$key,$value){
        $this->db->edit($table,$key,$value);
        return true;
    }
    public function get($table,$key){
        return $this->db->get($table,$key);
    }
    public function iskey($table,$key){
        return $this->db->IsKey($table,$key);
    }
    public function backup(){
        $this->db->Backup();
        return "./Backup/";
    }
}
