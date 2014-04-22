<?php
	require_once __DIR__ . '/../QueryManager.php';
	require_once __DIR__ . '/../../viskoapi/ViskoQuery.php';
	require_once __DIR__ . '/../../Query.php';
	require_once __DIR__ . '/../../viskoapi/JsonTransformer.php';
	
	$jt = new JsonTransformer();


	/* Query/QueryManager testing code */
	$queryManager = new QueryManager();
	
	$viskoQuery = new ViskoQuery();
	$viskoQuery->fromJson($jt->decode(
	file_get_contents('../../viskoapi/serialized_query.json')
		));
	
	/*public function __construct($userID, $queryText, $targetFormatURI = null, 
			$targetTypeURI = null, $viewURI = null, $viewerSetURI = null, 
			$artifactURL = null, $parameterBindings = null, $dateSubmitted = null, 	
			$id = null
	*/
	$query = new Query(1, 
		$viskoQuery->getQueryText(),
		$viskoQuery->getTargetFormatURI(),
		$viskoQuery->getTargetTypeURI(),
		$viskoQuery->getViewURI(),
		$viskoQuery->getViewerSetURI(),
		$viskoQuery->getArtifactURL(),
		$viskoQuery->getParameterBindings()
	);
	
	$qid = $queryManager->insertQuery($query);
	
	$newQuery = $queryManager->getQueryById($qid);
	
	var_dump($newQuery);
	
