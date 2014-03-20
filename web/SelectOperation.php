<?php
	require_once("./include/membersite_config.php");
	if(!$fgmembersite->CheckLogin()){
		$fgmembersite->RedirectToURL("index.php");
		exit;
	}
	
	if(isset($_POST['submitted'])){
		/*if($fgmembersite->RegisterUser()){
			$fgmembersite->RedirectToURL("thank-you.html");
		}*/
	}
	
	$nameOfPerson = $fgmembersite->UserEmail();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<link rel="shortcut icon" href="images/logo.png">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>VisKo</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
		<style type="text/css">
		table.bottomBorder { border-collapse:collapse; }
		table.bottomBorder td, table.bottomBorder th { border-bottom:1px dotted black;padding:5px; }
		</style>
		<!--[if IE 6]>
		<link rel="stylesheet" type="text/css" href="css/iecss.css" />
		<![endif]-->
	</head>
	<body>
	<div id="main_container">
		<div class="header">
			<div id="logo">
				<a href="http://cs4311.cs.utep.edu/team3/"><img src="images/logo.png" alt="" border="0" /></a>
				<font size="10" color="white"><b> VisKo</b></font>
			</div>			
			<div class="welcome">
			<br><br><br>
			<font size="2" color="white"><b>Welcome back <?PHP echo $nameOfPerson ?>!&nbsp;&nbsp;</b></font>
			<form id="form1" action="logout.php" method="get">
				<input type="submit" value="Logout">
			</form>
			</div>
		</div>

		<div id="middle_box">
			<div class="middle_box_content">
					<html lang="en">
						<body>
						<font size="5" color="black">Add Service</font>
						<br><br>
						<!--here starts-->
						<head> 
						<link rel="stylesheet" href="css/styleDrop.css">
						<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
						<script type="text/javascript" src="scripts/dropdown.js"></script>
						</head>
						<!--ends here-->
						
						<div id="dd" class="wrapper-dropdown-1" style = "width:100%;">
									<span>Service Type</span>
									<ul class="dropdown">
										<li><a href="#">Viewer Set</a></li>
										<li><a href="#">Viewer</a></li>
										<li><a href="#">Filter</a></li>
										<li><a href="#">Transformer</a></li>
										<li><a href="#">Converter</a></li>
										<li><a href="#">Mapper</a></li>
									</ul>
						
						</div>
						<br><br>

						<center><button type="button" style= "background-color:#d9d9d9; width: 75px">Add</button></center>
						
						<br>
						<hr>
						<br>
						
						<font size="5" color="black">Edit / Delete Service</font><br><br>
						

						<form action="">
								<input type="radio" name="service" value="viewer_sets">
								<div id="dd2" class="wrapper-dropdown-1" style = "width:98%;">
									<span>Viewer Set</span>
									<ul class="dropdown">
										<li><a href="#">Viewer Set 1</a></li>
										<li><a href="#">Viewer Set 2</a></li>
										<li><a href="#">Viewer Set 3</a></li>
										<li><a href="#">Viewer Set 4</a></li>
										<li><a href="#">Viewer Set 5</a></li>
										<li><a href="#">Viewer Set 6</a></li>
									</ul>
								</div>
								<br><br>
	
								<input type="radio" name="service" value="viewers">
								<div id="dd3" class="wrapper-dropdown-1" style = "width:98%;">
									<span>Viewer</span>
									<ul class="dropdown">
										<li><a href="#">Viewer 1</a></li>
										<li><a href="#">Viewer 2</a></li>
										<li><a href="#">Viewer 3</a></li>
										<li><a href="#">Viewer 4</a></li>
										<li><a href="#">Viewer 5</a></li>
										<li><a href="#">Viewer 6</a></li>
									</ul>
								</div>
								<br><br>
								
								<input type="radio" name="service" value="filters">
								<div id="dd4" class="wrapper-dropdown-1" style = "width:98%;">
									<span>Filter</span>
									<ul class="dropdown">
										<li><a href="#">Filter 1</a></li>
										<li><a href="#">Filter 2</a></li>
										<li><a href="#">Filter 3</a></li>
										<li><a href="#">Filter 4</a></li>
										<li><a href="#">Filter 5</a></li>
										<li><a href="#">Filter 6</a></li>
									</ul>
								</div>
								<br><br>

								<input type="radio" name="service" value="transformers">
								<div id="dd5" class="wrapper-dropdown-1" style = "width:98%;">
									<span>Transformer</span>
									<ul class="dropdown">
										<li><a href="#">Transformer 1</a></li>
										<li><a href="#">Transformer 2</a></li>
										<li><a href="#">Transformer 3</a></li>
										<li><a href="#">Transformer 4</a></li>
										<li><a href="#">Transformer 5</a></li>
										<li><a href="#">Transformer 6</a></li>
									</ul>
								</div>
								<br><br>
								
								<input type="radio" name="service" value="converters">
								<div id="dd6" class="wrapper-dropdown-1" style = "width:98%;">
									<span>Converter</span>
									<ul class="dropdown">
										<li><a href="#">Converter 1</a></li>
										<li><a href="#">Converter 2</a></li>
										<li><a href="#">Converter 3</a></li>
										<li><a href="#">Converter 4</a></li>
										<li><a href="#">Converter 5</a></li>
										<li><a href="#">Converter 6</a></li>
									</ul>
								</div>
								<br><br>

								<input type="radio" name="service" value="mappers">
								<div id="dd7" class="wrapper-dropdown-1" style = "width:98%;">
									<span>Mapper</span>
									<ul class="dropdown">
										<li><a href="#">Mapper 1</a></li>
										<li><a href="#">Mapper 2</a></li>
										<li><a href="#">Mapper 3</a></li>
										<li><a href="#">Mapper 4</a></li>
										<li><a href="#">Mapper 5</a></li>
										<li><a href="#">Mapper 6</a></li>
									</ul>
								</div>
								<br><br>
	
							<center><button type="button" style= "background-color:#d9d9d9; width: 75px">Edit</button>&nbsp;&nbsp;<button type="button" style= "background-color:#d9d9d9; width: 75px">Delete</button>
						
						</form>
						</body>
					</html>
			</div>
		</div> 
		<br><br><br>
		<footer>&copy; Developmental Technologies Team. All Rights Reserved</footer>
	</div>

	
	
<div id="nav_table" style="position: fixed; left:0px; right: 31px; top: 120px; bottom: auto; display: block">
    <ul id="sidebar-nav" class="Menu">
<body>
	<br>
	<table class="bottomBorder">
		<tr>
		  <td><center></td>
		</tr>
		<tr>
		  <td><center><br><a href="./RegularUserHome.php" style="text-decoration:none;"><font size="5" color="black">Home</font></a><br><br></td>
		</tr>
		<tr>
		  <td><center><br><a href="./SpecifyCriteria.php" style="text-decoration:none;"><font size="5" color="black">Search <br> History</font></a><br><br></td>
		</tr>
		<tr>
		  <td><center><br><a href="./ChooseQueryStyle.php" style="text-decoration:none;"><font size="5" color="black">Visualize</font></a><br><br></td>
		</tr>
		<tr>
		  <td><center><br><a href="./SelectOperation.php" style="text-decoration:none;"><font size="5" color="black">Manage <br> Services</font></a><br><br></td>
		</tr>
		<tr>
		  <td><center><br><a href="./ConfigureAccountRegularUser.php" style="text-decoration:none;"><font size="5" color="black">Configure <br> Account</font></a><br><br></td>
		</tr>
	</table>
    </ul>
</div>
</body>
</html>