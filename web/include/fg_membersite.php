<?PHP
require_once("class.phpmailer.php");
require_once("formvalidator.php");
require_once("MailManager.php");
require_once("class.smtp.php");

class FGMembersite{
	var $admin_email;
    var $from_address;
    
    var $username;
    var $pwd;
    var $database;
    var $tablename;
    var $connection;
    var $rand_key;
    
    var $error_message;
    
    //-----Initialization -------
    function FGMembersite(){
        $this->sitename = 'YourWebsiteName.com';
        $this->rand_key = '0iQx5oBk66oVZep';
    }
    
    function InitDB($host,$uname,$pwd,$database,$tablename){
        $this->db_host   = $host;
        $this->username  = $uname;
        $this->pwd       = $pwd;
        $this->database  = $database;
        $this->tablename = $tablename;
    }
	
    function SetAdminEmail($email){
        $this->admin_email = $email;
    }
    
    function SetWebsiteName($sitename){
        $this->sitename = $sitename;
    }
    
    function SetRandomKey($key){
        $this->rand_key = $key;
    }
    
    /*----User Manager----*/
    function RegisterUser(){
		$mailMan = new MailManager();
		//$mailer = new Mail();
        if(!isset($_POST['submitted'])){
           return false;
        }
        
        $formvars = array();
        
        if(!$this->ValidateRegistrationSubmission()){
            return false;
        }
		
        $this->CollectRegistrationSubmission($formvars);
        
		if(!$this->checkSimilar($formvars)){
			return false;
		}
		
        if(!$this->SaveToDatabase($formvars)){
            return false;
        }
		
        /*if(!$mailMan->SendUserConfirmationEmail($formvars)){
			$this->HandleError("Could not send email!");
            return false;
        }*/
		
		if(!$this->sendConfimMail($formvars)){
			$this->HandleError("Could not send email!");
            return false;
        }

        //$mailMan->SendAdminIntimationEmail($formvars);
        
        return true;
    }

    function ConfirmUser(){
        if(empty($_GET['code'])||strlen($_GET['code'])<=10){
            $this->HandleError("Please provide the confirm code");
            return false;
        }
        $user_rec = array();
        if(!$this->UpdateDBRecForConfirmation($user_rec)){
            return false;
        }
        
        $this->SendUserWelcomeEmail($user_rec);
        
        $this->SendAdminIntimationOnRegComplete($user_rec);
        
        return true;
    }
	
	//searches for any regular user and returns a query.
	function searchUser(){
		if(!isset($_POST['submitted'])){
           return false;
        }
        
        $formvars = array();
		//$qry = array();
		
		//$qry[1] = mysql_connect($this->db_host, $this->username, $this->pwd);
		
        $this->CollectSearchUserSubmission($formvars);
		
		$qry = "SELECT * FROM cs4311team3sp14.User WHERE U_email = '" . $formvars['U_email'] . "' OR U_first = '" . $formvars['U_first'] . "' OR U_last = '" . $formvars['U_last'] ."'";
		
		return $qry;
	}
	
	
    function Login(){
        if(empty($_POST['U_email'])){
            $this->HandleError("Email is empty!");
            return false;
        }
        
        if(empty($_POST['U_pwd'])){
            $this->HandleError("Password is empty!");
            return false;
        }
        
        $email    = trim($_POST['U_email']);
        $password = trim($_POST['U_pwd']);
        
        if(!isset($_SESSION)){ session_start(); }
        if(!$this->CheckLoginInDB($email, $password)){
            return false;
        }
        
        $_SESSION[$this->GetLoginSessionVar()] = $email;
        
        return true;
    }
    
    function CheckLogin(){
		if(!isset($_SESSION)){ session_start(); }

		$sessionvar = $this->GetLoginSessionVar();

		if(empty($_SESSION[$sessionvar])){
			return false;
		}
		return true;
    }
    
