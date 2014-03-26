<?PHP

	class Query{
		protected $id;
		protected $uID;
		protected $viskoQuery;

		public function getViskoQuery(){
			return $this->viskoQuery;
		}

		public function getQueryID(){
			return $this->id;
		}
	}
?>