<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="bootstrap.min.css">
	<script src="jquery.min.js"></script>
	<script src="bootstrap.min.js"></script>
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
			<input type="text" name="user" size="40" autofocus id="check3" >
			<br><br>

			<div style="margin-left: 15cm;">
				<div class="col-xs-4 col-md-3">
					<label for="drop" style="align: left">Sort by:</label>
					<select class="form-control " id="drop" name="sort">
						<option value="Citations">Citations</option>
						<option value="Date">Date</option>
					</select>
				</div>
			</div>
			<br><br><br>
			<div class="checkbox">
				<label><input type="checkbox" name="year">Within an year range</label>
			</div>

			<input type = "submit" name = "papers" id = "check3"   value="Search Papers" class = "btn btn-info btn-lg">
			<input type = "submit" name = "author" id = "check2"  value="Search Author" class = "btn btn-info btn-lg">
			<input type = "submit" name = "journal" id = "check1" value="Search Journal" class = "btn btn-info btn-lg"><br><br>
			<br>
			<br>
		</form>
	</body>
	</html>
