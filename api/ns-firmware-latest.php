<?php
ini_set("display_errors", 0);
error_reporting(0);
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_WARNING); 
header("Content-type: text/plain; charset=utf-8");
$curl=curl_init();
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_HEADER,false);
curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl,CURLOPT_URL,"https://archive.org/download/nintendo-switch-global-firmwares/Official%20Global%20Firmware%20MD5%20Hashs.txt");
$fwlist=curl_exec($curl);
$fwlist=explode("\t",substr($fwlist,strripos($fwlist,"----------------------------------")+34));
foreach ($fwlist as $line) {
    if (strpos($line,"Firmware")!==false) {
        $fwlist2[]=substr($line,strripos($line,"Firmware ")+9);
    };
};
$latest=intval(explode(".",$fwlist2[0])[0]);
foreach ($fwlist2 as $line){
    if (intval(explode(".",$line)[0])>($latest-2)) {
        $fwlist3[]=$line;
    };
};
echo join(" ",$fwlist3);
return;