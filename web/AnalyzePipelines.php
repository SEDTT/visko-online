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
					<font size="6" color="black">Frequency of Pipeline Executions</font></br></br>				
					
					- Total Number of Pipelines Executed: [[X]]<br><br>
					- Most Popular Abstraction Generated: [[Abstraction]]<br><br>
					- Most Popular Input Format: [[Format]]<br>
					- Most Popular Output Format: [[Format]]<br><br>
					- Most Popular Input Data Type: [[Type]]<br>
					- Most Popular Output Data Type: [[Type]]<br><br><br>
					
					<p>	
					Frequency of Pipeline Errors
					</p><br>
					<img border="0" src="http://www.powertolearn.com/images/102606graph2.gif" alt="Pulpit rock" width="400px" style="padding-left:30px">
					<br><br><br>
					
					<p>	
					Most Popular Pipeline
					</p><br>
					<div id = "PipelineTbl"  style="padding-left:30px">
				
								<table  border = "1" style=	"width:400px; height:55px" >
								<tr bgcolor="#cccccc">
									<td align="center">ID</td>
									<td align="center">Abstraction</td>
									<td align="center">Output Format</td>
								</tr>
								<tr>
									<td align="center">12</td>
									<td align="center">Isosurfaces</td>
									<td align="center">JPEG</td>
								</tr>
								</table>
								<br><br>
					</div>	
					<div id="serviceLoop"  style="padding-left:30px">
					<!-- Should be in a loop to fill dynamically-->
						Service 1:<br>
						&nbsp; Parameter 1 = <input style="background-color:#cccccc; width:312px;" type="text" value="12" readonly><br>
						&nbsp; Parameter 2 = <input style="background-color:#cccccc; width:312px;" type="text" value="122343.3434" readonly><br>
						Service 2:<br>
						&nbsp; Parameter 3 = <input style="background-color:#cccccc; width:312px;" type="text" value="12" readonly><br>
						Service 3:<br>
						&nbsp; Parameter 4 = <input style="background-color:#cccccc; width:312px;" type="text" value="122343.3434" readonly><br>
						&nbsp; Parameter 5 = <input style="background-color:#cccccc; width:312px;" type="text" value="122343.3434" readonly><br>
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