	//returns the full name of the user.
    function UserFullName(){
        return isset($_SESSION['name_of_user']) ? $_SESSION['name_of_user'] : $_SESSION['email_of_user'];
    }
    
	//returns the email of the user
    function UserEmail(){
        return isset($_SESSION['email_of_user']) ? $_SESSION['email_of_user'] : '';
    }
	
	//returns 1 if the user is a regular user or a 0 if the user is a privileged user.
	function userX(){
        return isset($_SESSION['kind']) ? $_SESSION['kind'] : '';
    }
    
	//logs out the user and closes the session that was initiated by the user at log in time.
    function LogOut(){
        session_start();
        
        $sessionvar = $this->GetLoginSessionVar();
        
        $_SESSION[$sessionvar]=NULL;
        
        unset($_SESSION[$sessionvar]);
    }
    
	//this method is only being used within this same class.
	// no external usage.
	// logs out the user when they have changed either password or email address
	function logingOut(){
        //session_start();
        
        $sessionvar = $this->GetLoginSessionVar();
        
        $_SESSION[$sessionvar] = NULL;
        
        unset($_SESSION[$sessionvar]);
    }
	
	//-------Public Helper functions -------------
    function GetSelfScript(){
        return htmlentities($_SERVER['PHP_SELF']);
    }    
    
    function SafeDisplay($value_name){
        if(empty($_POST[$value_name])){
            return'';
        }
        return htmlentities($_POST[$value_name]);
    }
    
    function RedirectToURL($url){
        header("Location: $url");
        exit;
    }
    
    function GetSpamTrapInputName(){
        return 'sp'.md5('KHGdnbvsgst'.$this->rand_key);
    }
	
	//-------Private Helper functions-----
	function GetFromAddress(){
        if(!empty($this->from_address)){
            return $this->from_address;
        }

        $host = $_SERVER['SERVER_NAME'];

        $from ="viskoservices@visko.net";
        return $from;
    } 
    
    function GetLoginSessionVar(){
        $retvar = md5($this->rand_key);
        $retvar = 'usr_'.substr($retvar,0,10);
        return $retvar;
    }
    
	//used
    function GetUserFromEmail($email, &$user_rec){
        if(!$this->DBLogin()){
            $this->HandleError("Database login failed!");
            return false;
        }
		
        $email = $this->SanitizeForSQL($email);
        
		$qry = "SELECT * FROM $this->tablename WHERE U_email = '$email'";
		
        $result = mysql_query($qry, $this->connection);  

        if(!$result || mysql_num_rows($result) <= 0){
            $this->HandleError("There is no user with email: $email");
            return false;
        }
        $user_rec = mysql_fetch_assoc($result);
        
        return true;
    }
    
    function GetResetPasswordCode($email){
       return substr(md5($email.$this->sitename.$this->rand_key),0,10);
    }
	
	//Used for the registration of the user.
	// if needed to validate any other user input just duplicate from line 509 to 536
    function ValidateRegistrationSubmission(){
        //This is a hidden input field. Humans won't fill this field.
        if(!empty($_POST[$this->GetSpamTrapInputName()]) ){
            //The proper error is not given intentionally
            $this->HandleError("Automated submission prevention: case 2 failed");
            return false;
        }
        
        $validator = new FormValidator();
        $validator->addValidation("U_email",     "req",   " Please Fill in Your Email");
        $validator->addValidation("U_email",     "email", " Please input a valid Email");
        $validator->addValidation("U_email_Con", "req",   " Please Confirm Your Email");
        $validator->addValidation("U_pwd",       "req",   " Please Fill in Your Password");
        $validator->addValidation("U_pwd_Con",   "req",   " Please Confirm Your Password");
        //$validator->addValidation("U_first",     "req",   " Please Fill in Your Firstname");
        //$validator->addValidation("U_last",      "req",   " Please Fill in Your Lastname");
        //$validator->addValidation("orgAffiliation", "req",   " Please fill in UserName");
		
        if(!$validator->ValidateForm()){
            $error='';
            $error_hash = $validator->GetErrors();
            foreach($error_hash as $inpname => $inp_err){
                $error .= $inpname.':'.$inp_err."\n";
            }
            $this->HandleError($error);
            return false;
        }
		
        return true;
    }
	
