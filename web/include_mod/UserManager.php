<?PHP
require_once("class.phpmailer.php");
require_once("formvalidator.php");

class FGMembersite{
    var $admin_email;
    var $from_address;
    
    var $username;
    var $pwd;
    var $database;
    var $tablename;
    var $connection;
    var $rand_key;
    
    //-----Initialization -------
    function FGMembersite(){
        $this->sitename = 'YourWebsiteName.com';
        $this->rand_key = '0iQx5oBk66oVZep';
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
    
    //-------Main Operations ----------------------
    function RegisterUser(){
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
		
        
        /*if(!$this->SendUserConfirmationEmail($formvars)){
            return false;
        }*/

        //$this->SendAdminIntimationEmail($formvars);
        
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
    
    function UserFullName(){
        return isset($_SESSION['name_of_user']) ? $_SESSION['name_of_user'] : $_SESSION['email_of_user'];
    }
    
    function UserEmail(){
        return isset($_SESSION['email_of_user']) ? $_SESSION['email_of_user'] : '';
    }
    
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
    
    function ChangePassword(){
        if(!$this->CheckLogin()){
            $this->HandleError("Not logged in!");
            return false;
        }
        
        if(empty($_POST['oldpwd'])){
            $this->HandleError("Old password is empty!");
            return false;
        }
        if(empty($_POST['newpwd'])){
            $this->HandleError("New password is empty!");
            return false;
        }
        
        $user_rec = array();
        if(!$this->GetUserFromEmail($this->UserEmail(),$user_rec)){
            return false;
        }
        
        $pwd = trim($_POST['oldpwd']);
        
        if($user_rec['password'] != md5($pwd)){
            $this->HandleError("The old password does not match!");
            return false;
        }
        $newpwd = trim($_POST['newpwd']);
        
        if(!$this->ChangePasswordInDB($user_rec, $newpwd)){
            return false;
        }
        return true;
    }
    
    //-------Public Helper functions -------------
    function GetSelfScript(){
        return htmlentities($_SERVER['PHP_SELF']);
    }    
    
    //-------Private Helper functions-----------
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
    
	//used
    function GetUserFromEmail($email, &$user_rec){
        if(!$this->DBLogin()){
            $this->HandleError("Database login failed!");
            return false;
        }
		
        $email = $this->SanitizeForSQL($email);
        
        $result = mysql_query("SELECT * FROM $this->tablename where U_email = '$email'", $this->connection);  

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
	
    function CollectRegistrationSubmission(&$formvars){
        $formvars['U_email'] = $this->Sanitize($_POST['U_email']);
        $formvars['U_email_Con'] = $this->Sanitize($_POST['U_email_Con']);
        $formvars['U_pwd']   = $this->Sanitize($_POST['U_pwd']);
        $formvars['U_pwd_Con']   = $this->Sanitize($_POST['U_pwd_Con']);
        $formvars['U_first'] = $this->Sanitize($_POST['U_first']);
        $formvars['U_last']  = $this->Sanitize($_POST['U_last']);
    }  
}
?>