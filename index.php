<html>
	<head>
	    <link href="style.css" rel="stylesheet" type="text/css">
	    <script src="jquery-1.9.1.min.js"></script>
	</head>

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
				execCommand("sudo /sbin/initctl start xbmc", "Start xbmc");
			}

			function stopXBMC() {
				execCommand("sudo /sbin/initctl stop xbmc", "Stop xbmc");
			}

			function startTorrent() {
				execCommand("sudo /etc/init.d/transmission-daemon start", "Start torrent");
			}

			function stopTorrent() {
				execCommand("sudo /etc/init.d/transmission-daemon stop", "Stop torrent");
			}

			function givePermissions() {
				execCommand("sudo chmod -R 777 /media/HDE; sudo chmod 777 /media/HDE", "Start torrent");
			}

			function shutdown() {
				var r = confirm("Segur?");
				execCommand("sudo /sbin/shutdown -h now", "Shutting down");
			}

			function goTorrent() {
				window.open("http://transmission:1234@192.168.1.60:9091", "_blank");
			}

			function showInfo() {
				document.getElementById("filler").innerHTML = '<object data="info.php">';
			}

			function showBrowser() {
				document.getElementById("filler").innerHTML = '<object data="browser.php">';
			}

			function showTorrent() {
				document.getElementById("filler").innerHTML = '<object data="torrent.php">';
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
				        if (dat) html = '<button type="button" onclick="stopXBMC()">Stop XBMC</button> '
				        else html = '<button type="button" onclick="startXBMC()">Start XBMC</button> ';

				    	$.get(
						    "infoUpd.php",
						    {
						    	command: "transmissionPID",
							},
						    function(dat) {
						        if (dat) html += '<button type="button" onclick="stopTorrent()">Stop Transmission</button> ' + 
						        				 '<button type="button" onclick="goTorrent()">Transmission</button> ';
						        else html += '<button type="button" onclick="startTorrent()">Start Transmission</button> ';

						        html += '<button type="button" type="button" onclick="givePermissions()">Donar permissos</button>' +
										'<button type="button" type="button" style="background-color:red" onclick="shutdown()">Apagar</button>';

		    							document.getElementById("buttons").innerHTML = html;
		    							document.body.style.height = "2000px";
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
			<button type="button" type="button" onclick="showInfo()">Info</button>
			<button type="button" type="button" onclick="showBrowser()">Browser</button>
			<button type="button" type="button" onclick="showTorrent()">Torrent</button>
			<button type="button" type="button" onclick="showScheduler()">Scheduler</button>
			<button type="button" type="button" onclick="showRadio()">Radio</button>
		</div>  

		<div class="filler" id="filler"> </div>
	</body>
</html>