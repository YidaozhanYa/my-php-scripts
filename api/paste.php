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
$query->skip((intval($requests['page'])-1)*10);
$query->limit(10);
$query->descend("createdAt");
$query->select("username", "content","date","title","objectId");
$objpastes = $query->find();
$count=0;
foreach ($objpastes as $paste) {
    $count+=1;
    $pastes[$count]['username']=$paste->get('username');
    $pastes[$count]['content']=$paste->get('content');
    $pastes[$count]['date']=$paste->get('date');
    $pastes[$count]['title']=$paste->get('title');
    $pastes[$count]['id']=strval($paste->get('objectId'));
};

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
$script='<script type="text/javascript">';
$count=0;

foreach ($pastes as $paste){
$count+=1;
echo '<p>';
echo '<strong>'.$paste['title'].'   </strong>    <font color="#a7a7a7">'.$paste['username'].' '.$paste['date'].'</font>';
echo '</p>';
echo '<p id="content'.strval($count).'">'.$paste['content'].'</p>';
echo '<p>';
echo '<a href="https://api.yidaozhan.gq/api/paste-raw?id='.$paste['id'].'">RAW</a>';
echo '</p>';
echo '<hr/>';

$script=$script ."var tmp=marked(document.getElementById('content".strval($count)."').innerHTML).replace(new RegExp('\\n','gm'),'<br>');"."document.getElementById('content".strval($count)."').innerHTML = tmp.substr(0,tmp.length-4);";
};

$script=$script .'</script>';
echo '<script src="https://cdn.bootcss.com/marked/0.8.1/marked.min.js"></script>';
echo $script;
echo '</body>';
 ?>