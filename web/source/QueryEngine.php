<?php
require_once 'Query.php';
require_once 'db/QueryManager.php';
require_once 'db/PipelineManager.php';
require_once 'db/ErrorManager.php';
require_once 'history/QueryError.php';

/**
 * Generates Pipelines from a Query, committing all objects to the database.
 * Essentially this is a wrapper for Query#submit that catches any errors, or results
 * and stores them in the database before passing them on.
 * 
 * @see Query#submit @pre query->getID() == null
 *      @pre query->getUserID() != null
 *     
 * @throws ManagerException (programmer error with database likely)
 * @throws BackendConnectException (cannot talk to viskobackend (java))
 * @throws QueryError if there is a problem with the query.
 *        
 * @return array(Pipeline)
 *
 */
function generatePipelines($query) {
	assert ( $query->getUserID () > 0 );
	assert ( $query->getID () == null );
	
	$qm = new QueryManager ();
	
	try {
		// insert query and set its id.
		$qm->insertQuery ( $query );
		
		// submit
		$pipes = $query->submit ();
		
		// put each pipeline into the database.
		$pm = new PipelineManager ();
		foreach ( $pipes as $pipe ) {
			$pm->insertPipeline ( $pipe );
		}
		// TODO can update query in database after receiving parsed one from viskobackend.
		$qm->updateQuery ( $query );
		return $pipes;
	} catch ( QueryError $qe ) {
		// catch, tag, release!!!!!!!!!!
		$em = new ErrorManager ();
		$em->insertError ( $qe );
		throw $qe;
	} catch ( Exception $e ) {
		throw $e;
	}
}
