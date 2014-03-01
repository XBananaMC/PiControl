<?php
	include 'header.php';	
?>
	<div class="panel panel-default">
		<div class="panel-body">
			<table class="table">
				<?php
					//saveLog("INFO", "Gerard", "Open log");

					$file = fopen("logs/".date('d-m-Y', time()).".txt","r") or exit("Unable to open file!");
					$count = 0;
					while(!feof($file)) {
						$char = fgetc($file);
						switch ($char) {
							case 'I': //INFO
								echo "<tr><td>";
								break;
							case 'W': //WARNING
								echo "<tr class='warning'><td>";
								break;
							case 'E': //ERROR
								echo "<tr class='danger'><td>";
								break;
							case ' ':
								$count++;
								if ($count < 4) echo "</td><td>";
								break;
							case "\n":
								echo "</td></tr>";
								$count = 0;
								break;
						}
						echo $char;
					}
					fclose($file);
				?>
			</table>
		</div>
	</div>
	
	<script type="text/javascript">
		document.getElementById("logs-tab").setAttribute("class", "active");
	</script>
<?php
	include 'footer.php';
?>