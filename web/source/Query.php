<?PHP
	require_once 'viskoapi/ViskoQuery.php';

	class Query{
		protected $id;
		protected $userID;
		protected $viskoQuery;
		protected $dateSubmitted; //TODO what type is this?

		public function __construct($userID, $viskoQuery, $dateSubmitted){
			$this->userID = $userID;
			$this->viskoQuery = $viskoQuery;
			$this->dateSubmitted = $dateSubmitted;
		}

		public function setID($id){
			$this->id = $id;
		}

		public function getViskoQuery(){
			return $this->viskoQuery;
		}

		public function getQueryID(){
			return $this->id;
		}

		public function getUserID(){
			return $this->userID;
		}

		public function getDateSubmitted(){
			return $this->dateSubmitted();
		}
	}
?>