	/*works well
		no need for this one!*/
	function validatePwdChngSubmission(){
        //This is a hidden input field. Humans won't fill this field.
        if(!empty($_POST[$this->GetSpamTrapInputName()]) ){
            //The proper error is not given intentionally
            $this->HandleError("Automated submission prevention!");
            return false;
        }
        
        $validator = new FormValidator();
		$validator->addValidation("currentPwd", "req", " Your Current Password is Empty!");
		$validator->addValidation("newPwd",     "req", " Your New Password is Empty!");
		$validator->addValidation("confNewPwd", "req", " Confirm Your New Password!");
		
        if(!$validator->ValidateForm()){
            $error='';
            $error_hash = $validator->GetErrors();
            foreach($error_hash as $inpname => $inp_err){
                $error .= $inpname.':'.$inp_err."\n";
            }
            $this->HandleError($error);
            return false;
        }
		
        return true;
    }
	
	function validateEmailChngSubmission(){
        //This is a hidden input field. Humans won't fill this field.
        if(!empty($_POST[$this->GetSpamTrapInputName()]) ){
            //The proper error is not given intentionally
            $this->HandleError("Automated submission prevention!");
            return false;
        }
        
        $validator = new FormValidator();
		$validator->addValidation("newEmail",     "req",   " Your New Email is Empty!");
		$validator->addValidation("newEmail",     "email", " New Email Is Not A Valid Email!");
		$validator->addValidation("confNewEmail", "req",   " Confirm Your New Email!");
		
        if(!$validator->ValidateForm()){
            $error='';
            $error_hash = $validator->GetErrors();
            foreach($error_hash as $inpname => $inp_err){
                $error .= $inpname.':'.$inp_err."\n";
            }
            $this->HandleError($error);
            return false;
        }
		
        return true;
    }
	
    function CollectRegistrationSubmission(&$formvars){
        $formvars['U_email']        = $this->Sanitize($_POST['U_email']);
        $formvars['U_email_Con']    = $this->Sanitize($_POST['U_email_Con']);
        $formvars['U_pwd']          = $this->Sanitize($_POST['U_pwd']);
        $formvars['U_pwd_Con']      = $this->Sanitize($_POST['U_pwd_Con']);
        $formvars['U_first']        = $this->Sanitize($_POST['U_first']);
        $formvars['U_last']         = $this->Sanitize($_POST['U_last']);
        $formvars['U_affiliation']  = $this->Sanitize($_POST['U_affiliation']);
    }
	
	//used for User Search
	function CollectSearchUserSubmission(&$formvars){
        $formvars['U_email'] = $this->Sanitize($_POST['U_email']);
        $formvars['U_first'] = $this->Sanitize($_POST['U_first']);
        $formvars['U_last']  = $this->Sanitize($_POST['U_last']);
    }
	
	/********************************************************************************/
	function getNumbers(){
		$number = array();
		
		$this->connection = mysql_connect($this->db_host, $this->username, $this->pwd);
		
		$number['timeOut']     = mysql_query("SELECT COUNT(id) FROM 'ServiceTimeoutErrors'", $this->connection);
		$number['inputData']   = mysql_query("SELECT COUNT(id) FROM 'InputDataURLErrors'", $this->connection);
		$number['serviceExec'] = mysql_query("SELECT COUNT(id) FROM 'ServiceExecutionErrors'", $this->connection);
		
		return $number;
	}
	/********************************************************************************/
	
	function collectPwdChangeSubmission(&$formvars){
        $formvars['currentPwd'] = $this->Sanitize($_POST['currentPwd']);
        $formvars['newPwd']     = $this->Sanitize($_POST['newPwd']);
        $formvars['confNewPwd'] = $this->Sanitize($_POST['confNewPwd']);
    }
	
