<?php
require_once("class.phpmailer.php");

$message = "TEST:Account Verification Link Here";  //simple message only  you can add headers and other stuff

$mail = new PHPMailer();

$mail->IsSMTP();
$mail->Host       = "smtp.gmail.com"; // SMTP server example
$mail->SMTPAuth   = true;             // enable SMTP authentication
$mail->SMTPSecure = "TLS";
$mail->Port       = 465;              // set the SMTP port for the GMAIL server
$mail->Encoding   = '7bit';

$mail->Username   = "ecorra37@gmail.com"; // SMTP account username example  WHERE YOURE SENDING FROM
$mail->Password   = "sk8low1432";         // SMTP account password example

$mail->body = $message;
$mail->AddAddress("ecorral2@miners.utep.edu", "test");  //WHERE YOURE SENDING TO 

if(!$mail->send()) {
	echo 'Message could not be sent.';
	echo 'Mailer Error: ' . $mail->ErrorInfo;
	return false;
	exit;
}
return true;
?>