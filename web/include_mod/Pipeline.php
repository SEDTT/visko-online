<?PHP

	class Pipeline{
		protected $id;
		protected $queryID;
		protected $viskoPipeline;

		public function getViskoPipeline(){
			return $this->viskoPipeline;
		}

		public function getPipelineID(){
			return $this->id;
		}

		public function getQueryID(){
			return $this->queryID;
		}
	}
?>