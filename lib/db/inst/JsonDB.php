<?php
/*
Installation Application By Github aztice
考虑到不同程序对于创建数据库等的兼容性，因此特地创建inst功能
*/  
require_once('../lib/db/JsonDB.php');
use JsonDB\JsonDB;
class install{
    public function __construct($db){
        $jdb = new JsonDB();
        $jdb->createdb($db);
        $jdb->connect($db);
        $jdb->CreateList('UserData');
        $jdb->CreateList('TempCode');
        $jdb->CreateList('LoginData');
        $jdb->CreateList('AppList');
        $jdb->CreateList('LatestAC');
        $jdb->CreateList('RateLimit');
        return true;
    }
}
