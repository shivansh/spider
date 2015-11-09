<!DOCTYPE html>
	<html>
    <head>
    <meta charset="utf-8" />
	<script src="Chart.js-master/Chart.js"></script>
    </head>
    <body>
	<?php
	require_once('graphdata.php');
	$input = array();
		function datasets($input) {
			if(!is_null($input))
			{	$str='"'.$input[0].'"';
				for ($i=1; $i <sizeof($input); $i++) { 
					$str=$str.',"'.$input[$i].'"';
				}
			}
			return $str;
		}
	$label1 = array();
	$len = sizeof($data);
	for($i = 0; $i<$len; $i++) {
		$label1[$i] = 2015 - $len + 1 + $i;
	}
	//print(datasets($label));
?>
    <canvas id="mygraph" width="500" height="400"></canvas>
    <script>
	var i = 0;
	var riceData = {
		labels : [<?php print(datasets($label1))?>],
		datasets : [
			{
				fillColor : "rgba(172,194,132,0.4)",
				strokeColor : "#ACC26D",
				pointColor : "#fff",
				pointStrokeColor : "#9DB86D",
				data : [<?php print(datasets($data)) ?>]
			}
		]
	}

	var rice = document.getElementById('mygraph').getContext('2d');
	new Chart(rice).Bar(riceData);
	</script>
    </body>
    </html>