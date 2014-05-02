<?php
	require_once("./include/membersite_config.php");
	
	/*if user wants to access page by having the entire URL
		but has not yet logged in, it will kick them out to the index page*/
	if(!$fgmembersite->CheckLogin()){
		$fgmembersite->RedirectToURL("index.php");
		exit;
	}

	if(isset($_POST['submitted'])){
		if($fgmembersite->chngInfo()){
			//$fgmembersite->RedirectToURL("changed-pwd.html");
		}
	}
	
	//returns the name of the person who is logged in.
	$nameOfPerson = $fgmembersite->UserEmail();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<link rel="shortcut icon" href="images/logo.png">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>VisKo</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
		<script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
		<style type="text/css">
		table.bottomBorder { border-collapse:collapse; }
		table.bottomBorder td, table.bottomBorder th { border-bottom:1px dotted black;padding:5px; }
		</style>
		<link rel="stylesheet" href="./css/fg_membersite.css" type="text/css"/>
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
					<!--<form id ="mainForm" action="ConfigureAccountRegularUser.php" method="post">-->
					<form id ="mainForm" action="<?php echo $fgmembersite->GetSelfScript(); ?>" method="post">
						<font size="5" color="black">Change Password</font></br></br></br>
							<input type='hidden' name='submitted' id='submitted' value='1'/>
							<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
							<table width="70%">
								<tr>
									<td>Current Password:</td>
									<td>
										<input type="password" name="currentPwd" id="currentPwd" size="60">
										<br/><span id='mainForm_currentPwd_errorloc' class='error'></span>
									</td>
								</tr>
								<tr height="20px"></tr>
								<tr>
									<td>New Password:</td>
									<td>
										<input type="password" name="newPwd" id="newPwd" size="60">
										<br/><span id='mainForm_newPwd_errorloc' class='error'></span>
									</td>
								</tr>
								<tr height="20px"></tr>
								<tr>
									<td>Confirm New Password:</td>
									<td>
										<input type="password" name="confNewPwd" id="confNewPwd" size="60">
										<br/><span id='mainForm_confNewPwd_errorloc' class='error'></span>
									</td>
								</tr>
							</table>	
						</br></br>

						<font size="5" color="black">Change Email</font></br></br></br>	
							<table width="70%">
								<tr>
									<td>New Email Address:</td>
									<td>
										<input type="text" name="newEmail" id="newEmail" value='<?php echo $fgmembersite->SafeDisplay('newEmail') ?>' size="60">
										<br/><span id='mainForm_newEmail_errorloc' class='error'></span>
									</td>
								</tr>
								<tr height="20px"></tr>
								<tr>
									<td>New Email Address Confirmed:</td>
									<td>
										<input type="text" name="confNewEmail" id="confNewEmail" value='<?php echo $fgmembersite->SafeDisplay('confNewEmail') ?>' size="60">
										<br/><span id='mainForm_confNewEmail_errorloc' class='error'></span>
									</td>
								</tr>
								<tr height="20px"></tr>
							</table>
						<div align="center">
							
							<input id="button_id2" type='submit' value='Submit Changes'/>
							</br></br>
						</div>

						<script type='text/javascript'>
							// <![CDATA[
							var frmvalidator = new Validator("mainForm");
							frmvalidator.EnableOnPageErrorDisplay();
							frmvalidator.EnableMsgsTogether();
							
							if(!document.getElementById(currentPwd) && !document.getElementById(newPwd) && !document.getElementById(confNewPwd) && document.getElementById(newEmail) && document.getElementById(confNewEmail) ||
							   !document.getElementById(currentPwd) && document.getElementById(newPwd) && !document.getElementById(confNewPwd) && document.getElementById(newEmail) && document.getElementById(confNewEmail) ||
							   !document.getElementById(currentPwd) && !document.getElementById(newPwd) && document.getElementById(confNewPwd) && document.getElementById(newEmail) && document.getElementById(confNewEmail) ||
							   document.getElementById(currentPwd) && !document.getElementById(newPwd) && !document.getElementById(confNewPwd) && document.getElementById(newEmail) && document.getElementById(confNewEmail)){
								frmvalidator.addValidation("currentPwd",   "req",   " Please Provide Your Current Password");
								frmvalidator.addValidation("newPwd",       "req",   " Please Provide Your New Passwrord");
								frmvalidator.addValidation("confNewPwd",   "req",   " Please Confirm Your New Password");
							} else if(document.getElementById(newEmail) && document.getElementById(confNewEmail)){
								frmvalidator.addValidation("newEmail",     "req", " Please Provide Your Correct Email");
								frmvalidator.addValidation("newEmail",     "email", " Please Provide Your Correct Email");
								frmvalidator.addValidation("confNewEmail", "req",   " Please Confirm Your Email");
							}
							// ]]>
						</script>
						<footer>&copy; Developmental Technologies Team. All Rights Reserved</footer>
					</form>
				</div>
			</div>
		</div>
	</body>
	
<div id="nav_table" style="position: fixed; left:0px; right: 31px; top: 120px; bottom: auto; display: block">
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
		  <td><center><br><a href="./SelectOperation.php" style="text-decoration:none;"><font size="5" color="black">Manage <br> Services</font></a><br><br></td>
		</tr>
		<tr>
		  <td><center><br><a href="./ConfigureAccountRegularUser.php" style="text-decoration:none;"><font size="5" color="black">Configure <br> Account</font></a><br><br></td>
		</tr>
	</table>
    </ul>
</div>
</body>
</html>