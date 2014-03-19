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
	
	$nameOfPerson = $fgmembersite->UserFullName();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<link rel="shortcut icon" href="images/logo.png">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>VisKo</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
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
			
			Welcome back <?PHP echo $nameOfPerson ?>!
			<form id="form1" action="logout.php" method="get">
				<input type="submit" value="Logout">
			</form>
		</div>
		<div id="middle_box">
			<div class="middle_box_content">
				<font size="6" color="black"> What is VisKo?</font>
				<br><br>
				<font size="3" color="black"> VisKo is a framework supporting the answering of visualization queries that allow users to specify what visualizations they want generated rather that specifying how they should be generated.</font>
			</div>
		</div> 
		<div id="middle_box">
			<div class="middle_box_content">
				<font size="6" color="black"> What are the benefits?</font>
				<br><br>
				<font size="3" color="black"> VisKo can automatically figure out how to generate visualizations given only a query that specifies what visualizations are being requested. Below is a variety of different visualizations generated from a single gravity dataset, resulting from the execution of a single VisKo query.</font>
				<br><br>
				<img src="images/gravity.png" alt="" width= "850" border="0" />
			</div>
		</div>
		<div id="footer">
			<div class="center_footer">&copy; Developmental Technologies Team. All Rights Reserved</div>
		</div>
	</div>
	
<div style="position: fixed; left:0px; right: 31px; top: 86px; bottom: auto; display: block">
    <ul id="sidebar-nav" class="Menu">
	<style>
table, td , th
{
	border:1px solid black;
	padding:27px;
}
table
{
	border-collapse:collapse;
}
</style>
<body>
	<br>
	<table style="width:170px">
		<tr>
		  <td><center><a href="http://cs4311.cs.utep.edu/team3/RegularUserHome.php" style="text-decoration:none;"><font size="5" color="black">Home</font></a></td>
		</tr>
		<tr>
		  <td><center><a href="http://cs4311.cs.utep.edu/team3/SearchHistory.php" style="text-decoration:none;"><font size="5" color="black">Search <br> History</font></a></td>
		</tr>
		<tr>
		  <td><center><a href="http://cs4311.cs.utep.edu/team3/Visualize.php" style="text-decoration:none;"><font size="5" color="black">Visualize</font></a></td>
		</tr>
		<tr>
		  <td><center><a href="http://cs4311.cs.utep.edu/team3/ManageServices.php" style="text-decoration:none;"><font size="5" color="black">Manage <br> Services</font></a></td>
		</tr>
		<tr>
		  <td><center><a href="http://cs4311.cs.utep.edu/team3/ConfigureAccount.php" style="text-decoration:none;"><font size="5" color="black">Configure <br> Account</font></a></td>
		</tr>
	</table>
    </ul>
</div>
</body>
</html>