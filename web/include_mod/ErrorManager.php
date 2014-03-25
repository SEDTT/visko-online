<?PHP
class ErrorManager{

	var $error_message;

	function GetErrorMessage(){
        if(empty($this->error_message)){
            return '';
        }
        $errormsg = nl2br(htmlentities($this->error_message));
        return $errormsg;
    }

    function HandleError($err){
        $this->error_message .= $err."\r\n";
    }
	
	function HandleDBError($err){
        $this->HandleError($err . "\r\n mysqlerror:" . mysql_error());
    }
}
?>