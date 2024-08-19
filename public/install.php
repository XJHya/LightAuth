<?php
require '../vendor/autoload.php';

use App\Config;
$Config = new Config();
if($Config->config['IsInstall']==true)die("您已安装过本程序了，不能再安装。");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Light Auth V3.1 安装向导</title>
</head>
<body>
    <?php
    if($_GET['step']==''){
        $html='
    <div class="box">
        <div class="title">Light Auth 安装向导</div>
        <textarea class="LICENSE" disabled>
Light Auth 程序使用协议

本协议仅适用于所有Light Auth的使用者。
1. 我们保留的权力:
 - 1.1 著作权
 - 1.2 禁止您使用本权限的权利
 - 1.3 所有权

2. 您需要遵守的规定
 - 2.1 保留完整著作权
 - 2.2 商用用途请联系light-team@foxmail.com申请许可证
 - 2.3 如您不尊重开发者，我们不允许您进行使用

3. 著作权信息
 - 作者: aztice@Github
 - 作者邮箱: light-team@foxmail.com
 - 作者QQ: 465723320

无论如何，我们有权禁止您使用Light Auth。
        </textarea><br/>
        <div class="orange">同意以上协议后即可开始安装并使用。</div><br/>
        <button class="agree" onclick="window.location.href=\'/install/?step=1\';">同意并开始安装</button>
    </div>';
    }
    else if($_GET['step']=='1'){
        $directory = '../lib/db';
        $files = glob($directory . '/*.php');
        $select = '<select name="db">';
        foreach ($files as $file) {
            $filename = basename($file, '.php');
            $select .= "<option>$filename</option>";
        }
        $select .= '</select>';
        $directory = '../lib/encrypt';
        $files = glob($directory . '/*.php');
        $select2 = '<select name="encrypt">';
        foreach ($files as $file) {
            $filename = basename($file, '.php');
            $select2 .= "<option>$filename</option>";
        }
        $select2 .= '</select>';
        $html = '<div class="box">
    <form action="/install/?step=2" method="post">
        <div class="title">Light Auth 安装向导</div><br/>
        <input placeholder="请输入数据库名" name="dbname"><br/>
        <input placeholder="请输入数据库密码(JsonDB数据库无需填写)" name="pw"><br/>
        <input placeholder="请输入管理员用户名" name="user"><br/><br/>
        请选择数据库:
        '.$select.'<br/>
        请选择加密算法:
        '.$select2.'<br/><br/>
        <input name="salt" placeholder="请输入Salt">
        <details>
        <summary class="summary">特殊数据库配置</summary>
        <div>
            <i class="tips">以下配置仅供特殊数据库用,JsonDB数据库无需填写</i><br/>
            <input placeholder="数据库IP" name="ip"><br/>
            <input placeholder="数据库端口" name="port"><br/>
        </div>
        </details>
        <div class="orange">Light Auth即将开始安装</div><br/>
        <button class="agree">安装</button>
    </form>
</div>';
    }
    else if($_GET['step']=='2'){
        if($_POST['user']==''){
            $html = '
            <div class="box">
        <div class="title">Light Auth 安装向导</div><br/>
        <div class="orange">错误!管理员用户名不能为空</div><br/>
        <button class="agree" onclick="window.location.href=\'/install/?step=1\';">返回上一步</button>
</div>';
        }
        else{
            require_once("../lib/db/inst/".$_POST['db'].'.php');
            $db = new install();
            //$db->init($_POST['dbname']);
            $Config->edit('IsInstall',true);
            $admin = [$_POST['user']];
            $Config->edit('admin',$admin);
            $dbinfo = array(
                'db' => $_POST['db'],
                'dbname' => $_POST['dbname'],
                'pw' => $_POST['pw'],
                'ip' => $_POST['ip'],
                'port' => $_POST['port']
                );
            $Config->edit('dbinfo',$dbinfo);
            $Config->edit('encrypt',$_POST['encrypt']);
            $Config->edit('salt',$_POST['salt']);
            $html = '
            <div class="box">
        <div class="title">安装成功</div><br/>
        <div class="orange">请注册一个名为ice的账号~</div><br/>
        <button class="agree" onclick="window.location.href=\'/\';">好的</button>
    </div>';
        }
    }
    echo $html;
    ?>
</body>
<style>
*{
    margin: 0;
    font-size: 18px;
}
details input{
    font-size: 13px;
}
.tips{
    color:grey;
    font-size: 15px;
}
select{
    font-size: 18px;
}
.summary{
    font-size: 18px;
    cursor: pointer;
}
input{
    font-size: 18px;
    color: black;
    outline: none;
    padding: 5px 10px;
    border-radius: 4px;
    width: 400px;
    border: solid 1px grey;
}
.agree{
    background: lightgreen;
    color: black;
    border: 0;
    font-size: 15px;
    padding: 5px 20px;
    cursor: pointer;
    border-radius: 4px;
}
.orange{
    color: orange;
}
.box{
    text-align: center;
    margin-top: 5%;
}
.title{
    font-size: 30px;
    font-weight: 100;
}
.LICENSE{
    margin-top: 5px;
    border: solid 1px grey;
    font-size: 18px;
    border-radius: 4px;
    resize: none;
    width: 400px;
    height: 400px;
    padding: 5px 10px;
    background: white;
}
</style>
</html>
