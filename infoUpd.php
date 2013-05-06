<?php
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
			$output = preg_replace("!(\d+:\d+:\d+)(.*) \d+ \w+,.+(\d+\.\d+), (\d+\.\d+), (\d+\.\d+)!", "$1 $3 $4 $5 $2", $out2[0]);
			echo $output;
			break;
		case "disk":
			exec('df -h /media/HDE', $out);
			$output = preg_split("![\s,]+!", $out[1]);
			$output2 = preg_replace("!G!", ' ', $output[3]);
			echo $output2;
			echo " ";
			exec('du -h /media/HDE -d 1', $out2);
			$output3 = preg_replace("!G!", '', $out2[0]);
			echo $output3 . " ";
			$output3 = preg_replace("!G!", '', $out2[1]);
			echo $output3 . " ";
			$output3 = preg_replace("!G!", '', $out2[2]);
			echo $output3 . " ";
			$output3 = preg_replace("!G!", '', $out2[3]);
			echo $output3;
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
			if ($commandName == "background") exec("($command) >/dev/null 2>/dev/null &");
			else $out = exec("$command");
			if ($out == NULL and !$altError) echo '<script type="text/javascript"> showError("Error in command '.$commandName.' ('.$command.'), or not return value."); </script>';
			break;
	}
?>