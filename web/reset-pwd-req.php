<?PHP
	require_once("./include/membersite_config.php");
	$emailsent = false;
	if(isset($_POST['submitted'])){
		if($fgmembersite->EmailResetPasswordLink()){
			$fgmembersite->RedirectToURL("index.php");
			exit;
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<link rel="shortcut icon" href="images/logo.png">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Reset Password Request</title>
		<link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
		<script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
	</head>
	
	<body>
		<div id="main_container">
			<div class="header">
				<div id="logo">
					<a href="index.php"><img src="images/logo.png" alt="" border="0" /></a>
					<font size="10" color="white"><b> VisKo</b></font>
				</div>
			</div>
			<div id="middle_box">
				<div class="middle_box_content">
					<div id='fg_membersite'>
						<form id='resetreq' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
							<fieldset>
								<legend>Reset Password</legend>

								<input type='hidden' name='submitted' id='submitted' value='1'/>

								<div class='short_explanation'>* required fields</div>

								<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
								<div class='container'>
									<label for='username' >Your Email*:</label><br/>
									<input type='text' name='email' id='email' value='<?php echo $fgmembersite->SafeDisplay('email') ?>' maxlength="50" /><br/>
									<span id='resetreq_email_errorloc' class='error'></span>
								</div>
								<div class='short_explanation'>A link to reset your password will be sent to the email address</div>
								<div class='container'>
									<input type='submit' name='Submit' value='Submit' />
								</div>
							</fieldset>
						</form>

						<script type='text/javascript'>
							// <![CDATA[

							var frmvalidator  = new Validator("resetreq");
							frmvalidator.EnableOnPageErrorDisplay();
							frmvalidator.EnableMsgsTogether();

							frmvalidator.addValidation("email", "req",   "Please provide the email address used to sign-in");
							frmvalidator.addValidation("email", "email", "Please provide the email address used to sign-in");
							// ]]>
						</script>
					</div>
				</div>
			</div>
		</div>
		<br/><br/><br/>
		<footer>&copy; Developmental Technologies Team. All Rights Reserved</footer>
	</body>
</html>
