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
						<font size="5" color="black">Set Query Parameters</font>
						<br><br>
						<!--here starts-->
						<head> 
						<meta charset="utf-8"> 
						<title>jQuery UI Menu - Default functionality</title> 
						<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css"> 
						<script src="//code.jquery.com/jquery-1.9.1.js"></script>
						<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js">
						</script> <link rel="stylesheet" href="/resources/demos/style.css">
						<script> $(function() { $( "#Viewer_set" ).menu(); $( "#Inputdata_format" ).menu(); $( "#Inputdata_type" ).menu(); $( "#Inputdata_URL" ).menu(); }); 
						</script> 
						<style> .ui-menu { width: 150px; }
						</style> 
						</head> 
						

						<!--ends here-->
						<table style="width:100%">
						<tr>
							<td>
								<div style="width:300px;height:150px;overflow:hidden">
									<img src="images/tmp.jpg"/>
								</div>
								<font size="1" color="black">Thumbnail from previous page!</font>
							</td>
							<td>
								<font size="2" color="black">&lt;&lt;Text Corresponding to Visualization Abstraction Description from previous page&gt;&gt;</font>
							</td>
						</tr>
						</table>
						
						<br><br>
						<hr>
						
						<table style="width:100%">
						<tr>
							<td>
									<font size="2" color="black">Viewer Set</font>
									<ul id="Viewer_set" style = "width:400px; height:20px"> 
									<li> 
									<a href="#">Web Browser</a> 
									<ul> 
									<li>
									<a href="#">Viewer Set 2</a>
									</li> 
									</ul> 
									</li> 
									</ul> 
									<br>
							</td>
							<td style="width:20px"></td>
							<td>
								<font size="2" color="black"><p align="justify"><b>Viewer Set: </b>refers to programs that present the abstraction onto the screen, such as visualization specific software like ParaView or more generic applications like a Web browser that can display images in standard formats.</p></font>
							</td>
						</tr>
						<tr>
							<td>
									<font size="2" color="black">Input Data Format</font>
									<ul id="Inputdata_format" style = "width:400px; height:20px"> 
									<li> 
									<a href="#">TIFF</a> 
									<ul> 
									<li>
									<a href="#">Input data format 2</a>
									</li> 
									</ul> 
									</li> 
									</ul> 
									<br>
							</td>
							<td></td>
							<td>
								<font size="2" color="black"><p align="justify"><b>Input Data Format: </b>refers to the file encoding of your input dataset.</p></font>
							</td>
						</tr>
						<tr>
							<td>
									<font size="2" color="black">Input Data Type</font>
									<ul id="Inputdata_type" style = "width:400px; height:20px"> 
									<li> 
									<a href="#">VTKPolyData</a> 
									<ul> 
									<li>
									<a href="#">Input data type 2</a>
									</li> 
									</ul> 
									</li> 
									</ul> 
									<br>
							</td>
							<td></td>
							<td>
								<font size="2" color="black"><p align="justify"><b>Input Data Type: </b>refers to the data structure represented by your input data format.</p></font>
							</td>
						</tr>
						<tr>
							<td>
									<font size="2" color="black">Input Data URL</font>
									<ul id="Inputdata_URL" style = "width:400px; height:20px"> 
									<li> 
									<a href="#">Input data URL 1</a> 
									<ul> 
									<li>
									<a href="#">Input data URL 2</a>
									</li> 
									</ul> 
									</li> 
									</ul> 
									<br>
							</td>
							<td></td>
							<td>
								<font size="2" color="black"><p align="justify"><b>Input Data URL: </b>refers to the location of your input data which is to be visualized.</p></font>
							</td>
						</tr>
						<tr>
							<td><center><button type="button">Submit</button></td>
						</tr>
						</table>
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