<!DOCTYPE html>
<html lang="en">
<head>
	<script src="Chart.js-master/Chart.js"></script>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<style>

div.error {
	width: 800px;
	background-color: blue;
	color: white;
	padding: 0.1px;
	font-size: 18px;
}
div.author {
	background-color: blue;
	color: white;
	font-size: 18px;
	width: 500px;

}
p {
	text-align: center;
}
div.tabledata {
	width: 750px;
}
a {
	font-size: 16px;
}
th {
	font-size: 16px;
	color: #E68A2E;
}

</style>
</head>
<body>

<div class = "tabledata">
<table class='table table-hover'>
<thead>
<th class="col-md-5" style = "text-align: center">Journals</th>
<th class="col-md-1" >Citations</th>
</thead>
<tbody>
<?php 
	echo $_GET["sort"];
	//needs to be tested!!!!
	
	require_once('simple_html_dom.php') ;
	$q = $_GET['user'];
	$query = str_replace(" ", "+", "$q");
	if($_SERVER['REQUEST_METHOD']=='GET')
	{
		if(isset($_GET['journal'])) {
			// if (( isset($_GET['date']) || isset($_GET['year']) ) 	&& !isset($_GET['citations'])) {
			if ( $_GET['sort']=='Date' || isset($_GET['year']) ) {
				if($_GET['sort']=='Date' && !isset($_GET['year']))
					$url = "http://scholar.google.co.in/scholar?hl=en&as_sdt=0,5&q=$query&scisbd=1&num=20";
				else if($_GET['sort']=='Date' && isset($_GET['year']))
					$url = "http://scholar.google.co.in/scholar?hl=en&as_sdt=0,5&q=$query&as_ylo=2014&scisbd=1&num=20";
				else if($_GET['date']=='Citations' && isset($_GET['year']))
					$url = "http://scholar.google.co.in/scholar?hl=en&as_sdt=0,5&q=$query&as_ylo=2014&num=20";
				$html = file_get_html($url);
				
				$titles = array();
				$links = array();
				$i = 0;
				
				$objs = $html->find('h3.gs_rt a');
				foreach ($objs as $obj) {
					$title = trim($obj->plaintext);
					$link = trim($obj->href);		//an array has to be made to store these
					//echo "<h3><a href = '$link'> $title </a><br></h3>";
					$titles[$i] = $title;
					$links[$i] = $link;
					$i++;
				}
				if(strpos($titles[0], 'User') !== false) {
					exit("<div class='error'><p>Looks like you were looking for an author!!!</p></div>");
				}
				
				$data = file_get_contents($url);
				$regex = '/Cited by (.+?)<\/a>/';
				preg_match_all($regex, $data, $match);
				//printing the output
				for($j = 0; $j<$i; $j++) {
					if(empty($match[1][$j]))
						$val = 0;
					else 
						$val = $match[1][$j];
					//@print ("<h3><a href = '$links[$j]'>$titles[$j]</a> <br> Citations : " . $val . "</h3>");
					@print("<tr><td><h3><a href = '$links[$j]' target='_blank'>$titles[$j]</a></h3></td> <td>" . $val . "</td></tr>");
				}
			}
			// else if (isset($_GET['citations'])) {
			else if ($_GET['sort']=='Citations') {
				// if($_GET['sort']=='Date' && !isset($_GET['year']))
					// $url = "http://scholar.google.co.in/scholar?hl=en&as_sdt=0,5&q=$query&scisbd=1&num=20";
				// else if(!isset($_GET['date']) && isset($_GET['year']))
				if(isset($_GET['year']))
					$url = "http://scholar.google.co.in/scholar?hl=en&as_sdt=0,5&q=$query&as_ylo=2014&num=20";
				//else if(isset($_GET['date']) && isset($_GET['year']))
				//	$url = "http://scholar.google.co.in/scholar?hl=en&as_sdt=0,5&q=$query&as_ylo=2014&scisbd=1&num=20";
				// else if(!isset($_GET['date']) && !isset($_GET['year']))
				else
					$url = "http://scholar.google.co.in/scholar?hl=en&as_sdt=0,5&q=$query&num=20";
				$html = file_get_html($url);
				
				$titles = array();
				$links = array();
				$i = 0;
				
				$objs = $html->find('h3.gs_rt a');
				foreach ($objs as $obj) {
					$title = trim($obj->plaintext);
					$link = trim($obj->href);		//same as above
					$titles[$i] = $title;
					$links[$i] = $link;
					$i++;
				}
				if(strpos($titles[0], 'User') !== false) {
					exit("<div class='error'><p>Looks like you were looking for an author!!!</p></div>");
				}
				
				$data = file_get_contents($url);
				$regex = '/Cited by (.+?)<\/a>/';
				preg_match_all($regex, $data, $match);		//an array of citations is hence made
				//the elements of this array can be treated as integers...taking advantage of loose typing of php :P
				
				$list = array();
				for($j = 0; $j<$i; $j++) {
					if(empty($match[1][$j]))
						$val = 0;
					else 
						$val = $match[1][$j];
					@ $list["<h3><a href = '$links[$j]' target='_blank'>$titles[$j]</a></h3>"] = $val ;
				}
				arsort($list);		//reversing the order and maintaining the key - value relation at the same time
				foreach($list as $key => $value) {
					//@print("$key  <br>Citations : $value</h3>");
					@print("<tr><td>$key</td> <td>$value</td></tr>");
				}
			}
			// else if(!isset($_GET['date']) && !isset($_GET['year']) && !isset($_GET['citations'])) {
			else if($_GET['sort']=='Citations' && !isset($_GET['year']) ) {
				$url = "http://scholar.google.co.in/scholar?hl=en&as_sdt=0,5&q=$query&num=20";
				$html = file_get_html($url);
				$titles = array();
				$links = array();
				$i = 0;
				$objs = $html->find('h3.gs_rt a');
				foreach ($objs as $obj) {
					$title = trim($obj->plaintext);
					$link = trim($obj->href);		//the procedure is same as above loop
					$titles[$i] = $title;
					$links[$i] = $link;
					$i++;
				}
				if(strpos($titles[0], 'User') !== false) {
					exit("<div class='error'><p>Looks like you were looking for an author!!!</p></div>");
				}
				
				$data = file_get_contents($url);
				$regex = '/Cited by (.+?)<\/a>/';
				preg_match_all($regex, $data, $match);		//array of citations
				
				$list = array();
				for($j = 0; $j<$i; $j++) {
					//$list["<h3><a href = '$links[$j]'>$titles[$j]</a>"] = $match[1][$j] ;
					if(empty($match[1][$j]))
						$val = 0;
					else 
						$val = $match[1][$j];
					//@print("<h3><a href = '$links[$j]'>$titles[$j]</a> <br>Citations : " . $val);
					@print("<tr><td><h3><a href = '$links[$j]' target='_blank'>$titles[$j]</a></h3></td> <td>" . $val . "</td></tr>");
				}	
			}
		}
		
		else if(isset($_GET['author'])) {
			//require_once('graphjs.php');
			
			//$url = 'http://scholar.google.co.in/citations?user=U42j5MkAAAAJ&hl=en&oi=ao';	//this is the link for an author
			$url = "http://scholar.google.co.in/scholar?hl=en&as_sdt=0,5&q=$query";
			$html = file_get_html($url);
			
			$titles = array();
			$links = array();
			$i = 0;
			
			//$objs = $html->find('tr.td.gsc_a_t a');
			$objs = $html->find('h4.gs_rt2 a');
			if(empty($objs)) {
				exit("<div class='error'><p>Unable to retrieve data for the specified author...Please try searching by journal</p></div>");		//if the author is not available
			}
		
			foreach ($objs as $obj) {
				$title = trim($obj->plaintext);
				$link = trim($obj->href);		//an array has to be made to store these
				//echo "<h3><a href = '$link'> $title </a><br></h3>";
				//$titles[$i] = $title;
				$links[$i] = "http://scholar.google.com" . $link;
				break;
				$i++;
			}
			
			$author = file_get_html($links[0]);
			
			$data = array();
			$i = 0;
			$image = $author->find('span.gsc_g_al');
				foreach ($image as $img) {
					$src = trim($img->plaintext);	
					$data[$i] = $src;
					$i++;
				}
			//print_r($data);     array of data points is made
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
			//graph data ?>
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
			<?php
			
			$authinfo = array();
			$i = 0;
			$info = $author->find('div.gsc_prf_il');
			foreach($info as $x) {
				$authinfo[$i] = trim($x->plaintext);
				$i++;
			}
			$authstr = null;
			for($j = 0; $j<$i-1; $j++) {
				$authstr = $authstr . $authinfo[$j];
			}
			
			//scraping the image
			$src = null;
			$image = $author->find('img');
			if(!empty($image)) {
				foreach ($image as $img) {
					$src = trim($img->src);	
					break;
				}
				print("<img src = 'http://scholar.google.com$src'></img>" . "<div class = 'author'>" . $authstr . "</div>");
			}
			
			$ntitles = array();
			$nlinks = array();
			$i = 0;
			
			//n is appended for signifying new data for same variable names
			$nobjs = $author->find('tr.td.gsc_a_t a');
			foreach ($nobjs as $nobj) {
				$ntitle = trim($nobj->plaintext);
				$nlink = trim($nobj->href);		//an array has to be made to store these
				//echo "<h3><a href = '$link'> $title </a><br></h3>";
				$ntitles[$i] = $ntitle;
				$nlinks[$i] = "http://scholar.google.com" . $nlink;
				$i++;
			}
			
			$citlist = array();
			$i = 0;
			$cits = $author->find('tr.td.gsc_a_c a');
			foreach ($cits as $cit) {
				$citation = trim($cit->plaintext);
				if($citation=='*')		//escaping the * used after the citation value
					continue;
				$citlist[$i] = $citation;
				$i++;
			}
			
			$list = array();
			for($j = 0; $j<$i; $j++) {
				//echo "<h3><a href = '$links[$j]'>$titles[$j]</a></h3>";
				//@print("Citations : " . $match[1][$j]);
				@ $list["<h3><a href = '$nlinks[$j]' target='_blank'>$ntitles[$j]</a>"] = $citlist[$j] ;
			}
			//arsort($list);		the author data is already sorted wrt citations
			$j = 0;
			foreach ($list as $key => $value) {
				//suppressing the empty citation value notices popping up
				//@print("$key Citations : $value</h3>");
				@print("<tr><td>$key</td> <td>$value</td></tr>");
			}
		}	
		if(isset($_GET['paper'])) {
			$url = "https://scholar.google.co.in/citations?hl=en&view_op=search_venues&vq=$query";
			$html = file_get_html($url);
			$obj = $html->find(td.gs_num);
		}
	}
	
?>
</tbody>
</table>
</div>

</body>
</html>