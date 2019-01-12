<?php
showselete();

function showselete(){
	$url = $_POST["url"];
	if ($url == "") { echo "请输入参数";return -1;}
	//echo $url;
	$hosts = get_ssr_hosts($url);
	get_head();
	get_proxy_group($hosts);
	get_foot($url);
	return 0;

}

function get_foot($url){
	echo "<input name='url' value='$url' type='hidden' >";
	echo <<<foot
<input type="submit" value="Submit" >
</form>
</body>

</html>
foot;
}
function get_head(){
	echo <<<head
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>选择各条线路</title>
</head>

<body>
<form action="3.php" method="GET" >

head;
}

function get_proxy_group($hosts) {
	//echo "get_proxy_group";
	$proxy_names = explode(":","Proxy:AbemaTV:Apple:BBC:Bahamut:HBO:Hulu:Netflix:Spotify:Telegram:YouTube:TVB:DMM");
	//print_r($proxy_names);
	foreach ($proxy_names as $proxy_name) {
		get_proxy($hosts,$proxy_name);
	}	
}

function get_proxy($hosts,$proxy_name){
	echo "<table><tr><th>选择 $proxy_name 线路需要用的服务器</th></tr><tr>";
	$i = 0;
        foreach ($hosts as $host) {
                if ($host == "") {break;}
		if ($i!=0 & $i%4 == 0) {echo"</tr><tr>";}
		echo "<td><input type='checkbox' name='$proxy_name"."[]' value='$host'>$host</td>";
               	//echo "<option value=\"$i\" >$host</option><br>";
               	$i++;
	}
	echo "</table>";
}


function get_ssr_hosts($url) {
	if ($url == "") return false;

	$file = fopen ($url, "r");
	if (!$file) {
		echo "<p>请检查url是否正确？url不需要加\"\"\n";
	        exit;
}

	$line = fgets($file);
	//echo $line;
	fclose($file);
	$str = base64_decode($line);
	//echo $str;
	$strarr = explode(PHP_EOL,$str);
	//print_r ($strarr);
	//$strarrcount = count($strarr);
	//echo $strarrcount;

	$i=0;
	foreach ($strarr as $ssr){
		$ssr = str_replace("_","+",$ssr);
		$ssr = str_replace("-","+",$ssr);
		$ssrdecode = base64_decode(substr($ssr,6,strlen($ssr)-6));
		$ssrdecode = str_replace("_","+",$ssrdecode);
		$ssrdecode = str_replace("_","+",$ssrdecode);
		//echo $ssrdecode;
		$hosts[$i] = ssr_tr($ssrdecode);	
		//echo $i;
		//echo ":";
		//echo $ssrdecode;
		//echo PHP_EOL;
		$i++;
	}
	//print_r ($hosts);
	return $hosts;
}


function ssr_tr($ssrdecode){
	        if ($ssrdecode == "") {return false;}
	        $ssrdecodearr = explode(":",$ssrdecode);
		//print_r ($ssrdecodearr);
		$passwd = base64_decode(substr($ssrdecodearr[5],0,strpos($ssrdecodearr[5],"/")));
	        $host = $ssrdecodearr[0];
	        $port = $ssrdecodearr[1];
	        $encrypt = $ssrdecodearr[3];
                $ssrdecodearr[5] = str_replace("-","+",$ssrdecodearr[5]);
		$ssrdecodearr[5] = str_replace("_","+",$ssrdecodearr[5]);
		$name = base64_decode(substr($ssrdecodearr[5],strpos($ssrdecodearr[5],"&remarks=")+strlen("&remarks="),strpos($ssrdecodearr[5],"&group=")-strpos($ssrdecodearr[5],"&remarks=")-strlen("&remarks=")));
		//echo  mb_detect_encoding($name); 
		$name = iconv("UTF-8", "UTF-8//IGNORE", $name);
		//echo $encode;
		$rtv = $name;
	        return $rtv;
}


?>
