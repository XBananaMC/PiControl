<?php
	include 'header.php';

	$prev = $_REQUEST['p'];
?>
	<div class="panel panel-default">
		<div class="panel-body">
				<?php
					//saveLog("INFO", "Gerard", "Open log");
					if ($prev) $date = date('d-m-Y', strtotime(' -'.$prev.' day'));
					else $date = date('d-m-Y', strtotime('today'));
					$file = fopen("logs/".$date.".txt","r") or exit("Unable to open file!");

				?>

				<form action="logs.php" method="get" class="pull-left">
					<input type="text" name="p" value="<?php echo $prev+1?>" hidden>
					<input class="btn btn-default" type="submit" value="Previous">
				</form>


				<?php

					if ($prev > 0) {
						echo '<form action="logs.php" method="get" class="pull-right">
							<input type="text" name="p" value="'.($prev-1).'" hidden>
							<input class="btn btn-default" type="submit" value="Next">
						</form>';
					}

				?>

				<h3 class="text-center logs-header"><?php echo $date ?> </h3>
				<br>

				<table class="table">

				<?php

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