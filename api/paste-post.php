<?php
ini_set("display_errors", 0);
error_reporting(0);
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_WARNING); 
header("Content-type: text/html; charset=utf-8");

require_once("autoload-linux.php");

use \LeanCloud\Client;
use \LeanCloud\LeanObject;
use \LeanCloud\Query;
const LEANCLOUD_APP_ID="wJLVV03nE1n03kLkea6Uxucb-MdYXbMMI";
const LEANCLOUD_APP_KEY="KIqVL83VBAtoqssrg8ntSlWS";
const LEANCLOUD_MASTER_KEY="IyzzV5q1PxJY6EC9OqogX306";
if (is_null($_SERVER['QUERY_STRING'])==false){
    $parameters = explode("&", $_SERVER['QUERY_STRING']);
    $requests = array();
    //parameters to array
    foreach ($parameters as $v) {
        $requests = array_merge($requests, array(explode("=", $v)[0] => explode("=", $v)[1]));
    };
};
Client::initialize(LEANCLOUD_APP_ID,LEANCLOUD_APP_KEY,LEANCLOUD_MASTER_KEY);
if (file_get_contents("php://input")!==""){
    $query = new Query("Token");
    $query->equalTo("token", $requests['token']);
    if ($query->first()->get('username')==$requests['username']){
        $paste=new LeanObject("Paste");
        $paste->set('content',rawurldecode(file_get_contents("php://input")));
        $paste->set('username',rawurldecode($requests['username']));
        $paste->set('date',date('Y-m-d'));
        $paste->set('title',rawurldecode($requests['title']));
        $paste->save();
        echo "<script>alert('成功。');</script>";
    } else {
        echo "<script>alert('授权码错误。');</script>";
    };
};


echo "<!doctype html>";
echo <<<EOF
<h1>发布剪贴板</h1>
<p>标题<input type="text" id="title"></p>
<p>用户名<input type="text" id="username"></p>
<p>授权码<input type="text" id="token"></p>
<p>内容</p>
<textarea id=content></textarea>
<p><input type="submit" value="发布" onclick="submit();"></p>
<script>
function submit()
{
var title = document.getElementById("title").value;
var username = document.getElementById("username").value;
var token = document.getElementById("token").value;
var content = document.getElementById("content").value;
var posturl = window.location.protocol+"//"+window.location.host+""+window.location.pathname+"?username="+username+"&token="+token+"&title="+title;
var xmlobj = new XMLHttpRequest();
xmlobj.open("POST", posturl, true);
xmlobj.send(content); //设置为发送给服务器数据

xmlobj.onreadystatechange = function() {
    if(xmlobj.readyState == 4 && xmlobj.status == 200)
    {
        var rsp = xmlobj.responseText;
        console.log(rsp);
    }
};
}

</script>
EOF;
