<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<style>
h1 {
	font-size: 80px;
}
body {
	font-size: 20px;
}
input {
	border: 1;
	padding: 5px;
	font-size: 20px;
}

</style>
</head>
<body>
	<br><br>
	<div style = "text-align: center">
	<h1><font color = "#CC33FF">G</font><font color = "#FF6699">o</font><font color = "#00E600">o</font><font color = "#FF9933">g</font><font color = "#E6E600">l</font><font color = "#CC3399">e</font><font color = "#FF5858"> C</font><font color = "#19E8E8">r</font><font color = "#FF66CC">a</font><font color = "#CCFF33">w</font><font color = "#0099CC">l</font><font color = "#FF3399">e</font><font color = "#85AD33">r</font></h1>
	<br>
	<form action = "filter.php" method = "get">
	<input type = "text" name = "user" size = "40" autofocus id = "check3"><br><br>
	
	<input type = "checkbox" name = "papers" id = "check3">Search for papers <input type = "checkbox" name = "author" id = "check2">Search for author <input type = "checkbox" name = "journal" id = "check1">Search for journals<br><br>
	
	<input type = "checkbox" name = "date">Sort by date<br>
	<input type = "checkbox" name = "year">Within an year range<br>
	<input type = "checkbox" name = "citations">Sort by citations<br><br>
	<input type = "submit" value = "Submit" class = "btn btn-info btn-lg">
	</form>
</body>
</html>