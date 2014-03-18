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
						<font size="5" color="black">Change Password</font></br></br></br>	
							<table width="70%">
								<tr>
									<td>Current Password:</td>
									<td><input type="text" name="CurrentPassword" size="60"></td>
								</tr>
								<tr height="20px"></tr>
								<tr>
									<td>New Password:</td>
									<td><input type="text" name="New Password" size="60"></td>
								</tr>
								<tr height="20px"></tr>
								<tr>
									<td>Confirm New Password:</td>
									<td><input type="text" name="New Password Confirmed" size="60"></td>
								</tr>
							</table>	
							</br></br>
							
							<font size="5" color="black">Change Email</font></br></br></br>	
							<table width="70%">
								<tr>
									<td>New Email Address:</td>
									<td><input type="text" name="CurrentPassword" size="60"></td>
								</tr>
								<tr height="20px"></tr>
								<tr>
									<td>New Email Adress Confirmed:</td>
									<td><input type="text" name="New Password" size="60"></td>
								</tr>
								<tr height="20px"></tr>
							</table>
							
							<div align="center">
								<button id = "button_id">Submit Changes</button></br></br>
							</div>
			
			
			<footer>&copy; Developmental Technologies Team. All Rights Reserved</footer>
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
		  <td><center><br><a href="./RegularUserHome.php" style="text-decoration:none;"><font size="5" color="black">Home</font></a><br><br></td>
		</tr>
		<tr>
		  <td><center><br><a href="./SpecifyCriteria.php" style="text-decoration:none;"><font size="5" color="black">Search <br> History</font></a><br><br></td>
		</tr>
		<tr>
		  <td><center><br><a href="./ChooseQueryStyle.php" style="text-decoration:none;"><font size="5" color="black">Visualize</font></a><br><br></td>
		</tr>
		<tr>
		  <td><center><br><a href="./ManageServices.php" style="text-decoration:none;"><font size="5" color="black">Manage <br> Services</font></a><br><br></td>
		</tr>
		<tr>
		  <td><center><br><a href="./ConfigureAccount.php" style="text-decoration:none;"><font size="5" color="black">Configure <br> Account</font></a><br><br></td>
		</tr>
	</table>
    </ul>
</div>
</body>
</html>

