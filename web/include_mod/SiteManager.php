<?PHP
class SiteManager{
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
        return 'sp' . md5('KHGdnbvsgst' . $this->rand_key);
    }
	
	//newly added function
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
	
	function GetAbsoluteURLFolder(){
        $scriptFolder = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
        $scriptFolder .= $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
        return $scriptFolder;
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
	
	/*
    Sanitize() function removes any potential threat from the
    data submitted. Prevents email injections or any other hacker attempts.
    if $remove_nl is true, newline chracters are removed from the input.
    */
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
}
?>