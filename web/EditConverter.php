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
						<font size="5" color="black">Edit Converter</font>
						<br><br>
						<!--here starts-->
						<head> 
						<meta charset="utf-8"> 
						<title>jQuery UI Menu - Default functionality</title> 
						<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css"> 
						<script src="//code.jquery.com/jquery-1.9.1.js"></script>
						<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js">
						</script> <link rel="stylesheet" href="/resources/demos/style.css">
						<script> $(function() { $( "#operation" ).menu(); $( "#input_format" ).menu(); $( "#output_format" ).menu(); $( "#toolkit" ).menu(); }); 
						</script> 
						<style> .ui-menu { width: 150px;}
						</style> 
						</head>
						<!--ends here-->
						
						
						<font size="2" color="black">WSDL URL *</font>
						<form>
							<input type="text" name="WSDL URL" style = "width:100%; height:20px"><br>
						</form> 	
						<br>
						
						<form action="">
							<font size="2" color="black">Operation</font><br>
								<ul id="operation" style = "width:100%; height:20px"> 
									<li> 
										<a href="#">Operation 1</a> 
										<ul> 
											<li>
											<a href="#">Operation 2</a>
											</li> 
											<li>
											<a href="#">Operation 3</a>
											</li> 
											<li>
											<a href="#">Operation 4</a>
											</li> 
											<li>
											<a href="#">Operation 5</a>
											</li> 
											<li>
											<a href="#">Operation 6</a>
											</li> 
										</ul> 
									</li> 
								</ul> 

								
								<table style="width:100%">
								<tr>
								<td>
								<font size="2" color="black">Input Format</font><br>
								<ul id="input_format" style = "width:100%; height:20px"> 
									<li> 
										<a href="#">Format 1</a> 
										<ul> 
											<li>
											<a href="#">Format 2</a>
											</li> 
											<li>
											<a href="#">Format 3</a>
											</li> 
											<li>
											<a href="#">Format 4</a>
											</li> 
											<li>
											<a href="#">Format 5</a>
											</li> 
											<li>
											<a href="#">Format 6</a>
											</li> 
										</ul> 
									</li> 
								</ul> 
								<br>
								</td>
								
								<td></td>
	
								<td>
								<font size="2" color="black">Output Format</font><br>
								<ul id="output_format" style = "width:100%; height:20px"> 
									<li> 
										<a href="#">Format 1</a> 
										<ul> 
											<li>
											<a href="#">Format 2</a>
											</li> 
											<li>
											<a href="#">Format 3</a>
											</li> 
											<li>
											<a href="#">Format 4</a>
											</li> 
											<li>
											<a href="#">Format 5</a>
											</li> 
											<li>
											<a href="#">Format 6</a>
											</li> 
										</ul> 
									</li> 
								</ul> 
								<br>
								</td>
								</tr>
								<br>
								</table>
								
								<font size="2" color="black">Toolkit</font><br>
								<ul id="toolkit" style = "width:100%; height:20px"> 
									<li> 
										<a href="#">Toolkit 1</a> 
										<ul> 
											<li>
											<a href="#">Toolkit 2</a>
											</li> 
											<li>
											<a href="#">Toolkit 3</a>
											</li> 
											<li>
											<a href="#">Toolkit 4</a>
											</li> 
											<li>
											<a href="#">Toolkit 5</a>
											</li> 
											<li>
											<a href="#">Toolkit 6</a>
											</li> 
										</ul> 
									</li> 
								</ul> 
	
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