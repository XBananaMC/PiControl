<script src="jquery-1.9.1.min.js"></script>
<link href="style.css" rel="stylesheet" type="text/css">
<?php
	include 'settings.php';
?>

<div class="block" id="test">
	
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