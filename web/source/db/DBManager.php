<?PHP
class DBManager{
	var $admin_email;
    var $from_address;
    
    var $username;
    var $pwd;
    var $database;
    var $tablename;
    var $connection;

	function InitDB($host, $uname, $pwd, $database, $tablename){
        $this->db_host   = $host;
        $this->username  = $uname;
        $this->pwd       = $pwd;
        $this->database  = $database;
        $this->tablename = $tablename;
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
         
         if(empty($_SESSION[$sessionvar]))
         {
            return false;
         }
         return true;
    }
	
	function LogOut(){
        session_start();
        
        $sessionvar = $this->GetLoginSessionVar();
        
        $_SESSION[$sessionvar]=NULL;
        
        unset($_SESSION[$sessionvar]);
    }
	
	//used for the VisKo project
	// If need to use, just invoke the method
    function DBLogin(){

        $this->connection = mysql_connect($this->db_host, $this->username, $this->pwd);

        if(!$this->connection){   
            $this->HandleDBError("Database Login failed! Please make sure that the DB login credentials provided are correct");
            return false;
        }
		
        if(!mysql_select_db($this->database, $this->connection)){
            $this->HandleDBError('Failed to select database: ' . $this->database . ' Please make sure that the database name provided is correct');
            return false;
        }
		
        if(!mysql_query("SET NAMES 'UTF8'", $this->connection)){
            $this->HandleDBError('Error setting utf8 encoding');
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
        $qry = "SELECT U_first, U_last, U_email, U_pwd FROM $this->tablename WHERE U_email='$email' and U_pwd='$pwdmd5'";
        
        $result = mysql_query($qry, $this->connection);
        
        if(!$result || mysql_num_rows($result) <= 0){
            $this->HandleError("Error logging in. The username or password does not match");
            return false;
        }
        
        $row = mysql_fetch_assoc($result);
        
        
        $_SESSION['name_of_user']  = $row['U_first'].' '.$row['U_last'];
        $_SESSION['email_of_user'] = $row['U_email'];
        
        return true;
    }
	
	function ResetUserPasswordInDB($user_rec){
        $new_password = substr(md5(uniqid()),0,10);
        
        if(false == $this->ChangePasswordInDB($user_rec,$new_password)){
            return false;
        }
        return $new_password;
    }
    
    function ChangePasswordInDB($user_rec, $newpwd){
        $newpwd = $this->SanitizeForSQL($newpwd);
        
        $qry = "Update $this->tablename Set password='".md5($newpwd)."' Where  id_user=".$user_rec['id_user']."";
        
        if(!mysql_query( $qry ,$this->connection)){
            $this->HandleDBError("Error updating the password \nquery:$qry");
            return false;
        }     
        return true;
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
	
	//inserts into designated table and creates a confirmation code
    function InsertIntoUser(&$formvars){
    
        //$confirmcode = $this->MakeConfirmationMd5($formvars['email']);
        
        //$formvars['confirmcode'] = $confirmcode;
        
        $insert_query = 'INSERT INTO ' . $this->tablename.'(U_email, U_first, U_last, U_pwd, U_affiliation)
                values(
                "' . $this->SanitizeForSQL($formvars['U_email']) . '",
                "' . $this->SanitizeForSQL($formvars['U_first']) . '",
                "' . $this->SanitizeForSQL($formvars['U_last']) . '",
                "' . md5($formvars['U_pwd']) . '",
                "' . $this->SanitizeForSQL($formvars['U_affiliation']) . '"
                )';
				
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
        if(!$this->IsFieldUnique($formvars, 'email')){
            $this->HandleError("This email is already registered");
            return false;
        }
        
        /*if(!$this->IsFieldUnique($formvars, 'username')){
            $this->HandleError("This UserName is already used. Please try another username");
            return false;
        }*/
		
        if(!$this->InsertIntoUser($formvars)){
            $this->HandleError("Inserting to Database failed!");
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
	
	
}
?>