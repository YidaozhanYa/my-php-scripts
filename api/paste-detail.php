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
$query = new Query("Paste");
$pasteo = $query->get($requests['id']);

$paste['username']=$pasteo->get('username');
$paste['content']=$pasteo->get('content');
$paste['date']=$pasteo->get('date');
$paste['title']=$pasteo->get('title');
$paste['id']=strval($pasteo->get('objectId'));
echo "<!doctype html>";
echo <<<EOF
<style>
a {
    text-decoration:none;
    color: #2196f3;
} 
</style>
EOF;
echo '<body>';
echo '<p>';
echo '<strong>'.$paste['title'].'   </strong>    <font color="#a7a7a7">'.$paste['username'].' '.$paste['date'].'</font>';
echo '</p>';
echo '<p id="content1">'.$paste['content'].'</p>';
echo '<p>';
echo '<a href="https://api.yidaozhan.ga/api/paste?page=1">返回&nbsp;</a>';
echo '<a href="https://api.yidaozhan.ga/api/paste-raw?id='.$paste['id'].'">RAW&nbsp;</a>';
if(substr($paste['content'],0,4) == 'http'){ 
    echo '<a href="https://api.yidaozhan.ga/api/paste-redir?id='.$paste['id'].'">重定向</a>';
};
echo '</p>';
echo '<hr/>';
echo '<script src="https://cdn.bootcss.com/marked/0.8.1/marked.min.js"></script>';
echo '<script type="text/javascript">'."var tmp=marked(document.getElementById('content1').innerHTML).replace(new RegExp('\\n','gm'),'<br>');"."document.getElementById('content1').innerHTML = tmp;</script>";
echo '</body>';
