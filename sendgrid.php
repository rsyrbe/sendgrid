<?php

function checker($api_key){
	$ch = curl_init("https://api.sendgrid.com/v3/user/credits");
	$hr = array(
		"Authorization:Bearer {$api_key}",
		"Accept:application/json"
	);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $hr);
	return curl_exec($ch);
}

$b = "--------------------------------------------------------------------------------------------------------------\n";
echo $b;
echo "[?] List apikey : "; $sendgrid_apikey = file_get_contents(trim(fgets(STDIN)));
$list_apikey = explode("\n",$sendgrid_apikey);

foreach($list_apikey as $api_key){
	echo $b;
	echo "[+] ".$api_key."\n";
	$r = checker($api_key);
	$res = json_decode($r);
	foreach($res as $y=>$n){
		if($y!="errors"){
			echo "[+] ".$y." = ".$n."\n";
		}
		else{
			echo "[!] ".$y." - ".$n[0]->message."\n";
		}
	}
}
echo $b;

?>