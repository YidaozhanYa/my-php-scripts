<?php

ini_set("display_errors", 0);
error_reporting(0);
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_WARNING); 

require_once("autoload-linux.php");

use \LeanCloud\Client;
use \LeanCloud\LeanObject;
use \LeanCloud\Query;

function gen_metadata_by_name($level_name_args)
{
	Client::initialize('p3DseF72y38R0vYItqEBBdJc-MdYXbMMI', 'CUwwobi3vLqfrTmlRWmtfuIj', '4W9Y1SUxPOkJl861XVjItAjd');
	$query = new Query("Metadata");
	$query->equalTo("level_name", $level_name_args);
	$query->select("-level_name","-objectId","-createdAt","-updatedAt");
	$metadatas_query = $query->first();
	//$return_data = $query->find();
	$return_data['level_name']=$level_name_args;
	$return_data['level_id']=$metadatas_query->get("level_id");
	$return_data['level_author']=$metadatas_query->get("level_author");
	$return_data['level_apariencia']=$metadatas_query->get("level_apariencia");
	$return_data['level_entorno']="0";
	$return_data['level_label1']=$metadatas_query->get("level_label1");
	$return_data['level_label2']=$metadatas_query->get("level_label2");
	$return_data['level_date']=$metadatas_query->get("level_date");
	return $return_data;
};

function object_array($array)
{
    if (is_object($array)) {
        $array = (array)$array;
    }
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            $array[$key] = object_array($value);
        }
    }
    return $array;
};

define('etiquetas_es', [
	'Tradicional',
	'Puzles',
	'Contrarreloj',
	'Autoavance',
	'Automatismos',
	'Corto pero intenso',
	'Competitivo',
	'Tematico',
	'Música',
	'Artístico',
	'Habilidad',
	'Disparos',
	'Contra jefes',
	'En solitario',
	'Link'
]);

define('etiquetas_en', [
	'Standard',
	'Puzzle-solving',
	'Speedrun',
	'Autoscroll',
	'Auto-mario',
	'Short and Sweet',
	'Multiplayer Versus',
	'Themed',
	'Music',
	'Art',
	'Technical',
	'Shooter',
	'Boss battle',
	'Single player',
	'Link'
]);

define('etiquetas_zh', [
	'标准',
	'解谜',
	'计时挑战',
	'自动卷轴',
	'自动马力欧',
	'一次通过',
	'多人对战',
	'机关设计',
	'音乐',
	'美术',
	'技巧',
	'射击',
	'BOSS战',
	'单打',
	'林克'
]);

header('Content-Type: text/html; charset=utf-8');
set_time_limit(0);

$level_name = rawurldecode(str_replace('levelName=%22','',str_replace('.swe%22', '', $_SERVER['QUERY_STRING'])));

$metadatas = gen_metadata_by_name($level_name);


