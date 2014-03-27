<?PHP
	require_once 'Manager.php';
	class UserManager extends Manager{

		public function updateEmailFromID($id, $email){
			$conn = $this->getConnection();
			
			if(!($stmt = $conn->prepare(
				"UPDATE User SET
					U_email = ?
				WHERE U_id = ?"
				))){
				$this->handlePrepareError($conn);
			}else{
				$stmt->bind_param('si', $email, $id);
				$stmt->execute();
			}
		}
	}	
