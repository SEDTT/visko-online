<?PHP
	require_once("./include/membersite_config.php");
	if(isset($_POST['submitted'])){
		if($fgmembersite->RegisterUser()){
			$fgmembersite->RedirectToURL("index.php");
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" href="images/logo.png">
		<title>VisKo</title>
		
		<!--CSS-->
		<link rel="stylesheet" href="./css/fg_membersite.css" type="text/css"/>
		<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
		
		<!--Scripts-->
		<script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
		<script src="scripts/pwdwidget.js" type="text/javascript"></script>

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
						<!-- Form Code Start -->
						<div id='fg_membersite'>
							<form id='register' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
								<fieldset id="registerField1">
									<legend>Register</legend>

									<input type='hidden' name='submitted' id='submitted' value='1'/>

									<div class='short_explanation'>* required fields</div>
									<br>
									<input type='text' class='spmhidip' name='<?php echo $fgmembersite->GetSpamTrapInputName(); ?>' />
							
									<!--Do not remove this line below-->
									<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
							
									<div id="emailAddress1">
										<label for='U_email' >Email *:</label><br/>
										<input type='text' name='U_email' id='U_email' value='<?php echo $fgmembersite->SafeDisplay('U_email') ?>' maxlength="50" /><br/>
										<span id='register_U_email_errorloc' class='error'></span>
									</div>
									
									<!--Does not store this 'password' but is used to only compare with the 'password' above-->
									<div id="emailAddress2">
										<label for='U_email_Con' >Confirm Email *:</label><br/>
										<input type='text' name='U_email_Con' id='U_email_Con' value='<?php echo $fgmembersite->SafeDisplay('U_email_Con') ?>' maxlength="50" /><br/>
										<span id='register_U_email_Con_errorloc' class='error'></span>
									</div>
							
									<div id="passWord">
										<label for='U_pwd' >Password*:</label><br/>
										<input type='password' name='U_pwd' id='U_pwd' maxlength="50" />
										<div id='register_U_pwd_errorloc' class='error'></div>
									</div>
							
									<div id="passWordCon">
										<label for='U_pwd_Con' >Confirm Password*:</label><br/>
										<input type='password' name='U_pwd_Con' id='U_pwd_Con' maxlength="50" />    
										<div id='register_U_pwd_Con_errorloc' class='error'></div>
									</div>
							
									<hr style="width:500px;"/>
									
									<div id="firstName">
										<label for='U_first'>First Name*: </label><br/>
										<input type='text' name='U_first' id='U_first' value='<?php echo $fgmembersite->SafeDisplay('U_first') ?>' maxlength="50" /><br/>
										<span id='register_U_first_errorloc' class='error'></span>
									</div>
							
									<div id="lastName">
										<label for='U_last'>Last Name*: </label><br/>
										<input type='text' name='U_last' id='U_last' value='<?php echo $fgmembersite->SafeDisplay('U_last') ?>' maxlength="50" /><br/>
										<span id='register_U_last_errorloc' class='error'></span>
									</div>
									
									<div class='container'>
										<label for='U_affiliation' >Organization Affiliation:</label><br/>
										<input type='text' name='U_affiliation' id='U_affiliation' value='<?php echo $fgmembersite->SafeDisplay('U_affiliation') ?>' maxlength="100" /><br/>
										<span id='register_orgAffiliation_errorloc' class='error'></span>
									</div>

									<div align="center">
										<input type='submit' name='Create Account' value='Create Account' style="width:105px"/>
										<!--<input type='button' name='' value='back' onclick="history.back();"/>-->
									</div>
								</fieldset>
							</form>
						</div>
				</div>
			</div>
		</div>
		
		<!-- client-side Form Validations:
			Uses the excellent form validation script from JavaScript-coder.com-->

			<script type='text/javascript'>
				// <![CDATA[
				var frmvalidator = new Validator("register");
				frmvalidator.EnableOnPageErrorDisplay();
				frmvalidator.EnableMsgsTogether();
				
				frmvalidator.addValidation("U_email",     "req",   " Please fill in your email");
				frmvalidator.addValidation("U_email",     "email", " Please input a valid email");
				frmvalidator.addValidation("U_email_Con", "req",   " Please confirm your email");
				frmvalidator.addValidation("U_pwd",       "req",   " Please fill in your password");
				frmvalidator.addValidation("U_pwd_Con",   "req",   " Please confirm your password");
				frmvalidator.addValidation("U_first",     "req",   " Please fill in your first name");
				frmvalidator.addValidation("U_last",      "req",   " Please fill in your last name");
				// ]]>
			</script>
			<!--Form Code End (see html-form-guide.com for more info.)-->
			<br/>
				<!--<div align="center">
					<footer id="loginFooter" align="center">
						 <a href="http://admin.utep.edu/Default.aspx?tabid=49976" title="State Reports">State Reports</a>&nbsp;
						|&nbsp;<a href="http://www.utsystem.edu/" title="UT System">UT System</a>&nbsp;
						|&nbsp;<a href="http://www.utep.edu/customerservice.aspx" title="Customer Service Statement">Customer Service Statement</a>&nbsp;
						|&nbsp;<a href="http://www.utep.edu/feedbackform.aspx" title="Site Feedback">Site Feedback</a>&nbsp;
						|&nbsp;<a href="http://www.admin.utep.edu/Default.aspx?tabid=54275" title="Required Links">Required Links</a>&nbsp;
						|&nbsp;<a href="http://admin.utep.edu/Default.aspx?tabid=37475" title="CLERY Crime Statistics">CLERY Crime Statistics</a>&nbsp;
						|&nbsp;<a href="http://sao.fraud.state.tx.us/" title="Report Fraud in Texas">Report Fraud</a><br/>
						The University of Texas at El Paso|500 West University Avenue|El Paso, Texas 79968|(915) 747-5000
					</footer>
				</div>-->
				
		<div id="footer">
			<div class="center_footer">&copy; Developmental Technologies Team. All Rights Reserved</div>
		</div>	
	</body>
</html>
