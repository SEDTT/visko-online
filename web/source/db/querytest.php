<?php
	require_once 'QueryManager.php';
	require_once __DIR__ . '/../viskoapi/ViskoQuery.php';
	require_once __DIR__ . '/../Query.php';
	require_once __DIR__ . '/../viskoapi/JsonTransformer.php';
	require_once 'PipelineManager.php';
	require_once __DIR__ . '/../Pipeline.php';
	require_once __DIR__ . '/../viskoapi/ViskoPipelineSet.php';
	require_once __DIR__ . '/../PipelineStatus.php';
	
	$jt = new JsonTransformer();

	/* Pipeline/PipelineManager testing code 
	$pipelineManager = new PipelineManager();

	$pipes = new ViskoPipelineSet();
	$pipes->fromJson($jt->decode(file_get_contents(
		'../viskoapi/serialized_pipelineset.json')));

	$vp = $pipes->getPipelines()[0];

	//pipeline with query # 1, no id
	$p = new Pipeline(1, $vp);
	
	$pid = $pipelineManager->insertPipeline($p, 1);	

	//var_dump($p);

	$pipe = $pipelineManager->getPipelineByID($pid);
	var_dump($pipe);

	*/
	/* Query/QueryManager testing code */
	$queryManager = new QueryManager();
	
	$viskoQuery = new ViskoQuery();
	$viskoQuery->fromJson($jt->decode(
	file_get_contents('../viskoapi/serialized_query.json')
		));
	
	
	$query = new Query(1, $viskoQuery);
	
	$qid = $queryManager->insertQuery($query);
	
	$query->getViskoQuery()->setTargetTypeURI('hello');

	$queryManager->updateQuery($query);
	
	$newQuery = $queryManager->getQueryById($qid);
	
	var_dump($newQuery);
	
