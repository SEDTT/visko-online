<?php
/*	require_once("./include/membersite_config.php");
	if(!$fgmembersite->CheckLogin()){
		$fgmembersite->RedirectToURL("index.php");
		exit;
	}
*/	

	
	if(isset($_POST['submitted'])){
		/*if($fgmembersite->RegisterUser()){
			$fgmembersite->RedirectToURL("thank-you.html");
		}*/
	}
	
	/*$nameOfPerson = $fgmembersite->UserEmail();*/
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
				<font size="5" color="black"> Search Results Details</font></br></br></br>
				
				<div align="center" style="width:500px;height:200px;border:1px solid black;margin:0 auto;">
				TEST
				</div>
				</br>
				<hr>
				</br>
				<font size="4" color="black"> Responsible Pipeline</font></br></br>
				<table border="0" style= "width:700px" align = "center">
					<tr>
						<td>
						<table border="1" color="black" style="width:550px" align="center">
							<tr>
								<td bgcolor="#C0C0C0">
									<p><b><center>ID</b></p>
								</td>
								<td bgcolor="#C0C0C0">
									<p><b><center>Abstraction</b></p>
								</td>
								<td bgcolor="#C0C0C0">
									<p><b><center>Output Format</b></p>
								</td>
								<td bgcolor="#C0C0C0">
									<p><b><center>Date Executed</b></p>
								</td>
							</tr>
							<tr>
								<td><p><center> 12 </p></td>
								<td><p><center> Isosurfaces </p></td>
								<td><p><center> JPEG </p></td>
								<td><p><center> Date/Time </p></td>
							</tr>
						</table>
						</td>
					</tr>
					<tr style = "height:200px">	
						<td>
						<div>
							Service 1</br></br>
 								<p>&emsp;&emsp;<label for="param1">Parameters 1 =</label></p></br>
								<p>&emsp;&emsp;<label for="param1">Parameters 2 =</label></p></br>
								<p>&emsp;&emsp;<label for="param1">Parameters 3 =</label></p></br>
							Service 2</br></br>
 								<p>&emsp;&emsp;<label for="param1">Parameters 4 =</label></p></br>
							Service 3</br></br>
 								<p>&emsp;&emsp;<label for="param1">Parameters 5 =</label></p></br>
								<p>&emsp;&emsp;<label for="param1">Parameters 6 =</label></p></br>
						</div>
						<td>
					</tr>
				</table>			
				<hr>
				<font size="4" color="black"> Responsible Query</font></br></br>
				<div align="center" style="width:500px;height:200px;border:1px solid black;margin:0 auto;">
				TEST
				</div>
				</br></br></br>
				
			<footer>&copy; Developmental Technologies Team. All Rights Reserved</footer>
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
		  <td><center><br><a href="./SpecifyCriteriaRegularUser.php" style="text-decoration:none;"><font size="5" color="black">Search <br> History</font></a><br><br></td>
		</tr>
		<tr>
		  <td><center><br><a href="./ChooseQueryStyle.php" style="text-decoration:none;"><font size="5" color="black">Visualize</font></a><br><br></td>
		</tr>
		<tr>
		  <td><center><br><a href="./ManageServices.php" style="text-decoration:none;"><font size="5" color="black">Manage <br> Services</font></a><br><br></td>
		</tr>
		<tr>
		  <td><center><br><a href="./ConfigureAccountRegularUser.php" style="text-decoration:none;"><font size="5" color="black">Configure <br> Account</font></a><br><br></td>
		</tr>
	</table>
    </ul>
</div>
</body>
</html>