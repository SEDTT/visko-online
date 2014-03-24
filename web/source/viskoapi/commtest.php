<?php
require_once 'ViskoPipelineSet.php';
require_once 'ViskoQuery.php';
require_once 'ViskoVisualizer.php';
require_once 'ViskoPipelineStatus.php';

$vq = new ViskoQuery('fake');

$jt = new JsonTransformer();
$vq->fromJson($jt->decode(file_get_contents('serialized_query.json')));

$vv = new ViskoVisualizer();
list($pipes, $errors) = $vv->generatePipelines($vq);

//var_dump($pipes);

$pipe = $pipes->getPipelines()[1];


list($pipeStatus, $errors) = $vv->executePipeline(time() % 100000, $pipes->getQuery(), $pipe);

var_dump($errors);
var_dump($pipeStatus);

?>
