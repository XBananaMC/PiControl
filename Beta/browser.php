<?php
	include 'header.php';
?>

	<div class="panel panel-default">
		<div class="panel-body" id="test">
			
		</div>
	</div>

	<script type="text/javascript">
		function goDir() {
			$.get(
				"infoUpd.php",
				{
					command: "ls <?php echo $mediaDirectory;?> -l"
				},
				function (dat) {
					document.getElementById("test").innerHTML = dat;
				}
			);
		}
		goDir();
	</script>

	<script type="text/javascript">
		document.getElementById("browser-tab").setAttribute("class", "active");
	</script>
<?php
	include 'footer.php';
?>