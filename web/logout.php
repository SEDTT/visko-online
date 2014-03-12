<!--This file is being used for site-->
<meta http-equiv="refresh" content="3; index.php">

<?PHP
	require_once("./include/membersite_config.php");
	$fgmembersite->LogOut();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<link rel="shortcut icon" href="images/logo.png">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" href="images/logo.png">
		<title>VisKo</title>
		<link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
		<script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
	</head>
	<body>
	
		<div class="right_header">
				
		</div>
		
		<div id="main_container">
			<div class="header">
				<div id="logo">
					<a href="http://cs4311.cs.utep.edu/team3/"><img src="images/logo.png" alt="" border="0" /></a>
					<font size="10" color="white"><b> VisKo</b></font>
				</div>
			</div>
			<div id="middle_box">
				<div class="middle_box_content">
						<font size="5" color="black">You have logged out.</font>
						<br><br>
						<font size="2" color="black">You are being redirected to the home page.</font>
				</div>
			</div>
		</div>
		<br/><br/><br/>
		<footer>&copy; Developmental Technologies Team. All Rights Reserved</footer>
	</body>
</html>
