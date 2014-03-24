<?php

/**
 * A dummy driver for getting pipeline data.
 */
require_once 'ViskoPipelineSet.php';
require_once 'ViskoQuery.php';
require_once 'JsonTransformer.php';

$pset =  new ViskoPipelineSet;
//echo file_get_contents('serialized_pipelineset.json');

$jt = new JsonTransformer();
$pset->fromJson($jt->decode(file_get_contents('serialized_pipelineset.json')));
$pipelines = $pset->getPipelines();

echo "I have ". count($pipelines) . " Pipelines <br>";

$count = 1;

foreach($pipelines as $pipe){
	echo "<br>Pipeline ". $count . " <br>";
	echo "ViewURI ". $pipe->getViewURI() . "<br>";
	echo "ViewerURI ". $pipe->getViewerURI(). "<br>";
	echo "OutputFormat ". parse_url($pipe->getOutputFormat(), PHP_URL_FRAGMENT). "<br>";
	echo "toolkitThatGeneratesView ". parse_url($pipe->getToolkitThatGeneratesView(), PHP_URL_FRAGMENT) . "<br>";
	$count = $count + 1;
}

echo "<br>";
echo "<br>";
$groups = $pset->groupPipelinesByToolkit();
foreach($groups as $toolkit => $pipelines){
	echo $toolkit . " (" . count($pipelines). ") <br>";
}

$vq = new ViskoQuery("SELECT * FROM BANAS WHERE 3 = 4");
echo $vq->toJson();

?>
