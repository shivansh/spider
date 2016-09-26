<div class = "tabledata">
  <table class='table table-hover'>
    <thead>
      <th class="col-md-5" style = "text-align: center">Journals</th>
      <th class="col-md-1" >Citations</th>
      <th class="col-md-1">Year</th>
    </thead>
    <tbody>
      <?php
      require_once('simple_html_dom.php') ;
      $q = $_GET['user'];
      $query = str_replace(" ", "+", "$q");
      if($_SERVER['REQUEST_METHOD']=='GET') {
        if(isset($_GET['papers'])) {
          if ( $_GET['sort']=='Date' || isset($_GET['year']) ) {
            if ( $_GET['sort']=='Date' || !isset($_GET['year']) )
            $url = "http://scholar.google.co.in/scholar?hl=en&as_sdt=0,5&q=$query&scisbd=1&num=20";
            else if($_GET['sort']!=='Date' && isset($_GET['year']))
            $url = "http://scholar.google.co.in/scholar?hl=en&as_sdt=0,5&q=$query&as_ylo=2014&num=20";
            else if($_GET['sort']=='Date' && isset($_GET['year']))
            $url = "http://scholar.google.co.in/scholar?hl=en&as_sdt=0,5&q=$query&as_ylo=2014&scisbd=1&num=20";
            $html = file_get_html($url);

            $titles = array();
            $links = array();
            $i = 0;

            $objs = $html->find('h3.gs_rt a');
            foreach ($objs as $obj) {
              $title = trim($obj->plaintext);
              $link = trim($obj->href);		//an array has to be made to store these
              $titles[$i] = $title;
              $links[$i] = $link;
              $i++;
            }
            $host = $_SERVER["HTTP_HOST"];
            $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
            if(strpos($titles[0], 'User') !== false) {
              print("<div class='error'><p>Your search - $q - didn't match any publications. Try searching by author or journals.</p></div><div class='link'><a href='http://$host$path/interface.php'>Go back</a></div>");
              exit();
            }
            $objs = $html->find('div.gs_a');
            $k = 0;
            $match = array();
            $authdata = array();
            foreach($objs as $obj) {
              $authdata[$k] = trim($obj->plaintext);
              $k++;
            }

            $data = file_get_contents($url);
            $regex = '/Cited by (.+?)<\/a>/';
            preg_match_all($regex, $data, $match);
            for($j = 0; $j<$i; $j++) {
              if(empty($match[1][$j]))
              $val = 0;
              else
              $val = $match[1][$j];
              print("<tr><td><a href = '$links[$j]' target='_blank'>$titles[$j]</a><br>$authdata[$j]</td> <td>" . $val . "</td></tr>");
            }
          }
          else if ($_GET['sort']=='Citations')	{
            if(isset($_GET['year']))
            $url = "http://scholar.google.co.in/scholar?hl=en&as_sdt=0,5&q=$query&as_ylo=2014&num=20";
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
            $host = $_SERVER["HTTP_HOST"];
            $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
            if(strpos($titles[0], 'User') !== false) {
              print("<div class='error'><p>Your search - $q - didn't match any publications. Try searching by author or journals.</p></div><div class='link'><a href='http://$host$path/interface.php'>Go back</a></div>");
              exit();
            }
            $objs = $html->find('div.gs_a');
            $k = 0;
            $authdata = array();
            foreach($objs as $obj) {
              $authdata[$k] = trim($obj->plaintext);
              $k++;
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
              @ $list["<a href = '$links[$j]' target='_blank'>$titles[$j]</a><br>$authdata[$j]"] = $val ;
            }
            arsort($list);		//reversing the order and maintaining the key - value relation at the same time
            foreach($list as $key => $value) {
              @print("<tr><td>$key</td> <td>$value</td></tr>");
            }
          }
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
            $host = $_SERVER["HTTP_HOST"];
            $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
            if(strpos($titles[0], 'User') !== false) {
              print("<div class='error'><p>Your search - $q - didn't match any publications. Try searching by author or journals.</p></div><div class='link'><a href='http://$host$path/interface.php'>Go back</a></div>");
              exit();
            }

            $objs = $html->find('div.gs_a');
            $k = 0;
            $authdata = array();
            foreach($objs as $obj) {
              $authdata[$k] = trim($obj->plaintext);
              $k++;
            }

            $data = file_get_contents($url);
            $regex = '/Cited by (.+?)<\/a>/';
            preg_match_all($regex, $data, $match);		//array of citations

            $list = array();
            for($j = 0; $j<$i; $j++) {
              if(empty($match[1][$j]))
              $val = 0;
              else
              $val = $match[1][$j];
              @print("<tr><td><a href = '$links[$j]' target='_blank'>$titles[$j]</a><br>$authdata[$j]</td> <td>" . $val . "</td></tr>");
            }
          }
        }

        else if(isset($_GET['author'])) {
          $url = "http://scholar.google.co.in/citations?hl=en&view_op=search_authors&mauthors=$query";
          $html = file_get_html($url);

          $titles = array();
          $links = array();
          $i = 0;

          $objs = $html->find('h3.gsc_1usr_name a');
          if(empty($objs)) {
            $host = $_SERVER["HTTP_HOST"];
            $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
            print("<div class='error'><p>Your search - $q - didn't match any publications. Try searching by journals or papers.</p></div><div class = 'link'><a href='http://$host$path/interface.php'>Go back</a></div>");
            exit();
          }

          foreach ($objs as $obj) {
            $title = trim($obj->plaintext);
            $link = trim($obj->href);		//an array has to be made to store these
            $links[$i] = "http://scholar.google.com" . $link;
            break;
            $i++;
          }
          if($_GET['sort']=='Date')
          $links[0] = $links[0] . "&sortby=pubdate";

          $author = file_get_html($links[0]);

          $data = array();
          $i = 0;
          $image = $author->find('span.gsc_g_al');
          foreach ($image as $img) {
            $src = trim($img->plaintext);
            $data[$i] = $src;
            $i++;
          }
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
          <canvas id="mygraph" width="450" height="400"></canvas>
          <script>
          var i = 0;
          var points = {
            labels : [<?php print(datasets($label1))?>],
            datasets : [
              {
                fillColor : "rgb(0, 153, 204)",
                strokeColor : "#007CA6",
                pointColor : "#fff",
                pointStrokeColor : "#007CA6",
                data : [<?php print(datasets($data)) ?>]
              }
            ]
          }

          var graph = document.getElementById('mygraph').getContext('2d');
          new Chart(graph).Bar(points);
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
            $authstr = $authstr . "<br>" .  $authinfo[$j];
          }

          $names = null;
          $info = $author->find('div[id=gsc_prf_in]');
          foreach($info as $x) {
            $names = trim($x->plaintext);
            break;
          }

          //Scraping the citation statistics
          $e = 0;
          $num = array();
          $info = $author->find('td.gsc_rsb_std');
          foreach($info as $x) {
            $num[$e] = trim($x->plaintext);
            $e++;
          }
          @print("<div class='index'>Citations  : $num[0]<br>
          h-index   : $num[2]<br>
          i10-index : $num[4]</div>");

          //Scraping the image
          $src = null;
          $image = $author->find('img');
          if(!empty($image)) {
            foreach ($image as $img) {
              $src = trim($img->src);
              break;
            }
            print("<div id='inform'><div class = 'image'><img src = 'http://scholar.google.com$src'></img></div>" . "<div class = 'name'>$names</div>" ."<div class = 'author'>" . $authstr . "</div></div>");
            }

            $ntitles = array();
            $nlinks = array();
            $i = 0;

            //n is appended for signifying new data for same variable names
            $nobjs = $author->find('tr.td.gsc_a_t a');
            foreach ($nobjs as $nobj) {
              $ntitle = trim($nobj->plaintext);
              $nlink = trim($nobj->href);		//an array has to be made to store these
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
            $exauths = array();
            $exauth = array();
            $k = 0;
            $objs = $author->find('div.gs_gray');
            foreach($objs as $obj) {
              $exauths[$k] = trim($obj->plaintext);
              $k++;
            }
            $w = 0;
            for ($b = 0; $b<=$k-1; $b+=2) {
              $d = $b+1;
              $exauth[$w] = $exauths[$b] ."<br>". $exauths[$d];
              $w++;
            }
            $exyear = array();
            $k = 0;
            $objs = $author->find('span.gsc_a_h');
            foreach($objs as $obj) {
              $exyear[$k] = trim($obj->plaintext);
              $k++;
            }

            $list = array();
            for($j = 0; $j<$i; $j++) {
              $m = $j + 1;
              @ $list["<a href = '$nlinks[$j]' target='_blank'>$ntitles[$j]</a><br>$exauth[$j]"] = $citlist[$j] . "</td> <td>$exyear[$m]</td></tr>" ;
            }
            //arsort($list);		the author data is already sorted wrt citations
            $j = 0;
            foreach ($list as $key => $value) {
              //suppressing the empty citation value notices popping up
              @print("<tr><td>$key</td> <td>$value");
            }
          }
          if(isset($_GET['journal'])) {
            $url = "https://scholar.google.co.in/citations?hl=en&view_op=search_venues&vq=$query";
            $html = file_get_html($url);

            $titles = array();
            $objs = $html->find('div.gs_med');
            foreach($objs as $obj) {
              $titles[0] = trim($obj->plaintext);
              break;
            }
            if(!empty($titles[0])) {
              $host = $_SERVER["HTTP_HOST"];
              $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
              print("<div class='error'><p>Your search - $q - didn't match any publications. Try searching by papers or author.</p></div><div class = 'link'><a href='http://$host$path/interface.php'>Go back</a></div>");
              exit();
            }

            $objs = $html->find('td.gs_num a');
            $first = array();
            $i = 0;
            $jourdata = null;
            $xobjs = $html->find('td.gs_title');
            foreach($xobjs as $xobj) {
              $jourdata = trim($xobj->plaintext);
              break;
            }
            $jourcit = null;
            foreach($objs as $obj) {
              $jourcit = trim($obj->plaintext);
              $link = trim($obj->href);
              $first[$i] = "https://scholar.google.co.in" . $link;
              break;
            }

            $links = array();
            $titles = array();
            $i = 0;
            $first[0] = str_replace("&amp;oe=ASCII", "", "$first[0]");
            $first[0] = str_replace("&amp;", "&", "$first[0]");
            $htmln = file_get_html($first[0]);
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
            $objs = $htmln->find('td.gs_num');
            $years = array();
            $k = 0;
            foreach($objs as $obj) {
              $years[$k] = trim($obj->plaintext);
              $k++;
            }
            $data = array();
            $r = 0;
            for($j = 0; $j<=($k-1);$j+=2) {
              $s = $j+1;
              $data[$r] = $years[$s];
              $r++;
            }

            $objs = $htmln->find('span.gs_authors');
            $authors = array();
            $k = 0;
            foreach($objs as $obj) {
              $authors[$k] = trim($obj->plaintext);
              $k++;
            }
            $objs = $htmln->find('span.gs_pub');
            $pub = array();
            $k = 0;
            foreach($objs as $obj) {
              $pub[$k] = trim($obj->plaintext);
              $k++;
            }
            print("<div class = 'journal'>Showing results for - $jourdata <br>h Index : $jourcit</div>");
            for($j = 0; $j <= $i-1; $j++) {
              print("<tr><td><a href = '$links[$j]' target = '_blank'>$titles[$j]</a><br>$authors[$j]<br>$pub[$j]</td><td>$cits[$j]</td><td>$data[$j]</td></tr>");
            }
          }
        }
        ?>
      </tbody>
    </table>
  </div>

</body>
