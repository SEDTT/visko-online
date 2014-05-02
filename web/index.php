<?php
	require_once("./include/membersite_config.php");
	if(isset($_POST['submitted'])){
		if($fgmembersite->Login()){
			$fgmembersite->RedirectToURL("./RegularUserHome.php");
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<link rel="shortcut icon" href="images/logo.png">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Team 3</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<!--StyleSheets-->
		
		<link rel="shortcut icon" href="./images/log.ico"/>
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
				<div class="right_header" id="fg_membersite">
					<br>
					<br>
					<fieldset>
						<table>
							<legend><font color="white">Login</font></legend>
							
							<form id='login' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
								<input type='hidden' name='submitted' id='submitted' value='1'/>
								<tr>
									<td>
										<span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span>
									</td>
								</tr>
								<tr>
									<td class="container">
										<label for='U_email' ><font color="white">Email:</font></label>
										<input type='text' name='U_email' id='U_email' value='<?php echo $fgmembersite->SafeDisplay('U_email') ?>' maxlength="50" />
										<span id='login_U_email_errorloc' class='error'></span>
									</td>
									<td width="30px;" class="container">
										<label for='U_pwd' ><font color="white">Password:</font></label>
									</td>
									<td class="container">
										<input type='password' name='U_pwd' id='U_pwd' maxlength="50" />
										<span id='login_U_pwd_errorloc' class='error'></span>	
									</td>
									<td>
										<input type='submit' name='Submit' value='Login' />
									</td>
							</form>
									<td>
										<form id="register" action="./adminRegister.php" method="get">
											<input type="submit" value="Register" name="Register"/>
										</form>
									</td>
								</tr>
							<tr>
								<td></td>
								<td></td>
								<td>
									<a href="./reset-pwd-req.php"><font size="1" color="white">Forgot Password?</font></a>
								</td>
							</tr>
						</table>
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
			<br/><br/><br/>
			<footer>&copy; Developmental Technologies Team. All Rights Reserved</footer>
		</div>
		
		<script type='text/javascript'>
			// <![CDATA[
			var frmvalidator  = new Validator("login");
			frmvalidator.EnableOnPageErrorDisplay();
			frmvalidator.EnableMsgsTogether();

			frmvalidator.addValidation("U_email", "req", "Please Provide Your Email");
			frmvalidator.addValidation("U_pwd",   "req", "Please Provide Your Password");
			// ]]>
		</script>
	</body>
</html>