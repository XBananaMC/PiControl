<html>
	<head>
	    <link href="style.css" rel="stylesheet" type="text/css">
	    <script src="jquery-1.9.1.min.js"></script>
	    <title>Pi Control</title>
	</head>
	<?php
		include 'settings.php';
	?>
	<body>
		<script type="text/javascript">

			function goBack()
			{
				window.location="/";
			}

			function execCommand(command, commandName) {
				$.get(
				    "infoUpd.php",
				    {
				    	command: command,
				    	commandName: commandName
					},
				    function(dat) {
				        updateButtons();
				    }
				);
			}

			function startXBMC() {
				execCommand("sudo /sbin/initctl start xbmc", "<?php echo $lang['Start_XBMC'];?>");
			}

			function stopXBMC() {
				execCommand("sudo /sbin/initctl stop xbmc", "<?php echo $lang['Stop_XBMC'];?>");
			}

			function startTransmission() {
				execCommand("sudo /etc/init.d/transmission-daemon start", "<?php echo $lang['Start_Trans'];?>");
			}

			function stopTransmission() {
				execCommand("sudo /etc/init.d/transmission-daemon stop", "<?php echo $lang['Stop_Trans'];?>");
			}

			function givePermissions() {
				execCommand("sudo chmod -R 777 /media/HDE; sudo chmod 777 /media/HDE", "<?php echo $lang['Give_Perm'];?>");
			}

			function shutdown() {
				var r = confirm("<?php echo $lang['Sure?'];?>");
				if (r) execCommand("sudo /sbin/shutdown -h now", "<?php echo $lang['Shutdown'];?>");
			}

			function goTransmission() {
				window.open("http://<?php echo $transmissionUser.":".$transmissionPassword."@".$ip.":".$transmissionPort;?>", "_blank");
			}

			function showInfo() {
				
				document.getElementById("filler").innerHTML = '<object data="info.php">';
				document.body.style.height = "2000px";
			}

			function showBrowser() {
				document.getElementById("filler").innerHTML = '<object data="browser.php">';
			}

			function showScheduler() {
				document.getElementById("filler").innerHTML = '<object data="scheduler.php">';
			}

			function showRadio() {
				document.getElementById("filler").innerHTML = '<object data="radio.php">';
			}

		    function hideURLbar(){
		        window.scrollTo(0,1);
		    }

		    function updateButtons() {
		    	var html;
		    	$.get(
				    "infoUpd.php",
				    {
				    	command: "xmbcPID",
					},
				    function(dat) {
				        if (dat) html = '<button type="button" onclick="stopXBMC()"><?php echo $lang['Stop_XBMC'];?></button> ';
				        else html = '<button type="button" onclick="startXBMC()"><?php echo $lang['Start_XBMC'];?></button> ';

				    	$.get(
						    "infoUpd.php",
						    {
						    	command: "transmissionPID",
							},
						    function(dat) {
						        if (dat) html += '<button type="button" onclick="stopTransmission()"><?php echo $lang['Stop_Trans'];?></button> ' + 
						        				 '<button type="button" onclick="goTransmission()">Transmission</button> ';
						        else html += '<button type="button" onclick="startTransmission()"><?php echo $lang['Start_Trans'];?></button> ';

						        html += '<button type="button" onclick="givePermissions()"><?php echo $lang['Give_Perm'];?></button> ' +
										'<button type="button" style="background-color:red" onclick="shutdown()"><?php echo $lang['Shutdown'];?></button> ';

		    							document.getElementById("buttons").innerHTML = html;
						    }
						);
				    }
				);			
		    }

		    addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		    addEventListener("load", function() { setTimeout(updateButtons, 0); }, false);
		    //addEventListener("load", function() { setTimeout(showInfo, 0); }, false);

	    </script>

	    <div class="banner">Pi Control</div>

	    <div class="block" id="buttons"></div>

		<div class="block" id="moreButtons">
			<button type="button" onclick="showInfo()"><?php echo $lang['Info'];?></button>
			<button type="button" onclick="showBrowser()"><?php echo $lang['Browser'];?></button>
			<button type="button" onclick="showScheduler()"><?php echo $lang['Scheduler'];?></button>
			<button type="button" onclick="showRadio()"><?php echo $lang['Radio'];?></button>
		</div>  

		<div class="filler" id="filler"> </div>
	</body>
</html>