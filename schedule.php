<?php

	include 'utilities.php';

	$start = $_REQUEST['s'];

	if ($start) {
		//Start transmission
		execBackground("sudo /etc/init.d/transmission-daemon start; sleep 30s; transmission-remote --auth=$transmissionUser:$transmissionPassword -t all -s");
		saveLog("INFO", "scheduler", "starting transmission");

		//Download rss


		//Add torrents


		//Remove overflow torrents aka remove file not found
		//exec("transmission-remote --auth=$transmissionUser:$transmissionPassword -t all -i", $out);

		//Schedule stop
		$time = ($endTime - date(G))*60 - date(i);
		if ($time <= 0) $time += 1440;
		execBackground("sleep ".$time."m; curl http://127.0.0.1/Beta/schedule.php?s=0");
		saveLog("INFO", "scheduler", "scheduled stop in $time minutes");
	}
	else {
		//Get session stats
		//exec("transmission-remote --auth=$transmissionUser:$transmissionPassword -st", $out);
		//$split = preg_split("!\(!",$out);

		//Stop transmission
		execBackground("sudo /etc/init.d/transmission-daemon stop;");
		saveLog("INFO", "scheduler", "stopping transmission");

		//schedule start
		$time = ($startTime - date(G))*60 - date(i);
		if ($time <= 0) $time += 1440;
		execBackground("sleep ".$time."m; curl http://127.0.0.1/Beta/schedule.php?s=1");
		saveLog("INFO", "scheduler", "scheduled start in $time minutes");
	}
?>