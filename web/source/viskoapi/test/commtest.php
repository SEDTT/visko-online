<?php
require_once __DIR__ . '/../ViskoPipelineSet.php';
require_once __DIR__ . '/../ViskoQuery.php';
require_once __DIR__ . '/../ViskoVisualizer.php';
require_once __DIR__ . '/../ViskoPipelineStatus.php';

$vq = new ViskoQuery('fake');

$jt = new JsonTransformer();
$vq->fromJson($jt->decode(file_get_contents('serialized_query.json')));

$vv = new ViskoVisualizer();
list($pipes, $errors) = $vv->generatePipelines($vq);


//var_dump($pipes);

$pipe = $pipes->getPipelines()[0];


list($pipeStatus, $errors) = $vv->executePipeline(time() % 100000, $pipes->getQuery(), $pipe);

var_dump($errors);
var_dump($pipeStatus);

?>
