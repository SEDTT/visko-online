<?PHP
	require_once 'viskoapi/ViskoQuery.php';

	class Query{
		protected $id;
		protected $userID;
		protected $viskoQuery;
		protected $dateSubmitted; //TODO what type is this?

		public function __construct($userID, $viskoQuery, 
			$dateSubmitted = null, $id = null){
			$this->userID = $userID;
			$this->viskoQuery = $viskoQuery;
			$this->dateSubmitted = $dateSubmitted;
			$this->id = $id;
		}

		public function setID($id){
			$this->id = $id;
		}

		public function getViskoQuery(){
			return $this->viskoQuery;
		}

		public function getID(){
			return $this->id;
		}
		
		/* Alias for now (where is this used?) */
		public function getQueryID(){
			return $this->getID();
		}

		public function getUserID(){
			return $this->userID;
		}

		public function getDateSubmitted(){
			return $this->dateSubmitted();
		}
	}
?>
