<?php
ini_set("display_errors", 0);
error_reporting(0);
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_WARNING); 
header("Content-type: text/html; charset=utf-8");
if (is_null($_SERVER['QUERY_STRING'])==false){
    $parameters = explode("&", $_SERVER['QUERY_STRING']);
    $requests = array();
    //parameters to array
    foreach ($parameters as $v) {
        $requests = array_merge($requests, array(explode("=", $v)[0] => explode("=", $v)[1]));
    };
};

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<title>学霸题</title>";
echo "</head>";
echo "<body>";
echo "<p>学霸题，烙log</p>";
echo '<p>log<input type="text" name="dishu" id="dishu"><input type="text" name="zhenshu" id="zhenshu"></p>';
echo '<p><input type="submit" value="计算" onclick="sub();"></p>';

if (is_null($_SERVER['QUERY_STRING'])==false){
if (is_null($requests['log']) == false) {
    //算log
    $result=log(floatval($requests['log2']),floatval($requests['log']));
    if (is_nan($result)) {
        echo '<p>结果算出来：log 底数'.$requests['log'].' 真数'.$requests['log2'].' 算不出来，你是故意找茬是不是，你这表达式有问题啊'.'</p>';
    } else {
        echo '<p>结果算出来：log 底数'.$requests['log'].' 真数'.$requests['log2'].' = '.$result.'</p>';
    };
} elseif (is_null($requests['lg']) == false) {
    //算lg
    echo '<p>结果算出来：lg '.$requests['lg']." = ".log10($requests['lg']).'</p>';
} elseif (is_null($requests['ln']) == false) {
    //算ln
    echo '<p>结果算出来：ln '.$requests['ln'].' = '.log($requests['ln']).'</p>';
};
};
echo "<p>乐迪出品，必属精品</p>";
echo <<<CODE
<script>
function sub()
{
    var dishu = document.getElementById("dishu").value;
    var zhenshu = document.getElementById("zhenshu").value;
    if (dishu=='10') {
        //常用对数
        window.location.href = window.location.protocol+"//"+window.location.host+""+window.location.pathname+"?lg="+zhenshu;
    } else if (dishu=='e') {
        //自然对数
        window.location.href = window.location.protocol+"//"+window.location.host+""+window.location.pathname+"?ln="+zhenshu;
    } else {
        //log
        window.location.href = window.location.protocol+"//"+window.location.host+""+window.location.pathname+"?log="+dishu+"&log2="+zhenshu;
    };
}
</script>
CODE;
echo "</body>";
echo "</html>";
