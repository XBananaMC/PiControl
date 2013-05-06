<script src="jquery-1.9.1.min.js"></script>
<link href="style.css" rel="stylesheet" type="text/css">

<script type="text/javascript">

	function apply() {
		var d = new Date();
		var t = d.getTime();

		var m = Math.round((t/60000)%60);
		var h = Math.round((t/3600000)%24) + 1;

		var start = (document.getElementById("startTorrentTimeH").value - h) * 60 + (document.getElementById("startTorrentTimeM").value - m);
		if (start <= 0) start += 1440;
		var stop = (document.getElementById("stopTorrentTimeH").value - h) * 60 + (document.getElementById("stopTorrentTimeM").value - m);
		if (stop <= 0) stop += 1440;


		$.get(
		    "infoUpd.php",
		    {
		    	command: "killAllSleep"
			},
			function () {
				$.get(
		    		"infoUpd.php",
		    		{
		    			command: "sleep " + start + "m; sudo /etc/init.d/transmission-daemon start; transmission-remote --auth=transmission:1234 -t all -s"
					}
				);
				$.get(
		    		"infoUpd.php",
		    		{
		    			command: "sleep " + stop + "m; sudo /etc/init.d/transmission-daemon stop"
					}
				);
			}
		);
	}

	function cancelar() {
		$.get(
		    "infoUpd.php",
		    {
		    	command: "killAllSleep"
			}
		);
	}

	function setValues() {
		var d = new Date();
		var t = d.getTime();

		var m = Math.round((t/60000)%60);
		var h = Math.round((t/3600000)%24) + 1;

		document.getElementById("startTorrentTimeH").value = h;
		document.getElementById("startTorrentTimeM").value = m;
		document.getElementById("stopTorrentTimeH").value = h;
		document.getElementById("stopTorrentTimeM").value = m;
	}

	addEventListener("load", function() { setTimeout(setValues, 0); }, false);

</script>

<div class="block">
	<div class="title">Torrent</div>
	Start:
	<input type="text" name="startTorrentTimeH" placeholder="hh" id="startTorrentTimeH" class="timeInput">
	:
	<input type="text" name="startTorrentTimeM" placeholder="mm" id="startTorrentTimeM" class="timeInput">
	Stop:
	<input type="text" name="stopTorrentTimeH" placeholder="hh" id="stopTorrentTimeH" class="timeInput">
	:
	<input type="text" name="stopTorrentTimeM" placeholder="mm" id="stopTorrentTimeM" class="timeInput">
	<button type="button" onclick="apply()">Aplicar</button>
	<button type="button" onclick="cancelar()">Cancelar</button>
</div>