$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
if (preg_match("/zh/i", $lang)) {
	if (is_null($metadatas)) {
		echo '<p>' . '<font size="5">' . $level_name . '</font>' . '</p>';
		echo '<p>' . '获取关卡信息失败，本关卡不存在于数据库中。' . '</p>';
		echo '<p>' . '目前网页端只支持显示私服中关卡的详细信息，请在私服中游玩一次本关后重试。' . '</p>';
	} else {
		echo '<p>' . '<font size="5">' . $level_name . '</font>' . '</p>';
		echo '<p>' . "关卡ID：" . $metadatas['level_id'] . '</p>';
		echo '<p>' . "作者：" . $metadatas['level_author'] . '</p>';
		echo '<p>' . "日期：" . $metadatas['level_date'] . '</p>';
		echo '<br/>';
		if ($metadatas['level_apariencia'] == '0') {
			echo '<p>' . "游戏风格：" . "超级马力欧兄弟" . '</p>';
		} elseif ($metadatas['level_apariencia'] == '1') {
			echo '<p>' . "游戏风格：" . "超级马力欧兄弟 3" . '</p>';
		} elseif ($metadatas['level_apariencia'] == '2') {
			echo '<p>' . "游戏风格：" . "超级马力欧世界" . '</p>';
		} elseif ($metadatas['level_apariencia'] == '1') {
			echo '<p>' . "游戏风格：" . "New 超级马力欧兄弟 U" . '</p>';
		};
		echo '<p>' . "关卡标签：" . etiquetas_zh[$metadatas['level_label1']] . "，" . etiquetas_zh[$metadatas['level_label2']] . '</p>';
	};
} elseif (preg_match("/en/i", $lang)) {
	if (is_null($metadatas)) {
		echo '<p>' . '<font size="5">' . $level_name . '</font>' . '</p>';
		echo '<p>' . 'Failed to get level information: This level does not exist in the database.' . '</p>';
		echo '<p>' . 'Currently, web version only supports displaying the information of the level loaded in the private server. Please play this level once in the private server, then try again.' . '</p>';
	} else {
		echo '<p>' . '<font size="5">' . $level_name . '</font>' . '</p>';
		echo '<p>' . "Level ID: " . $metadatas['level_id'] . '</p>';
		echo '<p>' . "Maker: " . $metadatas['level_author'] . '</p>';
		echo '<p>' . "Created at " . $metadatas['level_date'] . '</p>';
		echo '<br/>';
		if ($metadatas['level_apariencia'] == '0') {
			echo '<p>' . "Game Style: " . "Super Mario Bros." . '</p>';
		} elseif ($metadatas['level_apariencia'] == '1') {
			echo '<p>' . "Game Style: " . "Super Mario Bros. 3" . '</p>';
		} elseif ($metadatas['level_apariencia'] == '2') {
			echo '<p>' . "Game Style: " . "Super Mario World" . '</p>';
		} elseif ($metadatas['level_apariencia'] == '1') {
			echo '<p>' . "Game Style: " . "New Super Mario Bros. U" . '</p>';
		};
		echo '<p>' . "Level Tags: " . etiquetas_en[$metadatas['level_label1']] . ", " . etiquetas_en[$metadatas['level_label2']] . '</p>';
	};
} elseif (preg_match("/es/i", $lang)) {
	if (is_null($metadatas)) {
		echo '<p>' . '<font size="5">' . $level_name . '</font>' . '</p>';
		echo '<p>' . 'No se pudo obtener la información del nivel: este nivel no existe en la base de datos.' . '</p>';
		echo '<p>' . 'Actualmente, la versión web solo admite mostrar la información del nivel cargado en el servidor privado. Juega este nivel una vez en el servidor privado y vuelve a intentarlo.' . '</p>';
	} else {
		echo '<p>' . '<font size="5">' . $level_name . '</font>' . '</p>';
		echo '<p>' . "ID del Nivel: " . $metadatas['level_id'] . '</p>';
		echo '<p>' . "Creador: " . $metadatas['level_author'] . '</p>';
		echo '<p>' . "Creado en " . $metadatas['level_date'] . '</p>';
		echo '<br/>';
		if ($metadatas['level_apariencia'] == '0') {
			echo '<p>' . "Estilo de Juego: " . "Super Mario Bros." . '</p>';
		} elseif ($metadatas['level_apariencia'] == '1') {
			echo '<p>' . "Estilo de Juego: " . "Super Mario Bros. 3" . '</p>';
		} elseif ($metadatas['level_apariencia'] == '2') {
			echo '<p>' . "Estilo de Juego: " . "Super Mario World" . '</p>';
		} elseif ($metadatas['level_apariencia'] == '1') {
			echo '<p>' . "Estilo de Juego: " . "New Super Mario Bros. U" . '</p>';
		};
		echo '<p>' . "Etiquetas de Nivel: " . etiquetas_es[$metadatas['level_label1']] . ", " . etiquetas_es[$metadatas['level_label2']] . '</p>';
	};
};
?>



<html>

<head>
	<?php //<style type="text/css">
		//body {
		//	font-size: 16px;
		//}
	//</style> ?>
	<script src="//cdn.jsdelivr.net/npm/valine@latest/dist/Valine.min.js"></script>
</head>