	function collectEmailChangeSubmission(&$formvars){
        $formvars['newEmail']     = $this->Sanitize($_POST['newEmail']);
        $formvars['confNewEmail'] = $this->Sanitize($_POST['confNewEmail']);
    }
	
	//checks for similar submission inputs in the registration form.
	function checkSimilar(&$formvars){
		$validator = new FormValidator();
		
		$email1 = $formvars['U_email'];
		$email2 = $formvars['U_email_Con'];
		$pass1  = $formvars['U_pwd'];
		$pass2  = $formvars['U_pwd_Con'];
		
		if($email1 !== $email2){
			$this->HandleError("Emails do not match");
            return false;
		}
		
		if($pass1 !== $pass2){
			$this->HandleError("Passwords do not match");
            return false;
		}
        return true;
	}
	
	/*checks if the passwords match*/
	function checkSimilarPwd(&$formvars){
		$validator = new FormValidator();
		
		$curPwd = $formvars['currentPwd'];
		$pwd1   = $formvars['newPwd'];
		$pwd2   = $formvars['confNewPwd'];
		
		//checking if the current password is the same as the new one.
		// should not let user change it to the same password
		if($curPwd === $pwd1){
			$this->HandleError("Your New Password Cannot Be The Same As The Current Password");
            return false;
		}
		
		//new and the confirmed passwords should match
		if($pwd1 !== $pwd2){
			$this->HandleError("New Passwords Do Not Match");
            return false;
		}
        return true;
	}
	
	function checkSimilarEmail(&$formvars){
		$validator = new FormValidator();
		
		$email1 = $formvars['newEmail'];
		$email2 = $formvars['confNewEmail'];
		
		if($email1 !== $email2){
			$this->HandleError("Emails Do Not Match");
            return false;
		}
        return true;
	}
    
    function GetAbsoluteURLFolder(){
        $scriptFolder = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
        $scriptFolder .= $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
        return $scriptFolder;
    }
    
	//used for the VisKo project
	// If need to use, just invoke the method
    function IsFieldUnique($formvars, $fieldname){
        $field_val = $this->SanitizeForSQL($formvars[$fieldname]);
        $qry = "SELECT U_email FROM $this->tablename WHERE $fieldname='".$field_val."'";
        
		$result = mysql_query($qry, $this->connection);   
        if($result && mysql_num_rows($result) > 0){
            return false;
        }
        return true;
    }
	
    function MakeConfirmationMd5($email){
        $randno1 = rand();
        $randno2 = rand();
        return md5($email.$this->rand_key.$randno1.''.$randno2);
    }
	
    function SanitizeForSQL($str){
        if( function_exists( "mysql_real_escape_string" ) ){
              $ret_str = mysql_real_escape_string( $str );
        } else {
              $ret_str = addslashes( $str );
        }
        return $ret_str;
    }
    
	/*Sanitize() function removes any potential threat from the
    data submitted. Prevents email injections or any other hacker attempts.
    if $remove_nl is true, newline characters are removed from the input.*/
    function Sanitize($str,$remove_nl=true){
        $str = $this->StripSlashes($str);

        if($remove_nl){
            $injections = array('/(\n+)/i',
                '/(\r+)/i',
                '/(\t+)/i',
                '/(%0A+)/i',
                '/(%0D+)/i',
                '/(%08+)/i',
                '/(%09+)/i'
                );
            $str = preg_replace($injections,'',$str);
        }

        return $str;
    }
	
