<?php
require_once 'ViskoPipelineSet.php';
require_once 'ViskoQuery.php';

$vq = new ViskoQuery('fake');

$jt = new JsonTransformer;

$vq->fromJson($jt->decode(file_get_contents('serialized_query.json')));

$url = 'http://localhost:8080/viskobackend/query';
$params = array('query' => $vq->toJson()); 

$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\n",
        'method'  => 'POST',
        'content' => http_build_query($params),
    ),
);

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

$ps = new ViskoPipelineSet;

$jobj = $jt->decode($result);
$ps->fromJson($jobj->pipelines);
var_dump($ps->getPipelines());
//var_dump($result);
