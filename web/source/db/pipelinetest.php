<?php
	require_once __DIR__ . '/../viskoapi/JsonTransformer.php';
	require_once 'PipelineManager.php';
	require_once __DIR__ . '/../Pipeline.php';
	require_once __DIR__ . '/../viskoapi/ViskoPipelineSet.php';
	require_once __DIR__ . '/../PipelineStatus.php';
	
	$jt = new JsonTransformer();

	//Pipeline/PipelineManager testing code 
	$pipelineManager = new PipelineManager();

	$pipes = new ViskoPipelineSet();
	$pipes->fromJson($jt->decode(file_get_contents(
		'../viskoapi/serialized_pipelineset.json')));

	$vp = $pipes->getPipelines()[0];

	var_dump($vp);
	echo '<br><br>';
	//pipeline with query # 1, no id
	$p = new Pipeline(1, 
		$vp->getViewURI(),
		$vp->getViewerURI(),
		$vp->getToolkitThatGeneratesView(),
		$vp->getRequiresInputURL(),
		$vp->getOutputFormat(),
		$vp->getServices(),
		$vp->getViewerSets()
	);
	
	$pid = $pipelineManager->insertPipeline($p);	

	//var_dump($p);

	$pipe = $pipelineManager->getPipelineByID($pid);
	var_dump($pipe);

		
