<?php
function tr($hosts){

	$i = 0;
	foreach ($hosts as $host) {
		$hostarr = explode(PHP_EOL,$host);
		$prcloud[$i] = substr($host[0],0,strpos($host[0],"="));
		$i++;
	}
	$prstr = "";
	foreach ($prcloud as $tmp){
		$prstr = $prstr.$tmp.",";
	}
	echo <<<eof
[Proxy Group]
eof;
	echo "rixCloud = select,".$prstr;
	echo <<<eof

eof;
	echo "Stream Services = select,rixCloud,".$prstr;
	echo <<<eof

Apple Services = select,rixCloud,DIRECT

eof;
?>
