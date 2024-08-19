<?php
/*
Installation Application By Github aztice
考虑到不同程序对于创建数据库等的兼容性，因此特地创建inst功能
*/  
require_once('../lib/db/JsonDB.php');
class install{
    public function __construct(){
    }
    public function init($db){
        $jdb = new JsonDB();
        $jdb->createdb($db);
        $jdb->connect($db);
        $jdb->CreateList('User');
        $jdb->CreateList('TempCode');
        $jdb->CreateList('LoginData');
        $jdb->CreateList('AppList');
        $jdb->CreateList('LatestAC');
        return true;
    }
}
