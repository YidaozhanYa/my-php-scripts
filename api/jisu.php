<?php
ini_set("display_errors", 0);
error_reporting(0);
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_WARNING); 
header("Content-type: text/plain; charset=utf-8");
$out= "vmess://".base64_encode('{"ps":"更新于 '.date('Y-m-d').'","add":"疾速PRO By 是一刀斩哒","port":"0","id":"6a3bcc08-9c77-4c02-844b-4a694c4f2fea","aid":"0","net":"tcp","type":"none","host":"","path":"","tls":"none","allowInsecure":false,"v":"2","protocol":"vmess"}');
$out=$out. PHP_EOL;
for($i=1;$i<=12;$i++){
    $json=json_decode(curl_get("https://freequick.ml/".strval($i).".json"),true)["outbounds"][0];
    $node_dict=array(
        "ps"=>"疾速PRO ".strval($i)." ".strtoupper(preg_replace("/\\d+/",'', str_replace(".fans8.xyz","",$json['settings']['vnext'][0]['address']))),
        "add"=>$json['settings']['vnext'][0]['address'],
        "port"=>$json['settings']['vnext'][0]['port'],
        "id"=>$json['settings']['vnext'][0]['users'][0]['id'],
        "aid"=>$json['settings']['vnext'][0]['users'][0]['alterId'],
        "net"=>$json['streamSettings']['network'],
        "type"=>"none",
        "host"=>$json['settings']['vnext'][0]['address'],
        "path"=>$json['streamSettings']['wsSettings']['path'],
        "tls"=>"",
        "allowInsecure"=>false,
        "v"=>"2",
        "protocol"=>$json['protocol']
    );
    $out=$out.  "vmess://".base64_encode(json_encode($node_dict,JSON_UNESCAPED_UNICODE));
    $out=$out.  PHP_EOL;
};
echo base64_encode($out);
return;


function curl_get($url){
$curl=curl_init();
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_HEADER,false);
curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl,CURLOPT_URL,$url);
$retval= curl_exec($curl);
curl_close($curl);
return $retval;
}
?> 
