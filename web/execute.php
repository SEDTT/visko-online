<?php
require_once 'source/db/QueryManager.php';
require_once 'source/db/PipelineManager.php';
require_once 'source/db/ErrorManager.php';
require_once 'source/Pipeline.php';

/**
* Execute a pipeline and do database things.
* 
* @param int $pid id of pipeline to execute (already in DB)
*/

/** Execute a pipeline that is already stored in the database.
* @param int $pid the id of the pipeline to execute
*/
function executePipeline($pid){
	assert ($pid > 0 );
	$pm = new PipelineManager();
	$qm = new QueryManager();

	try{
		$pipeline = $pm->getPipelineByID($pid);
		$generatingQuery = $qm->getQueryByID($pipeline->getQueryID());
		
		$status = $pipeline->execute($generatingQuery);
		return $status;
	}catch(Error $ee1){
		$em = new ErrorManager();
		$em->insertError($ee1);
		throw $ee1;
	}catch(ManagerException $me1){
		throw $me1;
	}
}

//get an id from the query URL and then do a thing
if (isset($_GET['id'])){
	try{
		$ps = executePipeline($_GET['id']);
		echo $ps->getResultURL();
	}catch(Exception $e){
		echo $e->getMessage();
	}
}

?>

