<!DOCTYPE html>
<html>
<body>

<?php 
	require_once('simple_html_dom.php');
	$url = 'http://scholar.google.co.in/citations?user=U42j5MkAAAAJ&hl=en&oi=ao';
	$html = file_get_html($url);
	
	$data = array();
	$i = 0;
	$image = $html->find('span.gsc_g_al');
		foreach ($image as $img) {
			$src = trim($img->plaintext);	
			$data[$i] = $src;
			$i++;
		}
	//print_r($data);     array of data points is made
?>

</body>
</html>