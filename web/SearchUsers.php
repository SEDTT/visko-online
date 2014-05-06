<?php
	require_once("./include/membersite_config.php");
	if(!$fgmembersite->CheckLogin()){
		$fgmembersite->RedirectToURL("index.php");
		exit;
	}
	
	if(isset($_POST['submitted'])){
		$qry = $fgmembersite->searchUser();
	}
	
	$nameOfPerson = $fgmembersite->UserEmail();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Privileged Mode</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" href="images/logo.png">
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
					<font size="10" color="white"><b>&nbsp; Privileged Mode</b></font>
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
						<font size="5" color="black"> Search Users </font></br></br>		
							<!--here starts-->
						<head> 
						<link rel="stylesheet" href="css/styleDrop.css">
						<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
						<script type="text/javascript" src="scripts/dropdown.js"></script>
						
						</head>
						<!--ends here-->
								<body>
									<form action="./SearchUsers.php" method="POST" accept-charset='UTF-8'>
										<table>
												<tr>
													<td>
														User Email<br>
														<input type="text" name="U_email" id="U_email" size="40">
													</td>
													<td style="width:100px"> </td>
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
													Start Date: <input type="text" id="start_datepicker"></br></br>
													End Date: <input type="text" id="end_datepicker">
													</p> 
												</body>
											</html>
											
											</td>
											</br>
											</tr>
											<tr style = "height:25px"></tr>
											<tr>
												<td>
													FirstName<br>
													<input type="text" name="U_first" id="U_first" size="40">
												</td>
												<td></td>
												<td>
													<select id="ddAccountStatus" style="width:100%">
														<option value="" disabled selected style='display:none;'>Account Status</option>
													</select>
												</td>
											</tr>
											<tr style = "height:25px"></tr>
											<tr>	
												<td>
													Last Name<br>
													<input type="text" name="U_last" id="U_last" size="40">
												</td>
												<td style= "width:250px"></td>
												<td>	
													<select id="ddAffiliation" style="width:100%">
														<option value="" disabled selected style='display:none;'>Affiliation</option>
													</select>
												</td>
											</tr>		
										</table>
									</form>
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
				
								<table  border = "1" style=	"width:600px; height:100px" >
								<tr bgcolor="#cccccc">
									<td align="center">Date Joined</td>
									<td align="center">Account status</td>
									<td align="center">First Name</td>
									<td align="center">Last Name</td>
									<td align="center">Affiliation</td>
								</tr>
								<?PHP
									//$qry = $fgmembersite->searchUser();
									
									//$qry = "SELECT * FROM cs4311team3sp14.User WHERE U_email = '" . $_REQUEST['U_email'] . "' OR U_first = '" . $_REQUEST['U_first'] . "' OR U_last = '" . $_REQUEST['U_last'] ."'";
									$qry = "SELECT * FROM cs4311team3sp14.user WHERE U_email = '" . $_POST['U_email']. "';";
									echo "query: " . $qry;
									while(!$row = mysql_query($qry, mysql_connect('localhost', 'root', 'sk@t3low1432'))){
								?>
								<tr>
									<td><?PHP $row['U_reg_date'] ?></td>
									<td><?PHP $row['U_confirmed'] ?></td>
									<td><?PHP $row['U_first'] ?></td>
									<td><?PHP $row['U_last'] ?></td>
									<td><?PHP $row['U_affiliation'] ?></td>
									<td align="center"><button id = "button_id">Toggle</button></td>
								</tr>
								<?PHP }?>
								</table>
						</p>
					</body>	
				</html>	
			</div>
			<br/><br/><br/>
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