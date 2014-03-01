<html>
	<head>
		<link href="css/style.css" rel="stylesheet" type="text/css">
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<script src="js/jquery-1.9.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>

		<link rel="shortcut icon" href="favicon.ico"/>

		<title>Pi Control</title>
	</head>
	<?php
		include 'utilities.php';
	?>
	<body>
		<script type="text/javascript">

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

			function updateButtons() {
				var html;
				$.get(
					"infoUpd.php",
					{
						command: "xmbcPID",
					},
					function(dat) {
						if (dat) html = '<button type="button" class="btn btn-default navbar-btn" onclick="stopXBMC()"><?php echo $lang['Stop_XBMC'];?></button> ';
						else html = '<button type="button" class="btn btn-default navbar-btn" onclick="startXBMC()"><?php echo $lang['Start_XBMC'];?></button> ';

						document.getElementById("xbmcButton").innerHTML = html;
					}
				);			
			}

			addEventListener("load", function() { setTimeout(updateButtons, 0); }, false);			
		</script>
		<div class="container">	
			<nav class="navbar navbar-default" role="navigation">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/">Pi Control</a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li id="index-tab">
							<a href="">Torrents</a>
						</li>
						<li id="browser-tab">
							<a href="browser.php">Browse</a>
						</li>
						<li>
							<a href="#">TV Shows</a>
						</li>
						<li>
							<a href="#">Movies</a>
						</li>
						<li id="info-tab">
							<a href="info.php">Info</a>
						</li>
						<li id="stats-tab">
							<a href="stats.php">Stats</a>
						</li>
						<li id="logs-tab">
							<a href="logs.php">Logs</a>
						</li>
						<li id="settings-tab">
							<a href="settings.php">Settings</a>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right" id="xbmcButton">
						<button type="button" class="btn btn-default navbar-btn">XBMC</button>
					</ul>
				</div>
			</nav>