    function StripSlashes($str){
        if(get_magic_quotes_gpc()){
            $str = stripslashes($str);
        }
        return $str;
    }
	
	
	/*------------------------Database Manager------------------------*/
	//used for the VisKo project
	// If need to use, just invoke the method
    function DBLogin(){

        $this->connection = mysql_connect($this->db_host, $this->username, $this->pwd);

        if(!$this->connection){   
            $this->HandleDBError("Database Login failed! Please make sure that the DB login credentials provided are correct");
            return false;
        }
		
        if(!mysql_select_db($this->database, $this->connection)){
			$this->createDB();
            $this->HandleDBError('Failed to select database: ' . $this->database . ' Please make sure that the database name provided is correct');
            return false;
        }
		
        if(!mysql_query("SET NAMES 'UTF8'", $this->connection)){
            $this->HandleDBError('Error setting utf8 encoding');
            return false;
        }
        return true;
    }    
    
	function createDB(){
		echo "I am in the createDB method <br/>";
		$qry = "CREATE DATABASE IF NOT EXISTS $this->database;";
                
        if(!mysql_query($qry, $this->connection)){
            $this->HandleDBError("Error creating the $this->database table \nquery was\n $qry");
            return false;
        }
        return true;
	}
	
	//used for the VisKo project
    function ensureUserTable(){
        $result = mysql_query("SHOW COLUMNS FROM $this->tablename");   
        if(!$result || mysql_num_rows($result) <= 0){
            return $this->createUserTable();
        }
        return true;
    }
    
	//same logic can be used for the other tables
    function createUserTable(){
        $qry = "CREATE TABLE IF NOT EXISTS $this->tablename(".
                "U_id INT NOT NULL AUTO_INCREMENT,".
                "U_email CHAR(255) NOT NULL,".
                "U_first CHAR(255),".
                "U_last CHAR(255),".
                "U_pwd CHAR(255) NOT NULL,".
                "U_reg_user BOOLEAN DEFAULT true,".
                "U_confirmed BOOLEAN DEFAULT false,".
                "U_reg_date CHAR(255) NOT NULL,".
                "U_affiliation CHAR(255) DEFAULT 'N/A',".
                "PRIMARY KEY(U_id, U_email)".
                ");";
                
        if(!mysql_query($qry, $this->connection)){
            $this->HandleDBError("Error creating the $this->tablename table \nquery was\n $qry");
            return false;
        }
        return true;
    }
    
	//inserts into designated table and creates a confirmation code
    function InsertIntoUser(&$formvars){
    
        //$confirmcode = $this->MakeConfirmationMd5($formvars['email']);
        
        //$formvars['confirmcode'] = $confirmcode;
        date_default_timezone_set ("America/Denver"); 
		$time = date("F j, Y, g:i a"); 
		
        $insert_query = 'INSERT INTO ' . $this->tablename . '(U_email, U_first, U_last, U_pwd, U_reg_date, U_affiliation)
                values(
                "' . $this->SanitizeForSQL($formvars['U_email']) . '",
                "' . $this->SanitizeForSQL($formvars['U_first']) . '",
                "' . $this->SanitizeForSQL($formvars['U_last']) . '",
                "' . md5($formvars['U_pwd']) . '",
				"' . $this->SanitizeForSQL($time) . '",
                "' . $this->SanitizeForSQL($formvars['U_affiliation']) . '"
                );';
				
				//"' . $confirmcode . '"
        if(!mysql_query($insert_query, $this->connection)){
            $this->HandleDBError("Error inserting data to the $this->tablename table\nquery: >>> $insert_query <<<");
            return false;
        }        
        return true;
    }
	
	//used for the VisKo project
	// If need to use, just duplicate from line 607 to 632.
    function SaveToDatabase(&$formvars){
        if(!$this->DBLogin()){
            $this->HandleError("Database login failed!");
            return false;
        }
		
        if(!$this->ensureUserTable()){
            return false;
        }
		
		//checking if email is unique
        if(!$this->IsFieldUnique($formvars, 'U_email')){
            $this->HandleError("This email is already registered");
            return false;
        }
		
        if(!$this->InsertIntoUser($formvars)){
            $this->HandleError("Inserting to Database failed!");
            return false;
        }
        return true;
    }
	
