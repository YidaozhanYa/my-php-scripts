<?php
ini_set("display_errors", 0);
error_reporting(0);
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_WARNING); 

function get_max_files()
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://smmwe-cloud.vercel.app/main/?apiv3-maxfiles");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_HEADER, false);
    $return_data = curl_exec($curl);
    curl_close($curl);
    return intval($return_data);
};

function get_storage()
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://smmwe-cloud.vercel.app/main/?apiv3-diskspace");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_HEADER, false);
    $return_data = curl_exec($curl);
    curl_close($curl);
    return $return_data;
};

header('Content-Type: text/html; charset=utf-8');
set_time_limit(0);
require_once("autoload-linux.php");

use \LeanCloud\Client;
use \LeanCloud\LeanObject;
use \LeanCloud\Query;

header("Content-Type: text/html; charset=utf-8");
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
Client::initialize('p3DseF72y38R0vYItqEBBdJc-MdYXbMMI', 'CUwwobi3vLqfrTmlRWmtfuIj', '4W9Y1SUxPOkJl861XVjItAjd');
$query = new Query("Metadata");
if (preg_match("/zh/i", $lang)) {
    echo "<p>SMMWE Cloud 统计数据</p>";

    echo "<table border=\"1\">";

    echo "<tr>";
    echo "<td>API 版本</td>";
    echo "<td>" . "V3" . "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>云端关卡数量</td>";
    echo "<td>" . strval(get_max_files()) . "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>云端存储占用</td>";
    echo "<td>" . get_storage() . "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>云端元数据数量</td>";
    echo "<td>" . strval($query->count()) . "</td>";
    echo "</tr>";

    echo "</table>";

    echo "<p>运行于 " . php_uname() . php_sapi_name() . ", PHP版本 " . PHP_VERSION . "</p>";

    echo "<p>" . $_SERVER['SERVER_SOFTWARE'] . $_SERVER['PROCESSOR_IDENTIFIER'] .  $_SERVER['REMOTE_ADDR'] . "</p>";

} elseif (preg_match("/en/i", $lang)) {
    echo "<p>SMMWE Cloud statistics</p>";

    echo "<table border=\"1\">";

    echo "<tr>";
    echo "<td>API Version</td>";
    echo "<td>" . "V3" . "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>Level count</td>";
    echo "<td>" . strval(get_max_files()) . "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>Online storage</td>";
    echo "<td>" . get_storage() . "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>Metadata count</td>";
    echo "<td>" . strval($query->count()) . "</td>";
    echo "</tr>";

    echo "</table>";

    echo "<p>Running on " . php_uname() . php_sapi_name() . ", PHP Version " . PHP_VERSION . "</p>";

    echo "<p>" . $_SERVER['SERVER_SOFTWARE'] . $_SERVER['PROCESSOR_IDENTIFIER'] .  $_SERVER['REMOTE_ADDR'] . "</p>";
} elseif (preg_match("/es/i", $lang)) {
    echo "<p>SMMWE Cloud estadisticas</p>";

    echo "<table border=\"1\">";

    echo "<tr>";
    echo "<td>API Version</td>";
    echo "<td>" . "V3" . "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>Conteo de niveles</td>";
    echo "<td>" . strval(get_max_files()) . "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>Almacenamiento en linea</td>";
    echo "<td>" . get_storage() . "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>Conteo de metadatos</td>";
    echo "<td>" . strval($query->count()) . "</td>";
    echo "</tr>";
    
    echo "</table>";

    echo "<p>El servidor se esta ejecutando en " . php_uname() . php_sapi_name() . ", PHP Version " . PHP_VERSION . "</p>";

    echo "<p>" . $_SERVER['SERVER_SOFTWARE'] . $_SERVER['PROCESSOR_IDENTIFIER'] .  $_SERVER['REMOTE_ADDR'] . "</p>";
};
?> 
