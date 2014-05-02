<?PHP
require_once 'Manager.php';
require_once __DIR__ . '/../User.php';

class UserManager extends Manager{

	/**
	* @return User user object with given email.
	*/
	public function getUserByEmail($email){
		$conn = $this->getConnection();
		
		if(!($stmt = $conn->prepare(
			"SELECT U_id FROM `User`
			WHERE U_email = ?"
			))){
			$this->handlePrepareError($conn);
		}else{
			$stmt->bind_param('s', $email);
			
			if(!$stmt->execute()){
				$this->handleExecuteError($conn);
			}

			$stmt->bind_result($uid);

			while($stmt->fetch()){
				;
			}
			
			$stmt->close();
			return new User($uid);
		}
	}
}	
