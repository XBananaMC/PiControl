<script src="jquery-1.9.1.min.js"></script>
<link href="style.css" rel="stylesheet" type="text/css">

<script type="text/javascript">

	function apply() {
		var frec = document.getElementById("radioFrec");

		$.get(
		    "infoUpd.php",
		    {
		    	command: "pifm sound.wav 100.0"
			},
			function(dat) {
				alert(dat);
			}
		);
	}

</script>

<div class="block">
	<div class="title">Radio</div>
	Frequencia:
	<input type="text" name="radioFrec" placeholder="100" id="radioFrec">
	<button type="button" onclick="apply()">Go</button>
</div>