	function ResetUserPasswordInDB($user_rec){
        $new_password = substr(md5(uniqid()),0,10);
        
        if(false == $this->chngPwdInDB($user_rec, $new_password)){
            return false;
        }
        return $new_password;
    }
	
	function UpdateDBRecForConfirmation(&$user_rec){
        if(!$this->DBLogin()){
            $this->HandleError("Database login failed!");
            return false;
        }   
        $confirmcode = $this->SanitizeForSQL($_GET['code']);
        
        $result = mysql_query("Select name, email from $this->tablename where confirmcode='$confirmcode'",$this->connection);   
        if(!$result || mysql_num_rows($result) <= 0){
            $this->HandleError("Wrong confirm code.");
            return false;
        }
        $row = mysql_fetch_assoc($result);
        $user_rec['name'] = $row['name'];
        $user_rec['email']= $row['email'];
        
        $qry = "Update $this->tablename Set confirmcode='y' Where  confirmcode='$confirmcode'";
        
        if(!mysql_query( $qry ,$this->connection)){
            $this->HandleDBError("Error inserting data to the table\nquery:$qry");
            return false;
        }      
        return true;
    }
	
	function CheckLoginInDB($username, $password){
        if(!$this->DBLogin()){
            $this->HandleError("Database login failed!");
            return false;
        }
		
        $email = $this->SanitizeForSQL($username);
        $pwdmd5 = md5($password);
        //$qry = "Select email from $this->tablename where username='$username' and password='$pwdmd5' and confirmcode='y'";
		
		//
		$qry = "SELECT U_first, U_last, U_email, U_reg_user FROM $this->tablename WHERE U_email='$email' and U_pwd='$pwdmd5'";
        
        $result = mysql_query($qry, $this->connection);
        
        if(!$result || mysql_num_rows($result) <= 0){
            $this->HandleError("Error logging in. The username or password does not match");
            return false;
        }
        
        $row = mysql_fetch_assoc($result);
        
        $_SESSION['name_of_user']  = $row['U_first'].' '.$row['U_last'];
        $_SESSION['email_of_user'] = $row['U_email'];
        $_SESSION['kind']          = $row['U_reg_user'];
        
        return true;
    }
	
	//this method will reset user password
    function ResetPassword(){
        if(empty($_GET['email'])){
            $this->HandleError("Email is empty!");
            return false;
        }
		
        if(empty($_GET['code'])){
            $this->HandleError("reset code is empty!");
            return false;
        }
        $email = trim($_GET['email']);
        $code = trim($_GET['code']);
        
        if($this->GetResetPasswordCode($email) != $code){
            $this->HandleError("Bad reset code!");
            return false;
        }
        
        $user_rec = array();
        if(!$this->GetUserFromEmail($email,$user_rec)){
            return false;
        }
        
        $new_password = $this->ResetUserPasswordInDB($user_rec);
        if(false === $new_password || empty($new_password)){
            $this->HandleError("Error updating new password");
            return false;
        }
        
        if(false == $this->SendNewPassword($user_rec,$new_password)){
            $this->HandleError("Error sending new password");
            return false;
        }
        return true;
    }
	
