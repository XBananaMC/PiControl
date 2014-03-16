<?php
	include 'header.php';
?>

	<script type="text/javascript">
		function setSchedule() {
			$.get(
				"schedule.php",
				{
					s: 0
				}
			);
		}
	</script>

	<div class="panel panel-default">
		<div class="panel-heading">User</div>
		<div class="panel-body">

		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">Settings</div>
		<div class="panel-body">
			//Language
			<br>
			//$transmissionUser 		= "transmission";
			<br>
			//$transmissionPassword 	= "1234";
			<br>
			//$transmissionPort 		= "9091";
			<br>
			//$ip 						= "192.168.1.60";
			<br>
			//$mediaDirectory			= "/media/HDE";
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">Schedule</div>
		<div class="panel-body">
			<button type="button" class="btn btn-default" onclick="setSchedule()">Start schedule</button>
		</div>
	</div>

	<script type="text/javascript">
		document.getElementById("settings-tab").setAttribute("class", "active");
	</script>
<?php
	include 'footer.php';
?>