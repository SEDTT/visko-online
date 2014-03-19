<?php
	require_once("./include/membersite_config.php");
	if(isset($_POST['submitted'])){
		/*if($fgmembersite->RegisterUser()){
			$fgmembersite->RedirectToURL("thank-you.html");
		}*/
	}
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
		</div>
		<div id="middle_box">
			<div class="middle_box_content">
						<font size="5" color="black"> Visualization Search Criteria</font></br></br></br>
					<table  border="0" style="width:800px">	
					<tr>
						<td>		
							<select id="Abstraction" name="Abstraction">                      
								<option value="0">--Select Abstraction--</option>
								<option value="abstract1">Abstract1</option>
								<option value="abstract2">Abstract2</option>
								<option value="abstract3">Abstract3</option>
							</select>
							</td>
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
					</tr>
					<tr>
						<td>
							<br><br><br><br><br>
							<select id="Input URL" name="Input URl">                      
								<option value="0">--Input URL--</option>
								<option value="inputURL1">inputURL1</option>
								<option value="inputURL2">inputURL2</option>
								<option value="inputURl3">inputURL3</option>
							</select>
						</td>	
						<td>
							<br><br><br><br><br>
							<select id="Target Format" name="Target Format">                      
								<option value="0">--Target Format--</option>
								<option value="targetFormat1">targetFormat1</option>
								<option value="targetFormat2">targetFormat2</option>
								<option value="targetFormat3">targetFormat3</option>
							</select>
						</td>	
					</tr>
					<tr>
						<td>
							<br><br><br><br><br>
							<select id="Viewer Set" name="Viewer Set">                      
								<option value="0">--Viewer Set--</option>
								<option value="viewerSet1">viewerSet1</option>
								<option value="viewerSet2">viewerSet2</option>
								<option value="viewerSet3">viewerSet3</option>
							</select>
							<td>
							<br><br><br><br><br>
							<select id="Target Type" name="Target Type">                      
								<option value="0">--Target Type--</option>
								<option value="targetType1">targetType1</option>
								<option value="targetType2">targetType2</option>
								<option value="targetType3">targetType3</option>
							</select>
						</td>
						</td>
					</tr>		
					<tr>
						<td>
							<br><br><br><br><br>
							<select id="Source Format" name="Source Format">                      
								<option value="0">--Source Format--</option>
								<option value="sourceFormat1">sourceFormat1</option>
								<option value="sourceFormat2">sourceFormat2</option>
								<option value="sourceFormat3">sourceFormat3</option>
							</select>
						</td>
						
					</tr>	
					<tr>
						<td>
							<br><br><br><br><br>
							<select id="Source Type" name="Source Type">                      
								<option value="0">--Source Type--</option>
								<option value="sourceType1">sourceType1</option>
								<option	value="sourceType2">sourceType2</option>
								<option value="sourceType3">sourceType3</option>
							</select>
						</td>		
					</tr>
				</table>
				<div style = "float:right;">
					<button type="button">Search</button>
				</div>
					<br><br><br>
				<hr>
				Results:
				<div align = "center">
					Click on any visualization to see details.
				
				<table border = "1" style="width:600px; height:100px" >
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
				</div>
			</div>
		</div>
		<div id="footer">
			<div class="center_footer">&copy; Developmental Technologies Team. All Rights Reserved</div>
		</div>
	</div>
	</body>
	
<div id = "nav_table" style="position: fixed; left:0px; right: 31px; top: 120px; bottom: auto; display: block">
    <ul id="sidebar-nav" class="Menu">
<body>
	<br>
	<table class="bottomBorder">
		<tr>
		  <td><center></td>
		</tr>
		<tr>
		  <td><center><br><a href="http://cs4311.cs.utep.edu/team3/RegularUserHome.php" style="text-decoration:none;"><font size="5" color="black">Home</font></a><br><br></td>
		</tr>
		<tr>
		  <td><center><br><a href="http://cs4311.cs.utep.edu/team3/SearchHistory.php" style="text-decoration:none;"><font size="5" color="black">Search <br> History</font></a><br><br></td>
		</tr>
		<tr>
		  <td><center><br><a href="http://cs4311.cs.utep.edu/team3/Visualize.php" style="text-decoration:none;"><font size="5" color="black">Visualize</font></a><br><br></td>
		</tr>
		<tr>
		  <td><center><br><a href="http://cs4311.cs.utep.edu/team3/ManageServices.php" style="text-decoration:none;"><font size="5" color="black">Manage <br> Services</font></a><br><br></td>
		</tr>
		<tr>
		  <td><center><br><a href="http://cs4311.cs.utep.edu/team3/ConfigureAccount.php" style="text-decoration:none;"><font size="5" color="black">Configure <br> Account</font></a><br><br></td>
		</tr>
	</table>
    </ul>
</div>
</body>
</html>

