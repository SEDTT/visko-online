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
				<a href="index.php"><img src="images/logo.png" alt="" border="0" /></a>
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
						<font size="5" color="black">Query Search Criteria</font>	
							<!--here starts-->
						<head> 
						<link rel="stylesheet" href="css/styleDrop.css">
						<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
						<script type="text/javascript" src="scripts/dropdown.js"></script>
						<script type="text/javascript">
							$(document).ready(function()
							{
								$.getJSON("json/dropdownlists.txt",function(obj)
							   {
									 $.each(obj.abstractions,function(key,value)
									 {
										var option = $('<option />').val(value.abstractionName).text(value.abstractionName);
										$("#ddAbstract").append(option);
									 });
								});
							});
						</script>
						</head>
						<!--ends here-->
								<body>
								<table style="width:100%">
									<tr>
										<td>
										<select id="ddAbstract" style="width:100%">
											<option value="" disabled selected style='display:none;'>Abstraction</option>
										</select>
										</td>
										<td style="width:50px"></td>
							<td style="width:330px">
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
									<center>Start Date: <br><input type="text" id="start_datepicker"></center>
									</p> 
									</tr>			
							</td>
							</br></br></br>
							<tr style="height:30px"></tr>
							<tr>
								<td>
									<select id="ddInputURL" style="width:100%">
										<option value="" disabled selected style='display:none;'>Input URL</option>
										<option>empty</option>
									</select>
								</td>
								<td style="width:50px"></td>
								<td>
								<p>
									<center>End Date: <br><input type="text" id="end_datepicker"></center>
								</p> 
								</td>
							</tr>
							</body>
							</html>
							<tr style="height:30px"></tr>
							<tr>
								<td>
									<select id="ddviewSet" style="width:100%">
										<option value="" disabled selected style='display:none;'>Viewer Set</option>
										<option>empty</option>
									</select>
								</td>
							</tr>
							</table>
							<br><br>
							
							
							<table style="width:100%">
							<tr>	
								<td>
									<select id="ddSourceFormat" style="width:100%">
										<option value="" disabled selected style='display:none;'>Source Format</option>
										<option>empty</option>
									</select>
								</td>
								<td style="width:5px"></td>
								<td>
									<select id="ddTargetFormat" style="width:100%">
										<option value="" disabled selected style='display:none;'>Target Format</option>
										<option>empty</option>
									</select>
								</td>
							</tr>
								
								<tr style="height:30px"></tr>

								<tr>
									<td>	
										<select id="ddSourceType" style="width:100%">
											<option value="" disabled selected style='display:none;'>Source Type</option>
											<option>empty</option>
										</select>
									</td>
									<td style="width:5px"></td>
									<td>
										<select id="ddTargetType" style="width:100%">
											<option value="" disabled selected style='display:none;'>Target Type</option>
											<option>empty</option>
										</select>
									</td>
									<td style="width:44px"></td>
									<td>
										<select id="ddError" style="width:100%">
											<option value="" disabled selected style='display:none;'>Errors and Successes</option>
											<option>empty</option>
										</select>
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
							$jq('#queryDetails').hide(); //Initially form will be hidden
							$jq('#button_id').click(function() {
							$jq('#resultsTbl').show();//Form shows on button click
							$jq('#queryDetails').show();//Form shows on button click
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
							<table style="width:100%">
							<tr>
							<td>
								<div id = "resultsTbl" >
								Results:
								<br><br>
								<table  border = "1" style=	"width:100%;">
								<tr bgcolor="#cccccc">
									<td><center>ID</center></td>
									<td><center>Submitted by User</center></td>
									<td><center>Date Executed</center></td>
									<td><center>Error</center></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td><a href="./QueriesViewDetails.php">
											<button style="width:100%">View Details</button>
										</a></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td><a href="./QueriesViewDetails.php">
											<button style="width:100%">View Details</button>
										</a></td>
								</tr>
								</table>
							</td>
							<td style="width:20px"></td>
							<td>
							<div id = "queryDetails" >
								Query Details:
								<br><br>
								<form>
								<textarea style = "width:100%" rows="4" cols="50">[[Some Visualization Query]]</textarea>
								</form>
							</td>
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
	
<div id="nav_table" style="position: fixed; left:0px; right: 40px; top: 100px; bottom: auto; display: block">
    <ul id="sidebar-nav" class="Menu">
<body>
	<br>
	<table class="bottomBorder">
		<tr>
		  <td><center></td>
		</tr>
		<tr>
		  <td><center><a href="./PrivilegedUserHome.php" style="text-decoration:none;"><font size="4" color="black">Home</font><br><br></a></td>
		</tr>
		<tr>
		  <td><center><br><a href="./PipelineSpecifyCriteria.php" style="text-decoration:none;"><font size="4" color="black">Search Pipelines</font><br><br></a></td>
		</tr>
		<tr>
		  <td><center><br><a href="./QueriesSpecifyCriteria.php" style="text-decoration:none;"><font size="4" color="black">Search Queries</font><br><br></a></td>
		</tr>
		<tr>
		  <td><center><br><a href="./ServicesSpecifyCriteria.php" style="text-decoration:none;"><font size="4" color="black">Search Services</font><br><br></a></td>
		</tr>
		<tr>
		  <td><center><br><a href="./SearchUsers.php" style="text-decoration:none;"><font size="4" color="black">Search Users</font><br><br></a></td>
		</tr>
		<tr>
		  <td><center><br><a href="./AnalyzePipelines.php" style="text-decoration:none;"><font size="4" color="black">Analyze Pipelines</font><br><br></a></td>
		</tr>
		<tr>
		  <td><center><br><a href="./AnalyzeQueries.php" style="text-decoration:none;"><font size="4" color="black">Analyze Queries</font><br><br></a></td>
		</tr>
		<tr>
		  <td><center><br><a href="./AnalyzeServices.php" style="text-decoration:none;"><font size="4" color="black">Analyze Services</font><br><br></a></td>
		</tr>
	</table>
    </ul>
</div>
</body>
</html>