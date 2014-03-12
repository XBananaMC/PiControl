<?php
	//Redirect external
	$ip = '192.168.1.';
	$local = '127.0.0.1';
	if (substr($_SERVER['REMOTE_ADDR'], 0, strlen($ip)) !== $ip and $_SERVER['REMOTE_ADDR'] !== $local) {
		header("Location: outside.php");
		die();
	}


	function saveLog($type, $user, $info) {
		//$type == INFO, WARNING OR ERROR
		$file = fopen("logs/".date('d-m-Y', time()).".txt","a");
		$data = $type . " " . date('H:i:s d-m-Y', time()) . " " . $user . " " . $info . "\n";
		fwrite($file, $data);
		fclose($file);
	}

	function execBackground($command) {
		exec("($command) >/dev/null 2>/dev/null &");
	}


	//Language
	include_once 'Lang/lang.ca.php';

	//Trasnmission
	$transmissionUser 		= "transmission";
	$transmissionPassword 	= "1234";
	$transmissionPort 		= "9091";

	//RaspberryPi
	$ip 					= "192.168.1.60";
	$mediaDirectory			= "/media/HDE";

	//Schedule
	$startTime 				= 2;
	$endTime 				= 10;

?>