<?PHP
	
	class PipelineManager extends DBManager{

		/**
		* Returns the ID of the pipeline after the insert has occured.
		*/
		public function InsertPipeline($pipeline, $query){

			// Validate login information is legit. Uses inherited DBLogin function from DBManager.
			if(!$this->DBLogin()){
            $this->HandleError("Database login failed!");
        }
            

            $viskoPipeline = $pipeline->getViskoPipeline(); // Retrieve ViskoPipeline object from 


            // Insert query into Pipeline table
         	$insert_query = 'INSERT INTO Pipeline (queryID, viewURI, viewerURI, toolkit, outputFormat, requiresInputURL)
                values(
                "' . SanitizeForSQL($query->getQueryID()). '",
                "' . SanitizeForSQL($viskoPipeline->getViewURI()) . '",
                "' . SanitizeForSQL($viskoPipeline->getViewerURI()) . '",
                "' . SanitizeForSQL($viskoPipeline->getToolkitThatGeneratesView()) . '",
                "' . SanitizeForSQL($viskoPipeline->getOutputFormat()) . '",
                "' . SanitizeForSQL($viskoPipeline->getRequiresInputURL()) . '"
                );';

			$query = 'SELECT LAST_INSERT_ID() as newid;'; 
			$result = mysql_query($insert_query.$query);
			$row = mysql_fetch_assoc($result);
			$pipelineID = row['newid']; // Get the id of the pipeline we just inserted.



			$services = $viskoPipeline->getServices(); // get list of services that compose the pipeline

			// Adding into PipelinexService Table
			for($position = 0; $position < count($services); $position++){

				$URI = $service[$position]; //
				$serviceID = 'SELECT id FROM Services WHERE URI ='.$URI.';'; // Obtain the id for the service
				
				
				$insert_pipelinexService = 'INSERT INTO PipelinexService (pipelineID,serviceID,position) values(
					"' .SanitizeForSQL($pipelineID). '",
					"' .SanitizeForSQL($serviceID). '",
					"' .SanitizeForSQL($position). '"
					);';

				mysql_query($insert_pipelinexService);
			}	

			// Adding into PipelinexViewerSet
			$viewerSets = $viskoPipline->getViewerSets();


			for($position = 0; $position < count($viewerSets); $position++){
				$URI = $viewerSets[$position];
				$viewerSetID = 'SELECT id FROM ViewerSets WHERE URI ='.$URI.';';

				$insert_pipelinexViewerSet = 'INSERT INTO PipelinexViewerSet (pipelineID,viewerSetID) VALUES(
					"' .SanitizeForSQL($pipelineID). '",
					"' .SanitizeForSQL($viewerSetID). '"
					);';
				
				mysql_query($insert_pipelinexViewerSet);
			}

			return $pipelineID;
		}

		/**
		*
		*/
		public Pipeline getPipeLineByID($id){

		}

		/**
		*
		*/
		public PipelineStatus getPipelineStatus($pipeline){

		}
	}
?>