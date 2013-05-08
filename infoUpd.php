<?php
	include 'settings.php';

	$command = $_REQUEST['command'];
	$commandName = $_REQUEST['commandName'];

	switch ($command) {
		case "ram":
			exec("egrep --color 'Mem|Cache|Swap' /proc/meminfo", $out);
			$output = preg_replace('!\s+!', ' ', $out);
			echo $output[0] . " ";
			echo $output[1] . " ";
			echo $output[2];
			exec('uptime', $out2);
			$output = preg_replace("!(\d+:\d+:\d+)(.*), (.*) \d+ \w+,.+(\d+\.\d+), (\d+\.\d+), (\d+\.\d+)!", "$1 $2", $out2[0]);
			echo $output;
			break;
		case "disk":
			exec('df -h '.$mediaDirectory, $out);
			$out = preg_split("![\s,]+!", $out[1]);
			$out = preg_replace("!(\d)G!", '$1', $out[3]);
			echo $out . "/". $lang['Free'] ."/";

			exec('du -h '.$mediaDirectory.' -d 1', $out);
			$out = preg_replace("!(\d)G!", "$1", $out);
			$out = preg_replace("!".$mediaDirectory."!", "", $out);
			foreach ($out as $val)
    			echo $val . "/";
			break;
		case "temp":
			exec('/opt/vc/bin/vcgencmd measure_temp', $out);
			$output = preg_replace("!temp=(\d+.\d)'C!", '$1', $out);
			echo $output[0];
			break;
		case "top":
			echo '<pre>';
			system('ps -eo pcpu,pid,user,args --sort -pcpu');
			echo '</pre>';
			break;
		case "test":
			echo '<pre>';
			system('top -b -n 1');
			echo '</pre>';
			break;
		case "xmbcPID":
			system("pidof /scripts/xbmc-watchdog.sh -x");
			break;
		case "transmissionPID":
			system("pidof /usr/bin/transmission-daemon");
			break;
		case "killAllSleep":
			exec("pidof sleep", $out);
			foreach ($out as $pid) {
				exec("kill " . $pid);
			}
			break;
		default:
			echo '<pre>';
			if ($commandName == "background") exec("($command) >/dev/null 2>/dev/null &");
			else $out = system("$command");
			echo '</pre>';
			if ($out == NULL and !$altError) echo '<script type="text/javascript"> showError("Error in command '.$commandName.' ('.$command.'), or not return value."); </script>';
			break;
	}
?>