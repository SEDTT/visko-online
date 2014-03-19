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
						<font size="5" color="black"> Visualization Search Criteria</font></br></br></br>		
							<html lang="en">
								<head>
									<meta charset="utf-8">
									<title>jQuery UI Menu - Default functionality</title>
									<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
									<script src="//code.jquery.com/jquery-1.9.1.js"></script>
									<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
									<link rel="stylesheet" href="/resources/demos/style.css">
									<script>
										$(function() {
										$( "#Absmenu" ).menu();
										$( "#InputURLmenu" ).menu();
										$( "#ViewerSetmenu" ).menu();
										$( "#SourceFormatmenu" ).menu();
										$( "#SourceTypemenu" ).menu();
										});
									</script>
									<style>
										.ui-menu { width: 150px; }
									</style>
								</head>
								<body>
								<table>
									<tr>
										<td>
											<ul id="Absmenu" style = "width:150px; height:20px">
											<li>
												<a href="#">Abstraction</a>
												<ul>
													<li><a href="#">Abstraction1</a></li>
													<li><a href="#">Abstraction2</a></li>
													<li><a href="#">Abstraction3</a></li>
												</ul>
											</li>
										</ul>
										</td>
										<td style="width:250px"> </td>
										<td>
											<html lang="en">
								<head>
									<meta charset="utf-8">
									<title>jQuery UI Datepicker - Default functionality</title>
									<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
									<script src="//code.jquery.com/jquery-1.9.1.js"></script>
									<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
									<link rel="stylesheet" href="/resources/demos/style.css">
									<script>
									$(function() {
									$( "#start_datepicker" ).datepicker();
									$("#end_datepicker").datepicker();
									});
									</script>
								</head>
								<body>
									<p>
									Start Date: <input type="text" id="start_datepicker">
									End Date: <input type="text" id="end_datepicker">
									</p> 
								</body>
							</html>
							
							</td>
							</br></br></br>
							</tr>
							<tr style = "height:100px"></tr>
							<tr>
								<td>
									<ul id="InputURLmenu" style = "width:150px; height:20px">
										<li>
											<a href="#">Input URL</a>
											<ul>
												<li><a href="#">Input URL1</a></li>
												<li><a href="#">Input URL2</a></li>
												<li><a href="#">Input URL3</a></li>
											</ul>
										</li>
									</ul>	
								</td>
								<td></td>
								<td>
									<ul id="ViewerSetmenu" style = "width:150px; height:20px">
										<li>
											<a href="#">Viewer Set</a>
											<ul>
												<li><a href="#">Viewer Set1</a></li>
												<li><a href="#">Viewer Set2</a></li>
												<li><a href="#">Viewer Set3</a></li>
											</ul>		
										</li>
									</ul>
								</td>
							</tr>
							<tr style = "height:100px"></tr>
							<tr>	
								<td>
									<ul id="SourceFormatmenu" style = "width:150px; height:20px">
										<li>
											<a href="#">Source Format</a>
											<ul>
												<li><a href="#">Source Format1</a></li>
												<li><a href="#">Source Format2</a></li>
												<li><a href="#">Source Format3</a></li>
											</ul>		
										</li>
									</ul>
								</td>
								<td style= "width:250px"></td>
								<td>	
									<ul id="SourceTypemenu" style = "width:150px; height:20px">
										<li>
											<a href="#">Source Type</a>
											<ul>
												<li><a href="#">Source Type1</a></li>
												<li><a href="#">Source Type2</a></li>
												<li><a href="#">Source Type3</a></li>
											</ul>		
										</li>
									</ul>
								</td>
							</tr>		
								</table>	
								</body>
							</html>
							</br></br>
							
							
				<html>
					<head>
					
						<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
						<script>
						var $jq = jQuery.noConflict();  
							$jq(document).ready(function() {
							$jq('#resultsTbl').hide(); //Initially form will be hidden
							$jq('#button_id').click(function() {
							$jq('#resultsTbl').show();//Form shows on button click
							});
							});
						</script>
					</head>
					<body> 
						<div style = "float:right;">
							<button id = "button_id">Search</button>
						</div>
						<br><br><br>
						<p>
						
							<hr>
							
							Results:
								<div id = "resultsTbl" align = "center">
								Click on any visualization to see details.
				
								<table  border = "1" style=	"width:600px; height:100px" >
								<tr>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								</table>
						</p>
					</body>	
				</html>	
				</div>
		</div>
			<footer>&copy; Developmental Technologies Team. All Rights Reserved</footer>
	</div>
	</body>
	
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