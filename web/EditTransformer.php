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
		<script type="text/javascript" src="scripts/dropdown.js"></script>
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
				<input id="logout" type="submit" value="Logout">
			</form>
			</div>
		</div>

		<div id="middle_box">
			<div class="middle_box_content">
					<html lang="en">
						<body>
						<font size="5" color="black">Edit Transformer</font>
						<br><br>
						<!--here starts-->
						<head> 
							<link rel="stylesheet" href="css/styleDrop.css">
							<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
							<script type="text/javascript" src="scripts/dropdown.js"></script>
						</head>
						<!--ends here-->
						
						
						<font size="2" color="black">WSDL URL *</font>
						<form>
							<input type="text" name="WSDL URL" style = "width:100%; height:20px"><br>
						</form> 	
						<br>
						
						<form action="">
							<div id="dd" class="wrapper-dropdown-1" style = "width:100%;">
								<span>Operation</span>
								<ul class="dropdown">
									<li><a href="#">Operation 1</a></li>
									<li><a href="#">Operation 2</a></li>
									<li><a href="#">Operation 3</a></li>
									<li><a href="#">Operation 4</a></li>
									<li><a href="#">Operation 5</a></li>
									<li><a id="last" href="#">Operation 6</a></li>
								</ul>						
							</div>
							<br/><br/>
							
							<div id="dd2" class="wrapper-dropdown-1" style = "width:100%;">
								<span>Input Format</span>
								<ul class="dropdown">
									<li><a href="#">Format 1</a></li>
									<li><a href="#">Format 2</a></li>
									<li><a href="#">Format 3</a></li>
									<li><a href="#">Format 4</a></li>
									<li><a href="#">Format 5</a></li>
									<li><a id="last" href="#">Format 6</a></li>
								</ul>						
							</div>
							<br/><br/>

							<div id="dd3" class="wrapper-dropdown-1" style = "width:100%;">
								<span>Output Format</span>
								<ul class="dropdown">
									<li><a href="#">Format 1</a></li>
									<li><a href="#">Format 2</a></li>
									<li><a href="#">Format 3</a></li>
									<li><a href="#">Format 4</a></li>
									<li><a href="#">Format 5</a></li>
									<li><a id="last" href="#">Format 6</a></li>
								</ul>						
							</div>
							<br/><br/>
							
							<div id="dd4" class="wrapper-dropdown-1" style = "width:100%;">
								<span>Input Data Type (Optional)</span>
								<ul class="dropdown">
									<li><a href="#">Data Type 1</a></li>
									<li><a href="#">Data Type 2</a></li>
									<li><a href="#">Data Type 3</a></li>
									<li><a href="#">Data Type 4</a></li>
									<li><a href="#">Data Type 5</a></li>
									<li><a id="last" href="#">Data Type 6</a></li>
								</ul>						
							</div>
							<br/><br/>
							
							<div id="dd5" class="wrapper-dropdown-1" style = "width:100%;">
								<span>Output Data Type (Optional)</span>
								<ul class="dropdown">
									<li><a href="#">Data Type 1</a></li>
									<li><a href="#">Data Type 2</a></li>
									<li><a href="#">Data Type 3</a></li>
									<li><a href="#">Data Type 4</a></li>
									<li><a href="#">Data Type 5</a></li>
									<li><a id="last" href="#">Data Type 6</a></li>
								</ul>						
							</div>
							<br/><br/>
							
							<div id="dd6" class="wrapper-dropdown-1" style = "width:100%;">
								<span>Toolkit</span>
								<ul class="dropdown">
									<li><a href="#">Toolkit 1</a></li>
									<li><a href="#">Toolkit 2</a></li>
									<li><a href="#">Toolkit 3</a></li>
									<li><a href="#">Toolkit 4</a></li>
									<li><a href="#">Toolkit 5</a></li>
									<li><a id="last" href="#">Toolkit 6</a></li>
								</ul>						
							</div>
							<br/><br/>
	
							<br>
							<center><button type="button">Commit</button>
						
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