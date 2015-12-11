<!DOCTYPE html>
<html>
<head>
<style>
table, td {
    border: 1px solid black;
    border-collapse: collapse;
}
td {		
	padding: 5px;
}
</style>
</head>
<body>
<table>
<?php 
	
	//*******this is a test file **********
	
	//this script is meant to take a url as input and produce the output in decreasing order
	//another script is meant to send inputs as url to this script!!
	
	require_once('simple_html_dom.php') ;
	$url = 'http://scholar.google.co.in/scholar?hl=en&as_sdt=0,5&q=cryptography';
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
	
	$data = file_get_contents($url);
	$regex = '/Cited by (.+?)<\/a>/';
	preg_match_all($regex, $data, $match);		//an array of citations is hence made
	//the elements of this array can be treated as integers...taking advantage of loose typing of php :P
	$list = array();
	for($j = 0; $j<$i; $j++) {
		//echo "<h3><a href = '$links[$j]'>$titles[$j]</a></h3>";
		//@print("Citations : " . $match[1][$j]);
		$list["<h3><a href = '$links[$j]' target='_blank'>$titles[$j]</a></h3>"] = $match[1][$j] ;
	}
	arsort($list);
	$j = 0;
	foreach ($list as $key => $value) {
		//suppressing the empty citation value notices popping up
		@print("<tr><td>$key</td> <td><h4>$value</h4></td></tr>");
	}
?>
</table>
</body>
</html>