<body>
	<div id="vcomments"></div>
	<script>
		document.getElementById("url").setAttribute("style", "display:none");

		function GetQueryString(name) {
			var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
			var r = window.location.search.substr(1).match(reg);
			if (r != null) return unescape(r[2]);
			return null;
		}
		new Valine({
			el: '#vcomments',
			appId: 'zoX8kazyGBliRB8slCeYbOMI-MdYXbMMI',
			appKey: 'ayoqJFfEYQj3teSHqfK03JJo',
			placeholder: '来给 ' + GetQueryString("levelName=\"").replace(".swe\"", "")+ ' 发条评论吧~',
			path: 'smmweCloud/LevelComment/' + GetQueryString("levelName").replace("\"", "").replace("\"", ""),
			meta: ['nick', 'mail'],
			pageSize: 5,
			enableQQ: true,
			requiredFields: ['nick', 'qq'],
			emojiMaps: {

				"doge": "//www.helloimg.com/images/2021/03/27/BpWbcT.png",
				"动态doge": "//www.helloimg.com/images/2021/03/27/BpWSQc.gif",
				"NO": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/NO.gif",
				"OK": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/OK.gif",
				"亲亲": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/亲亲.gif",
				"偷笑": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/偷笑.gif",
				"傲慢": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/傲慢.gif",
				"再见": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/再见.gif",
				"冷汗": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/冷汗.gif",
				"勾引": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/勾引.gif",
				"发呆": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/发呆.gif",
				"发怒": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/发怒.gif",
				"发抖": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/发抖.gif",
				"可怜": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/可怜.gif",
				"可爱": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/可爱.gif",
				"右哼哼": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/右哼哼.gif",
				"吐": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/吐.gif",
				"吓": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/吓.gif",
				"吻": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/吻.gif",
				"呲牙": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/呲牙.gif",
				"咒骂": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/咒骂.gif",
				"哈欠": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/哈欠.gif",
				"嗅大了": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/嗅大了.gif",
				"嘘": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/嘘.gif",
				"困": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/困.gif",
				"坏笑": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/坏笑.gif",
				"大兵": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/大兵.gif",
				"大哭": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/大哭.gif",
				"奋斗": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/奋斗.gif",
				"害羞": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/害羞.gif",
				"尴尬": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/尴尬.gif",
				"左哼哼": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/左哼哼.gif",
				"差劲": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/差劲.gif",
				"强": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/强.gif",
				"弱": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/弱.gif",
				"得意": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/得意.gif",
				"微笑": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/微笑.gif",
				"心": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/心.gif",
				"快哭了": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/快哭了.gif",
				"心碎": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/心碎.gif",
				"怄火": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/怄火.gif",
				"惊恐": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/惊恐.gif",
				"惊讶": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/惊讶.gif",
				"憨笑": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/憨笑.gif",
				"抓狂": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/抓狂.gif",
				"折磨": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/折磨.gif",
				"抠鼻": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/抠鼻.gif",
				"抱拳": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/抱拳.gif",
				"拥抱": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/拥抱.gif",
				"拳头": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/拳头.gif",
				"挥动": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/挥动.gif",
				"握手": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/握手.gif",
				"撇嘴": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/撇嘴.gif",
				"擦汗": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/擦汗.gif",
				"敲打": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/敲打.gif",
				"晕": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/晕.gif",
				"枪": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/枪.gif",
				"流汗": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/流汗.gif",
				"流泪": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/流泪.gif",
				"激动": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/激动.gif",
				"熊猫": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/熊猫.gif",
				"爆筋": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/爆筋.gif",
				"爱你": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/爱你.gif",
				"猪头": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/猪头.gif",
				"献吻": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/献吻.gif",
				"疑问": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/疑问.gif",
				"白眼": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/白眼.gif",
				"睡": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/睡.gif",
				"胜利": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/胜利.gif",
				"色": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/色.gif",
				"药丸": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/药丸.gif",
				"菜刀": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/菜刀.gif",
				"街舞": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/街舞.gif",
				"衰": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/衰.gif",
				"西瓜": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/西瓜.gif",
				"调皮": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/调皮.gif",
				"购物": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/购物.gif",
				"转圈": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/转圈.gif",
				"邮件": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/邮件.gif",
				"鄙视": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/鄙视.gif",
				"酷": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/酷.gif",
				"钱": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/钱.gif",
				"闪电": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/闪电.gif",
				"鼓掌": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/鼓掌.gif",
				"骷髅": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/骷髅.gif",
				"香蕉": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/香蕉.gif",
				"饭": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/饭.gif",
				"饥饿": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/饥饿.gif",
				"难过": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/难过.gif",
				"阴险": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/阴险.gif",
				"闹钟": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/闹钟.gif",
				"闭嘴": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/qq/闭嘴.gif",
				"haha": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/haha.png",
				"OK": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/OK.png",
				"what": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/what.png",
				"不高兴": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/不高兴.png",
				"乖": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/乖.png",
				"你懂的": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/你懂的.png",
				"便便": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/便便.png",
				"勉强": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/勉强.png",
				"吐": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/吐.png",
				"吐舌": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/吐舌.png",
				"呀咩爹": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/呀咩爹.png",
				"呵呵": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/呵呵.png",
				"哈哈": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/哈哈.png",
				"啊": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/啊.png",
				"喷": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/喷.png",
				"大拇指": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/大拇指.png",
				"太开心": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/太开心.png",
				"委屈": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/委屈.png",
				"小乖": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/小乖.png",
				"小红脸": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/小红脸.png",
				"彩虹": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/彩虹.png",
				"心碎": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/心碎.png",
				"怒": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/怒.png",
				"惊哭": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/惊哭.png",
				"惊讶": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/惊讶.png",
				"懒得理": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/懒得理.png",
				"手纸": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/手纸.png",
				"挖鼻": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/挖鼻.png",
				"捂嘴笑": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/捂嘴笑.png",
				"星星月亮": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/星星月亮.png",
				"汗": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/汗.png",
				"沙发": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/沙发.png",
				"泪": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/泪.png",
				"滑稽": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/滑稽.png",
				"犀利": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/犀利.png",
				"狂汗": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/狂汗.png",
				"玫瑰": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/玫瑰.png",
				"疑问": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/疑问.png",
				"真棒": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/真棒.png",
				"礼物": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/礼物.png",
				"睡觉": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/睡觉.png",
				"笑尿": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/笑尿.png",
				"笑眼": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/笑眼.png",
				"红领巾": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/红领巾.png",
				"胜利": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/胜利.png",
				"花心": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/花心.png",
				"茶杯": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/茶杯.png",
				"药丸": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/药丸.png",
				"蛋糕": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/蛋糕.png",
				"蜡烛": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/蜡烛.png",
				"鄙视": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/鄙视.png",
				"酷": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/酷.png",
				"酸爽": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/酸爽.png",
				"钱币": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/钱币.png",
				"阴险": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/阴险.png",
				"音乐": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/音乐.png",
				"香蕉": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/香蕉.png",
				"黑线": "https://cdn.jsdelivr.net/gh/volantis-x/cdn-emoji@1.0.0/tieba/黑线.png",
				"tv-doge": "//i0.hdslb.com/bfs/emote/6ea59c827c414b4a2955fe79e0f6fd3dcd515e24.png",
				"tv-亲亲": "//i0.hdslb.com/bfs/emote/a8111ad55953ef5e3be3327ef94eb4a39d535d06.png",
				"tv-偷笑": "//i0.hdslb.com/bfs/emote/bb690d4107620f1c15cff29509db529a73aee261.png",
				"tv-再见": "//i0.hdslb.com/bfs/emote/180129b8ea851044ce71caf55cc8ce44bd4a4fc8.png",
				"tv-冷漠": "//i0.hdslb.com/bfs/emote/b9cbc755c2b3ee43be07ca13de84e5b699a3f101.png",
				"tv-发怒": "//i0.hdslb.com/bfs/emote/34ba3cd204d5b05fec70ce08fa9fa0dd612409ff.png",
				"tv-发财": "//i0.hdslb.com/bfs/emote/34db290afd2963723c6eb3c4560667db7253a21a.png",
				"tv-可爱": "//i0.hdslb.com/bfs/emote/9e55fd9b500ac4b96613539f1ce2f9499e314ed9.png",
				"tv-吐血": "//i0.hdslb.com/bfs/emote/09dd16a7aa59b77baa1155d47484409624470c77.png",
				"tv-呆": "//i0.hdslb.com/bfs/emote/fe1179ebaa191569b0d31cecafe7a2cd1c951c9d.png",
				"tv-呕吐": "//i0.hdslb.com/bfs/emote/9f996894a39e282ccf5e66856af49483f81870f3.png",
				"tv-困": "//i0.hdslb.com/bfs/emote/241ee304e44c0af029adceb294399391e4737ef2.png",
				"tv-坏笑": "//i0.hdslb.com/bfs/emote/1f0b87f731a671079842116e0991c91c2c88645a.png",
				"tv-大佬": "//i0.hdslb.com/bfs/emote/093c1e2c490161aca397afc45573c877cdead616.png",
				"tv-大哭": "//i0.hdslb.com/bfs/emote/23269aeb35f99daee28dda129676f6e9ea87934f.png",
				"tv-委屈": "//i0.hdslb.com/bfs/emote/d04dba7b5465779e9755d2ab6f0a897b9b33bb77.png",
				"tv-害羞": "//i0.hdslb.com/bfs/emote/a37683fb5642fa3ddfc7f4e5525fd13e42a2bdb1.png",
				"tv-尴尬": "//i0.hdslb.com/bfs/emote/7cfa62dafc59798a3d3fb262d421eeeff166cfa4.png",
				"tv-微笑": "//i0.hdslb.com/bfs/emote/70dc5c7b56f93eb61bddba11e28fb1d18fddcd4c.png",
				"tv-思考": "//i0.hdslb.com/bfs/emote/90cf159733e558137ed20aa04d09964436f618a1.png",
				"tv-惊吓": "//i0.hdslb.com/bfs/emote/0d15c7e2ee58e935adc6a7193ee042388adc22af.png",
				"热词系列-知识增加": "//i0.hdslb.com/bfs/emote/142409b595982b8210b2958f3d340f3b47942645.png@112w_112h.png",
				"热词系列-好家伙": "//i0.hdslb.com/bfs/emote/63ec80dea3066bd9f449ba999ba531fa61f7b4eb.png@112w_112h.png",
				"热词系列-芜湖起飞": "//i0.hdslb.com/bfs/emote/78d04c6ce78a613c90d510cd45fe7e25c57ba00b.png@112w_112h.png",
				"热词系列-爷青回": "//i0.hdslb.com/bfs/emote/a26189ff1e681bddef7f6533f9aabe7604731a3e.png@112w_112h.png",
				"热词系列-梦幻联动": "//i0.hdslb.com/bfs/emote/4809416be5ca787c2ec3e897e4fd022a58da6e0e.png@112w_112h.png",
				"热词系列-泪目": "//i0.hdslb.com/bfs/emote/bba3703ab90b7d16fe9dbcb85ed949db687f8331.png@112w_112h.png",
				"热词系列-保护": "//i0.hdslb.com/bfs/emote/55f8f6445ca7c3170cdfc5b16036abf639ce9b57.png@112w_112h.png",
				"热词系列-害怕": "//i0.hdslb.com/bfs/emote/d77e2de26da143249f0c0ad7a608c27152c985bf.png@112w_112h.png",
				"热词系列-爱了爱了": "//i0.hdslb.com/bfs/emote/2a165b555ba20391316366c664ed7891883dc5aa.png@112w_112h.png",
				"热词系列-吹爆": "//i0.hdslb.com/bfs/emote/b528220f9c37256ed6a37f05bf118e44b08b81e5.png@112w_112h.png",
				"热词系列-三连": "//i0.hdslb.com/bfs/emote/21f15fe11b7a84d2f2121c16dec50a4e4556f865.png@112w_112h.png",
				"热词系列-可以": "//i0.hdslb.com/bfs/emote/e08543c71202b36c590094417fcfbb80c3506cd8.png@112w_112h.png",
				"热词系列-希望没事": "//i0.hdslb.com/bfs/emote/6c0d2e6c486d1ba5afd6204a96e102652464a01d.png@112w_112h.png",
				"热词系列-打卡": "//i0.hdslb.com/bfs/emote/a9cf77c78e1b9b40aa3ed4862402fba008ee2f51.png@112w_112h.png",
				"热词系列-skr": "//i0.hdslb.com/bfs/emote/bd285ff94db16ad52557c3effe930d64663e8375.png@112w_112h.png",
				"热词系列-battle": "//i0.hdslb.com/bfs/emote/f2f81c8e47db6252becd633a5d1ee14e15df2ea8.png@112w_112h.png",
				"热词系列-DNA": "//i0.hdslb.com/bfs/emote/f6eb74f8230588f61a298af89061a7d75c5762e5.png@112w_112h.png",
				"热词系列-妙啊": "//i0.hdslb.com/bfs/emote/0e98299d7decf5eaffad854977946075c3e91cb8.png@112w_112h.png",
				"热词系列-这次一定": "//i0.hdslb.com/bfs/emote/a01ca28923daa7cc896c42f27deb4914e20dd572.png@112w_112h.png",
				"热词系列-AWSL": "//i0.hdslb.com/bfs/emote/c37f88cf799f9badf9d84b7671dc3dd98c0fc0c2.png@112w_112h.png",
				"热词系列-递话筒": "//i0.hdslb.com/bfs/emote/98e6950e39fbb4dd1c576042063ca632074070ba.png@112w_112h.png",
				"热词系列-你细品": "//i0.hdslb.com/bfs/emote/535e00658e7e47966f154d3a167fa2365ebc4321.png@112w_112h.png",
				"热词系列-咕咕": "//i0.hdslb.com/bfs/emote/d8065c2e7ce48c929317a94553499a46fecc262a.png@112w_112h.png",
				"热词系列-标准结局": "//i0.hdslb.com/bfs/emote/3de98174b510cf7dc5fd1bd08c5d881065e79137.png@112w_112h.png",
				"热词系列-危": "//i0.hdslb.com/bfs/emote/5cc6c3357c4df544dd8de9d5c5c0cec97c7c9a56.png@112w_112h.png",
				"热词系列-张三": "//i0.hdslb.com/bfs/emote/255a938f39cea625032b6650036b31aa26c50a3c.png@112w_112h.png",
				"热词系列-害": "//i0.hdslb.com/bfs/emote/cbe798a194612958537c5282fcca7c3bcd2aa15c.png@112w_112h.png",
				"热词系列-我裂开了": "//i0.hdslb.com/bfs/emote/29bd57ec4e8952880fea6c9e47aee924e91f10c4.png@112w_112h.png",
				"热词系列-有内味了": "//i0.hdslb.com/bfs/emote/7ca61680a905b5b6e2e335c630e725b648b03b4d.png@112w_112h.png",
				"热词系列-猛男必看": "//i0.hdslb.com/bfs/emote/c97064450528a0e45c7e7c365a15fbb13fd61d8c.png@112w_112h.png",
				"热词系列-奥力给": "//i0.hdslb.com/bfs/emote/c9b8683827ec6c00fea5327c9bec14f581cef2aa.png@112w_112h.png",
				"热词系列-问号": "//i0.hdslb.com/bfs/emote/c1d1e76c12180adc8558f47006fe0e7ded4154bb.png@112w_112h.png",
				"热词系列-我哭了": "//i0.hdslb.com/bfs/emote/9e0b3877d649aaf6538fbdd3f937e240a9d808e4.png@112w_112h.png",
				"热词系列-高产": "//i0.hdslb.com/bfs/emote/9db817cba4a7f4a42398f3b2ec7c0a8e0c247c42.png@112w_112h.png",
				"热词系列-我酸了": "//i0.hdslb.com/bfs/emote/a8cbf3f6b8cd9377eeb15b9172f3cd683b2e4650.png@112w_112h.png",
				"热词系列-真香": "//i0.hdslb.com/bfs/emote/e68497c775feaac1c3b1a6cd63a50cfb11b767c4.png@112w_112h.png",
				"热词系列-我全都要": "//i0.hdslb.com/bfs/emote/d424d1ad8d14c1c9b8367842bc68c658b9229bc1.png@112w_112h.png",
				"热词系列-神仙UP": "//i0.hdslb.com/bfs/emote/a49e0d0db1e7d35a0f7411be13208951ab448f03.png@112w_112h.png",
				"热词系列-你币有了": "//i0.hdslb.com/bfs/emote/84820c2b147a8ca02f3c4006b63f76c6313cbfa0.png@112w_112h.png",
				"热词系列-不愧是你": "//i0.hdslb.com/bfs/emote/9ff2e356797c57ee3b1675ade0883d2d2247be9b.png@112w_112h.png",
				"热词系列-锤": "//i0.hdslb.com/bfs/emote/35668cc12ae25b9545420e4a85bf21a0bfc03e5d.png@112w_112h.png",
				"热词系列-秀": "//i0.hdslb.com/bfs/emote/50782fbf5d9b7f48f9467b5c53932981e321eedc.png@112w_112h.png",
				"热词系列-爷关更": "//i0.hdslb.com/bfs/emote/faad40c56447f1f8abcb4045c17ce159d113d1fd.png@112w_112h.png",
				"热词系列-有生之年": "//i0.hdslb.com/bfs/emote/f41fdafe2d0fbb8e8bc1598d2cf37e355560103a.png@112w_112h.png",
				"热词系列-镇站之宝": "//i0.hdslb.com/bfs/emote/24e7a6a6e6383c987215fb905e3ee070aca259b5.png@112w_112h.png",
				"热词系列-我太南了": "//i0.hdslb.com/bfs/emote/a523f3e4c63e4db1232365765d0ec452f83be97e.png@112w_112h.png",
				"热词系列-完结撒花": "//i0.hdslb.com/bfs/emote/ea9db62ff5bca8e069cd70c4233353a802835422.png@112w_112h.png",
				"热词系列-大师球": "//i0.hdslb.com/bfs/emote/f30089248dd137c568edabcb07cf67e0f6e98cf3.png@112w_112h.png",
				"热词系列-知识盲区": "//i0.hdslb.com/bfs/emote/ccc94600b321a28116081e49ecedaa4ee8728312.png@112w_112h.png",
				"热词系列-狼火": "//i0.hdslb.com/bfs/emote/33ccd3617bfa89e9d1498b13b7542b63f163e5de.png@112w_112h.png",
				"热词系列-你可真星": "//i0.hdslb.com/bfs/emote/54c8ddff400abfe388060cabfbb579280fdea1be.png@112w_112h.png",
				"2233娘-大笑": "//i0.hdslb.com/bfs/emote/16b8794be990cefa6caeba4d901b934a227ee3b8.png@112w_112h.webp",
				"2233娘-吃惊": "//i0.hdslb.com/bfs/emote/d1628c43d35b1530c0504a643ff80b6189fa0a43.png@112w_112h.webp",
				"2233娘-大哭": "//i0.hdslb.com/bfs/emote/476a2a60f6e337b8c0697a592e0aa82781f6b33b.png@112w_112h.webp",
				"2233娘-耶": "//i0.hdslb.com/bfs/emote/d7178e258a0efc969b65ccc2b1322fb235f5dff4.png@112w_112h.webp",
				"2233娘-卖萌": "//i0.hdslb.com/bfs/emote/ea893aa25355de95ab4f03c2dad3f0c58d0c159e.png@112w_112h.webp",
				"2233娘-疑问": "//i0.hdslb.com/bfs/emote/0b41f509351958dbb63d472fec0132d1bd03bd14.png@112w_112h.webp",
				"2233娘-汗": "//i0.hdslb.com/bfs/emote/247cd9df8cdf84b18368c21e3b2dd374e84c0927.png@112w_112h.webp",
				"2233娘-困惑": "//i0.hdslb.com/bfs/emote/714eeb4eae0d0933b4ff08b7df788b1982f6b940.png@112w_112h.webp",
				"2233娘-怒": "//i0.hdslb.com/bfs/emote/f31953119c51b9748016440ac0b632f779929b37.png@112w_112h.webp",
				"2233娘-委屈": "//i0.hdslb.com/bfs/emote/d9d0bf9d358af8d5761093ec66d4e3f60d963a63.png@112w_112h.webp",
				"2233娘-郁闷": "//i0.hdslb.com/bfs/emote/485203fe7100f2c8fc40b2800a18fe20b35f2f1a.png@112w_112h.webp",
				"2233娘-第一": "//i0.hdslb.com/bfs/emote/3754ee6e5985bd0bd7dfb668981f2a8733398ebd.png@112w_112h.webp",
				"2233娘-喝水": "//i0.hdslb.com/bfs/emote/695bf5429472049b52c1e0de586f8a2511195a23.png@112w_112h.webp",
				"2233娘-吐魂": "//i0.hdslb.com/bfs/emote/e999af499edf38a91ca68b1a9d2f97042c1d6734.png@112w_112h.webp",
				"2233娘-无言": "//i0.hdslb.com/bfs/emote/fdb5870f32cfaf7949e0f88a13f6feba4a48b719.png@112w_112h.webp",
				"蛆音娘-卖萌": "//i0.hdslb.com/bfs/emote/4cd1024d0c2ecee93224477946656d32c1705ccf.png@112w_112h.webp",
				"蛆音娘-吃瓜群众": "//i0.hdslb.com/bfs/emote/5d0d6cc54b508d30b4f50b6b5f7b7e1e259d84ea.png@112w_112h.webp",
				"蛆音娘-吃惊": "//i0.hdslb.com/bfs/emote/7a4cb0b644214d476ce198ddf6a7a0aa31311199.png@112w_112h.webp",
				"蛆音娘-害怕": "//i0.hdslb.com/bfs/emote/7407634bf67bfe9d7806f15d57608a1b18c2b4c2.png@112w_112h.webp",
				"蛆音娘-扶额": "//i0.hdslb.com/bfs/emote/a4d8f95baaa24821fd591a7dbeee1b869e760f59.png@112w_112h.webp",
				"蛆音娘-滑稽": "//i0.hdslb.com/bfs/emote/d3717f10ffe9787336bc39a09214270988521a67.png@112w_112h.webp",
				"蛆音娘-哼": "//i0.hdslb.com/bfs/emote/8854f1b8a82126e3b87f3a1563da5feb55b23e71.png@112w_112h.webp",
				"蛆音娘-机智": "//i0.hdslb.com/bfs/emote/e543c0a823ca915df9362283f4ae950e9e9cc2e9.png@112w_112h.webp",
				"蛆音娘-哭泣": "//i0.hdslb.com/bfs/emote/a23055546c19eba663b16370b8e072394d87ff53.png@112w_112h.webp",
				"蛆音娘-睡觉觉": "//i0.hdslb.com/bfs/emote/40ef7e6d931acb37e5514b70d13663e86dc3698b.png@112w_112h.webp",
				"蛆音娘-生气": "//i0.hdslb.com/bfs/emote/bf398cbbcfaae107d1b59aaf03895f38422e3d87.png@112w_112h.webp",
				"蛆音娘-偷看": "//i0.hdslb.com/bfs/emote/52463ded4f23649db10ba3ced662ed946c5edf0b.png@112w_112h.webp",
				"蛆音娘-吐血": "//i0.hdslb.com/bfs/emote/5772d22015e5b2b40a9fe302b5967ec7282ac848.png@112w_112h.webp",
				"蛆音娘-无语": "//i0.hdslb.com/bfs/emote/b6c763c6484ce2e48299ceb21861e46318868871.png@112w_112h.webp",
				"蛆音娘-摇头": "//i0.hdslb.com/bfs/emote/b7278f750c6f2235f41f37056d727f25d3bf781f.png@112w_112h.webp",
				"蛆音娘-疑问": "//i0.hdslb.com/bfs/emote/7750b698d15a1b8e83c0f59106e8e9cd5cb57897.png@112w_112h.webp",
				"蛆音娘-die": "//i0.hdslb.com/bfs/emote/52543025a070fde5c01a10320c9636ec3173ac99.png@112w_112h.webp",
				"蛆音娘-OK": "//i0.hdslb.com/bfs/emote/52a0dcee66c91bf123bf53bd48a269b1317d17f9.png@112w_112h.webp",
				"蛆音娘-肥皂": "//i0.hdslb.com/bfs/emote/7f1a857e9430dcf3050ce0ef5fa19aefebea6dc4.png@112w_112h.webp",
				"蛆音娘-大笑": "//i0.hdslb.com/bfs/emote/1d3355fb89c24ab3c50e5c152d8b990a290dc63e.png@112w_112h.webp",
				"喝了": "//www.helloimg.com/images/2021/03/27/BpWLLh.jpg",
				"自定义-受受": "//www.helloimg.com/images/2021/03/27/BpWHJr.jpg",
				"自定义-奶凶": "//www.helloimg.com/images/2021/03/27/BpWlV1.jpg",
				"自定义-大哭": "//www.helloimg.com/images/2021/03/27/BpW3QP.jpg",
				"自定义-颤抖": "//www.helloimg.com/images/2021/03/27/BpWxcR.jpg",
				"自定义-难受": "//www.helloimg.com/images/2021/03/27/BpWXu6.jpg",
				"自定义-开心": "//www.helloimg.com/images/2021/03/27/BpWErz.png",
				"自定义-语塞": "//www.helloimg.com/images/2021/03/27/BpWqJn.jpg",
				"自定义-生气": "//www.helloimg.com/images/2021/03/27/BpWm3A.jpg",
				"自定义-加载": "//www.helloimg.com/images/2021/03/27/BpWAZm.png",
				"自定义-哭": "//www.helloimg.com/images/2021/03/27/BpWsM5.jpg",
				"自定义-拿枪指": "//www.helloimg.com/images/2021/03/27/BpWt60.png",
				"自定义-委屈": "//www.helloimg.com/images/2021/03/27/BpWiyq.gif",
				"自定义-害怕": "//www.helloimg.com/images/2021/03/27/BpW23K.gif",

			}
		})
	</script>
</body>

</html>