	/*From old files*/
	function chngInfo(){ 
		$formvars = array();
		
        if(!empty($_POST['currentPwd'] && $_POST['newPwd'] && $_POST['confNewPwd']) ||
		   !empty($_POST['currentPwd'] && $_POST['newPwd']) && empty($_POST['confNewPwd']) ||
		   !empty($_POST['currentPwd']) && empty($_POST['newPwd'] && $_POST['confNewPwd']) ||
		   empty($_POST['currentPwd']) && !empty($_POST['newPwd'] && $_POST['confNewPwd'])){
			if(!$this->validatePwdChngSubmission()){
				return false;
			}
			
			$this->collectPwdChangeSubmission($formvars);
			
			if(!$this->checkSimilarPwd($formvars)){
				return false;
			}
			
			if($this->chngPwdInDB($_POST['currentPwd'], $_POST['newPwd'])){
				$this->logingOut();
				$this->RedirectToURL("pwdChng.php");
				exit;
			}
            return false;
		} else if(!empty($_POST['newEmail'] && $_POST['confNewEmail']) ||
				  !empty($_POST['newEmail']) && empty($_POST['confNewEmail']) ||
				  empty($_POST['newEmail']) && !empty($_POST['confNewEmail'])){
			if(!$this->validateEmailChngSubmission()){
				return false;
			}
			
			$this->collectEmailChangeSubmission($formvars);
			
			if(!$this->checkSimilarEmail($formvars)){
				return false;
			}
			
			if($this->chngEmailInDB($formvars)){
				$this->logingOut();
				$this->RedirectToURL("emailChng.php");
				exit;
			}
		
		
			$this->HandleError("Please Fill in The Fields You Wish to Change!");
            return false;
		} else if(empty($_POST['currentPwd'] && $_POST['newPwd'] && $_POST['confNewPwd'] && $_POST['newEmail'] && $_POST['confNewEmail'])){
            $this->HandleError("Please Fill in The Fields You Wish to Change!");
            return false;
		}
        return true;
    }
	
	function chngPwdInDB($currentPwd, $newPwd){
		if(!$this->DBLogin()){
			$this->HandleDBError("Sorry No Connection To The Database");
			return false;
		}
		
        $currentPwd = $this->SanitizeForSQL($currentPwd);
        $pwd        = $this->SanitizeForSQL($newPwd);
        
        $qry = "UPDATE $this->database.$this->tablename SET U_pwd='" . md5($pwd) . "' WHERE U_pwd= '" . md5($currentPwd) . "';";
        
        if(!mysql_query($qry, $this->connection)){
            $this->HandleDBError("Error updating the password\n: $qry");
            return false;
        }
		
		echo "Success!";
        return true;
    }
	
	//Updates the user email address, gets the old password 
	// by the session that was created when logged in.
	function chngEmailInDB(&$formvars){
		if(!$this->DBLogin()){
			$this->HandleDBError("Sorry No Connection To The Database");
			return false;
		}
		
		$newEmail = $this->SanitizeForSQL($formvars['newEmail']);
        $oldEmail = $this->SanitizeForSQL($this->UserEmail());
		
        $qry = "UPDATE $this->database.$this->tablename SET U_email = '" . $newEmail . "' WHERE U_email= '" . $oldEmail . "';";
        
        if(!mysql_query($qry, $this->connection)){
            $this->HandleDBError("Error Updating The Email\n: $qry");
            return false;
        }     
        return true;
	}
	/*------------------------Database Manager ends------------------------*/
	
	
	/*------------------------Error Handlers------------------------*/
	function HandleError($err){
        $this->error_message .= $err."\r\n";
    }
    
    function HandleDBError($err){
        $this->HandleError($err . "\r\n mysqlerror: " . mysql_error());
    }
	
	function GetErrorMessage(){
        if(empty($this->error_message)){
            return '';
        }
        $errormsg = nl2br(htmlentities($this->error_message));
        return $errormsg;
    }
	/*------------------------Error Handlers ends------------------------*/
	
	
	/*------------------------Mail Methods------------------------*/
	function EmailResetPasswordLink(){
        if(empty($_POST['email'])){
            $this->HandleError("Email is empty!");
            return false;
        }
		
        $user_rec = array();
		
        if(false === $this->GetUserFromEmail($_POST['email'], $user_rec)){
            return false;
        }
		
        if(false === $this->SendResetPasswordLink($user_rec)){
            return false;
        }
		
        return true;
    }
	
