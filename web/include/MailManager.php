<?PHP
require_once("class.phpmailer.php");
require_once("formvalidator.php");
require_once("fg_membersite.php");

class MailManager{
    var $admin_email;
    var $from_address;
    
    var $username;
    var $pwd;
    var $database;
    var $tablename;
    var $connection;
    var $rand_key;
    
    var $error_message;
	
	function SendAdminIntimationEmail(&$formvars){
        if(empty($this->admin_email)){
            return false;
        }
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($this->admin_email);
        
        $mailer->Subject = "New registration: ".$formvars['name'];

        $mailer->From = $this->GetFromAddress();         
        
        $mailer->Body ="A new user registered at ".$this->sitename."\r\n".
        "Name: ".$formvars['name']."\r\n".
        "Email address: ".$formvars['email']."\r\n".
        "UserName: ".$formvars['username'];
        
        if(!$mailer->Send()){
            return false;
        }
        return true;
    }
	
	function SendUserConfirmationEmail(&$formvars){
		$fgmembersite = new FGMembersite();
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($formvars['U_email'], $formvars['U_first']);
        
        $mailer->Subject = "Your registration with VisKo site" /*. $fgmembersite->sitename*/;

        //$mailer->From = $fgmembersite->GetFromAddress();        
        
        //$confirmcode = $formvars['confirmcode'];
        
        $confirm_url = $fgmembersite->GetAbsoluteURLFolder() . '/confirmreg.php?code= test' ; /*. $confirmcode;*/
        
        $mailer->Body = "Hello ".$formvars['name']."\r\n\r\n".
						"Thanks for your registration with ".$fgmembersite->sitename."\r\n".
						"Please click the link below to confirm your registration.\r\n".
						"$confirm_url\r\n".
						"\r\n".
						"Regards,\r\n".
						"Webmaster\r\n".
						$fgmembersite->sitename;

        if(!$mailer->Send()){
            $fgmembersite->HandleError("Failed sending registration confirmation email.");
            return false;
        }
        return true;
    }
	
	function SendResetPasswordLink($user_rec){
        $email = $user_rec['U_email'];
        $pwd = md5($user_rec['U_pwd']);
        
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($email, $user_rec['name']);
        
        $mailer->Subject = "Your reset password request at " . $this->sitename;

        $mailer->From = $this->GetFromAddress();
        
        //$link = $this->GetAbsoluteURLFolder().'/resetpwd.php?email='.urlencode($email).'&code='.urlencode($this->GetResetPasswordCode($email));

        $mailer->Body ="Hello " . $email . "\r\n\r\n".
        "There was a request to reset your password at " . $this->sitename . "\r\n".
        "Your password is: " . $pwd . "\r\n".
        "Regards,\r\n".
        "Webmaster\r\n".
        $this->sitename;
        
        if(!$mailer->Send()){
            return false;
        }
        return true;
    }
    
    function SendNewPassword($user_rec, $new_password){
        $email = $user_rec['email'];
        
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($email,$user_rec['name']);
        
        $mailer->Subject = "Your new password for ".$this->sitename;

        $mailer->From = $this->GetFromAddress();
        
        $mailer->Body ="Hello ".$user_rec['name']."\r\n\r\n".
        "Your password is reset successfully. ".
        "Here is your updated login:\r\n".
        "username:".$user_rec['username']."\r\n".
        "password:$new_password\r\n".
        "\r\n".
        "Login here: ".$this->GetAbsoluteURLFolder()."/login.php\r\n".
        "\r\n".
        "Regards,\r\n".
        "Webmaster\r\n".
        $this->sitename;
        
        if(!$mailer->Send()){
            return false;
        }
        return true;
    }
	
	function SendUserWelcomeEmail(&$user_rec){
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($user_rec['email'],$user_rec['name']);
        
        $mailer->Subject = "Welcome to ".$this->sitename;

        $mailer->From = $this->GetFromAddress();        
        
        $mailer->Body ="Hello ".$user_rec['name']."\r\n\r\n".
        "Welcome! Your registration  with ".$this->sitename." is completed.\r\n".
        "\r\n".
        "Regards,\r\n".
        "Webmaster\r\n".
        $this->sitename;

        if(!$mailer->Send()){
            $this->HandleError("Failed sending user welcome email.");
            return false;
        }
        return true;
    }
    
    function SendAdminIntimationOnRegComplete(&$user_rec){
        if(empty($this->admin_email)){
            return false;
        }
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($this->admin_email);
        
        $mailer->Subject = "Registration Completed: ".$user_rec['name'];

        $mailer->From = $this->GetFromAddress();         
        
        $mailer->Body ="A new user registered at ".$this->sitename."\r\n".
        "Name: ".$user_rec['name']."\r\n".
        "Email address: ".$user_rec['email']."\r\n";
        
        if(!$mailer->Send()){
            return false;
        }
        return true;
    }
}	
?>