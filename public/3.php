<?php
$host = $_SERVER['HTTP_HOST'];
$tmp =  $_SERVER['PHP_SELF'];
$host = $host.substr($tmp,0,strlen($tmp)-5);
$url = "http://$host"."prCloud.php?".$_SERVER["QUERY_STRING"] ;
$link = "surge:///install-config?url=".urlencode($url);
echo "<a href='$link'>Safari浏览器直接点我，其他浏览器长按复制到Safari中浏览</a>"
?>

