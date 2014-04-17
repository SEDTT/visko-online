<?php
	require_once 'PipelineManager.php';
	require_once __DIR__ . '/../PipelineStatus.php';
	require_once __DIR__ . '/../Pipeline.php';
	
	//Pipeline/PipelineManager testing code 
	$pipelineManager = new PipelineManager();

	$p = new Pipeline(1);
	$p->setID(1);
	
	var_dump($p);
	//pipelinestatus for pipeline #1 (hopefully it exists)
	$ps = new PipelineStatus(1, 
		true,
		'www.imgur.com',
		0
	);
	
	$psid = $pipelineManager->insertPipelineStatus($ps);	


	$pipeStatus = $pipelineManager->getPipelineStatusForPipeline($p);
	var_dump($pipeStatus);

?>
