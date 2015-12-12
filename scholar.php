<?php

//********this is a test file******

//this script is supposed to query the results for authors only...the url used needs to be scraped first frm the
//usual page source obtained from the initially used url

//require_once('simple_html_dom.php') ;
$str = "this is the year 2008 and done";
preg_match_all('/\d+/', $str, $matches);
$match = $matches[0][0];
print($match);

//$url = 'http://scholar.google.co.in/citations?user=U42j5MkAAAAJ&hl=en&oi=ao';	//this is the link for an author
//$url = "https://scholar.google.co.in/citations?user=U42j5MkAAAAJ&hl=en&oi=ao";
//$html = file_get_html($url);
//echo $html;
/*$e = 0;
$num = array();
$info = $html->find('td.gsc_rsb_std');
foreach($info as $x) {
$num[$e] = trim($x->plaintext);
$e++;
}
print("<div class='index'><table><tr><td>Citations</td><td>$num[0]</td><td>$num[1]</td></tr><tr><td>h-index</td><td>$num[2]</td><td>$num[3]</td></tr><tr><td>i10-index</td><td>$num[4]</td><td>$num[5]</td></tr></table></div>");*/
/*$titles = array();
$links = array();
$i = 0;

//$objs = $html->find('tr.td.gsc_a_t a');
$objs = $html->find('h3.gs_rt a');
foreach ($objs as $obj) {
$title = trim($obj->plaintext);
$link = trim($obj->href);		//an array has to be made to store these
//echo "<h3><a href = '$link'> $title </a><br></h3>";
//$titles[$i] = $title;
$titles[$i] = $title;
$links[$i] = "http://scholar.google.com" . $link;
$i++;
}
if(strpos($titles[0], 'User') !== false) {
exit("<div class='error'><p>Looks like you were looking for an author!!!</p></div>");
}
echo "this will not be printed";
/*$author = file_get_html($links[0]);
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
}*/

/*$objs = $html->find('div.gs_a');
$k = 0;
$authdata = array();
foreach($objs as $obj) {
$authdata[$k] = trim($obj->plaintext);
$k++;
}
print_r($authdata);*/

/*$data = file_get_contents($url);
$regex = '/Cited by (.+?)<\/a>/';
preg_match_all($regex, $data, $match);		//an array of citations is hence made
//the elements of this array can be treated as integers...taking advantage of loose typing of php :P */
/*$citlist = array();
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
@ $list["<h3><a href = '$nlinks[$j]'>$ntitles[$j]</a>"] = $citlist[$j] ;
}
//arsort($list);		the author data is already sorted wrt citations
$j = 0;
foreach ($list as $key => $value) {
//suppressing the empty citation value notices popping up
@print("$key Citations : $value</h3>");
}


/*$url = "https://scholar.google.co.in/citations?hl=en&view_op=search_venues&vq=cryptography";
$html = file_get_html($url);
$objs = $html->find('td.gs_num a');
$first = array();
$i = 0;
foreach($objs as $obj) {
$link = trim($obj->href);
$first[$i] = "https://scholar.google.co.in" . $link;
//echo $link;
break;
}
//echo $urln;
//echo $first[0];
$links = array();
$titles = array();
$i = 0;
$first[0] = str_replace("&amp;oe=ASCII", "", "$first[0]");
$first[0] = str_replace("&amp;", "&", "$first[0]");
//var_dump($first[0]);
$htmln = file_get_html($first[0]);
//echo $htmln;
$objs = $htmln->find('td.gs_title a');
foreach($objs as $obj) {
$link = trim($obj->href);
$title = trim($obj->plaintext);
$links[$i] = $link;
$titles[$i] = $title;
$i++;
}
$i = 0;
$cits = array();
$objs = $htmln->find('td.gs_num a');
foreach($objs as $obj) {
$cit = trim($obj->plaintext);
$cits[$i] = $cit;
$i++;
}
//print_r($cits);*/

?>