	function sendConfimMail(&$formvars){
		$mail = new PHPMailer();
		
		$name = $formvars['U_first'] . " " . $formvars['U_last'];
		$toAddress = $formvars['U_email'];
		
		$mail->IsSMTP();
		$mail->CharSet    = 'utf-8';
		$mail->Host       = 'smtp.gmail.com'; // SMTP server example
		$mail->SMTPAuth   = true;             // enable SMTP authentication
		$mail->SMTPSecure = 'ssl';
		$mail->Port       = 465;              // set the SMTP port for the GMAIL server
		$mail->Encoding   = '7bit';
		
		$mail->Subject = "Do not reply to this email";
		
		$mail->Username   = "ecorra37@gmail.com"; // SMTP account username example  WHERE YOURE SENDING FROM
		$mail->Password   = "sk8low1432";         // SMTP account password example
		
		$mail->Body = "Hello ".$formvars['name']."\r\n\r\n".
					"Thanks for your registration with " . $this->sitename . "\r\n".
					"Please click the link below to confirm your registration.\r\n".
					"Regards,\r\n".
					"Webmaster\r\n".
					$this->sitename;  //simple message only  you can add headers and other stuff
		
		//$mail->MsgHTML($message);
		//$mail->AddAddress("ecorral2@miners.utep.edu", "test");  //WHERE YOURE SENDING TO 
		
		$mail->AddAddress($toAddress, $name);
		
		if(!$mail->Send()) {
			echo 'Message could not be sent.<br>';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
			return false;
			exit;
		}
		return true;
	}
	
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
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($formvars['email'],$formvars['name']);
        
        $mailer->Subject = "Your registration with ".$this->sitename;

        $mailer->From = $this->GetFromAddress();        
        
        $confirmcode = $formvars['confirmcode'];
        
        $confirm_url = $this->GetAbsoluteURLFolder().'/confirmreg.php?code='.$confirmcode;
        
        $mailer->Body ="Hello ".$formvars['name']."\r\n\r\n".
        "Thanks for your registration with ".$this->sitename."\r\n".
        "Please click the link below to confirm your registration.\r\n".
        "$confirm_url\r\n".
        "\r\n".
        "Regards,\r\n".
        "Webmaster\r\n".
        $this->sitename;

        if(!$mailer->Send()){
            $this->HandleError("Failed sending registration confirmation email.");
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
	
	function SendResetPasswordLink($user_rec){
		$mail = new PHPMailer();
		
		$email = $user_rec['U_email'];
        $pwd   = $user_rec['U_pwd'];
		
		$name = $user_rec['U_first'] . " " . $user_rec['U_last'];
		$toAddress = $user_rec['U_email'];
		
		$mail->IsSMTP();
		$mail->CharSet    = 'utf-8';
		$mail->Host       = 'smtp.gmail.com'; // SMTP server example
		$mail->SMTPAuth   = true;             // enable SMTP authentication
		$mail->SMTPSecure = 'ssl';
		$mail->Port       = 465;              // set the SMTP port for the GMAIL server
		$mail->Encoding   = '7bit';
		
		$mail->Username   = "ecorra37@gmail.com"; // SMTP account username example  WHERE YOURE SENDING FROM
		$mail->Password   = "sk8low1432";         // SMTP account password example
		
		$mail->Subject = "Your reset password request at " . $this->sitename;
		
		//$link = $this->GetAbsoluteURLFolder().'/resetpwd.php?email=' . urlencode($email) . '&code='.urlencode($this->GetResetPasswordCode($email));
		
		$mail->Body = "Hello " . $name . "\r\n\r\n".
					"There was a request to reset your password at " . $this->sitename . "\r\n".
					"Your password is: " . $pwd . "\r\n".
					"Regards,\r\n".
					"Webmaster\r\n".
					$this->sitename;  //simple message only  you can add headers and other stuff
		
		//$mail->MsgHTML($message);
		//$mail->AddAddress("ecorral2@miners.utep.edu", "test");  //WHERE YOURE SENDING TO 
		
		$mail->AddAddress($toAddress, $name);
		
		if(!$mail->Send()) {
			echo 'Message could not be sent.<br>';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
			return false;
			exit;
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
	/*------------------------Mail Methods ends------------------------*/
}
?>