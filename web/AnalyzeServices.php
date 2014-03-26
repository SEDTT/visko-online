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
					<font size="6" color="black">Frequency of Service Properties</font></br></br>				
					
					- Total Number of Services Registered: [[X]]<br><br>
					- Most Supported Abstraction: [[Abstraction]]<br>
					- Most Supported Input Format: [[Format]]<br>
					- Most Supported Input Data Type: [[Type]]<br>
					- Most Supported Output Format: [[Format]]<br>
					- Most Supported Output Data Type: [[Type]]<br>
					- Most Supported Service Toolkit: [[Toolkit Name]]<br><br><br>
					
					<img border="0" src="http://www.powertolearn.com/images/102606graph2.gif" alt="Pulpit rock" width="400px" style="padding-left:30px">
					<br><br><br>
					
					<p>	
					Frequence of Service Errors
					</p>
					<p>
					- Service with most associated errors: [[Service Name]]
					</p>
					<div id = "ServiceGraph"  style="padding-left:30px">
						<img border="0" src="http://www.powertolearn.com/images/102606graph2.gif" alt="Pulpit rock" width="370px" style="padding-left:30px">
					</div>	
					<br><br>
					
				</div>
			
				<br/><br/><br/>
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