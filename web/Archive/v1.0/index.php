<?php
	require_once("./include/membersite_config.php");
	if(isset($_POST['submitted'])){
		/*if($fgmembersite->RegisterUser()){
			$fgmembersite->RedirectToURL("thank-you.html");
		}*/
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Team 3</title>
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
				<font size="10" color="black"><b> VisKo</b></font>
			</div>
			<div class="right_header">
				<br>
				<br>
					<fieldset>
						<legend>Login</legend>
						<form id='login' action='./login.php' method='post' accept-charset='UTF-8'>
							<input type='hidden' name='submitted' id='submitted' value='1'/>

							<label for='username' >Email:</label>
							<input type='text' name='username' id='username'  maxlength="50" />

							<label for='password' >Password:</label>
							<input type='password' name='password' id='password' maxlength="50" />

							<input type='submit' name='Submit' value='Login' />
						</form>
						<form id="register" action="./adminRegister.php" method="get">
							<input type='hidden' name='submitted1' id='submitted1' value='1'/>
							<input type="submit" value="Register" name="Register"/>
						</form>
					</fieldset>
			</div>
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
</body>
</html>
