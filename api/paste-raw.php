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
$paste = $query->get($requests['id']);
echo $paste->get('content');
