<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="jquery-1.9.1.min.js"></script>
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript">

	google.load('visualization', '1.0', {'packages':['corechart']});
	google.load('visualization', '1', { 'packages':['gauge']});

	google.setOnLoadCallback(drawRamChart);
	google.setOnLoadCallback(drawDiskChart);
	google.setOnLoadCallback(drawTempChart);

	var memArray = new Array();
	var cpuArray = new Array();

	<?php
		include 'settings.php';
	?>

	function drawRamChart() {
	    $.get(
		    "infoUpd.php",
		    {command: "ram"},
		    function(dat) {
		        var d = dat.split(" ");
		        //var freeMem = parseInt(d[1]);
		        //var cachedMem = parseInt([4]);
		        var totalMem = parseInt([7]);
		        var usedMem = parseInt(d[1]-d[4]);
		        var cpu = d[10]*100;

		        memArray.push(usedMem);
		        cpuArray.push(cpu);

		        var data = google.visualization.arrayToDataTable([
		          ['Time', 'Memory', 'CPU'],
		          [String(memArray.length-11), parseInt(memArray[memArray.length-11]), parseInt(cpuArray[cpuArray.length-11])]
		        ]);

		        for (i = memArray.length-10; i < memArray.length; i++) {
		        	data.addRows([[String(i), parseInt(memArray[i]), parseInt(cpuArray[i])]]);
		        }

		        var options = {'title':'Memory / CPU',
	                   		   'width':400,
	                   		   'height':300,
	                   		   vAxes:{
	                   		   		0: {title: 'kB', minValue: 0, maxValue: 153020, logScale: false},
	                   		   		1: {title: '%',  minValue: 0, maxValue: 100, 	logScale: false}
	                   		   },
	                   		   legend: {position: 'none'},
	                   		   series:{
							       0:{targetAxisIndex:0},
							       1:{targetAxisIndex:1}
							   },
							   hAxis:{showTextEvery:2}
	                   		};

	    		var chart = new google.visualization.LineChart(document.getElementById('ramChart'));
	   			chart.draw(data, options);

	   			document.getElementById("upText").innerHTML = 
	   									"<?php echo $lang['Time'];?>: " + d[9] + " <?php echo $lang['UpTime'];?>: " + d[12]  + " " + d[13] + " " + d[15];
		    }
		);
	}

	function drawDiskChart() {
	    var data = new google.visualization.DataTable();
	    data.addColumn('string', 'Topping');
	    data.addColumn('number', 'Slices');

	    $.get(
		    "infoUpd.php",
		    {command: "disk"},
		    function(dat) {
		        var d = dat.split("/");
		        var l = d.length-2;
		        for (var i = 0; i < l; i += 2) {
		        	data.addRow([d[i+1], parseInt(d[i])]);
		        }
		        

		        var options = {'title':'Disk',
	                   'width':400,
	                   'height':300, is3D:true};

	    		var chart = new google.visualization.PieChart(document.getElementById('diskChart'));
	   			chart.draw(data, options);
		    }
		);
	}

	var prevNetUp = 0;
	var prevNetDown = 0;

	function showNetUsage() {
		$.get(
		    "infoUpd.php",
		    {command: "net"},
		    function(dat) {
		    	var d = dat.split(" ");
		    	//alert(dat);
		    	//alert(d);
		    	var text = "<?php echo $lang['Down'];?>: " + ((d[10] - prevNetDown)/2048).toFixed(0) + " KB/s <?php echo $lang['Up'];?>: " +  ((d[11] - prevNetUp)/2048).toFixed(0) + " KB/s";
		    	document.getElementById("netText").innerHTML = text;
		    	prevNetUp = d[11];
		    	prevNetDown = d[10];
		    }
		);
	}

	function drawTempChart() {
		$.get(
		    "infoUpd.php",
		    {command: "temp"},
		    function(dat) {
		    	var data = google.visualization.arrayToDataTable([
		          ['Label', 'Value'],
		          ['Temp', parseInt(dat)],
		        ]);

		        var options = {
		          width: 400, height: 180,
		          redFrom: 65, redTo: 80,
		          yellowFrom:55, yellowTo: 65,
		          greenFrom:10, greenTo: 55,
		          minorTicks: 5, max: 80,
		        };

		        var chart = new google.visualization.Gauge(document.getElementById('tempChart'));
		        chart.draw(data, options);
		    }
		);
	}

	var t;
	updateTimer();

	function updateTimer() {
		drawRamChart();
		drawTempChart();
		updateTop();
		showNetUsage();
		t = setTimeout(function(){updateTimer()},2000);
	}

	var auto = true;

	function stopUpdate() {
		if (auto) {
			clearTimeout(t);
			auto = false;
			document.getElementById("updateButton").innerHTML = "<?php echo $lang['Autoupdate'];?>";
		}
		else {
			updateTimer();
			auto = true;
			document.getElementById("updateButton").innerHTML = "<?php echo $lang['Stop'];?>";
		}
	}

	function updateTop() {
		$.get(
		    "infoUpd.php",
		    {command: "top"},
		    function(dat) {
		    	document.getElementById("topList").innerHTML = dat;
		    }
		);
		
	}

	function updateAll() {
		drawTempChart();
		drawDiskChart();
		drawRamChart();
		updateTop();
		showNetUsage();
	}

</script>

<div class="block">
	<table>
    	<tr>
    		<td id="ramChart"></td>
    		<td id="tempChart"></td>
    		<td id="diskChart"></td>
    	</tr>
    </table>
</div>

<div class="block">
	<button type="button" onclick="updateAll()"><?php echo $lang['Update'];?></button>
	<button type="button" onclick="stopUpdate()" id="updateButton"><?php echo $lang['Stop'];?></button>
	<a id="netText">0</a>
	<a id="upText"></a>
</div>

<div class="block" id="topList">Top</div>