<?php
	//Redirect external
	$ip = '192.168.1.';
	if (substr($_SERVER['REMOTE_ADDR'], 0, strlen($ip)) !== $ip) {
	    header("Location: outside.php");
		die();
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
?>