<?php
require_once 'PipelineError.php';
require_once 'QueryError.php';

$s = new ServiceExecutionError(0, 1, 2, 'http://imgur.com');

$s1 = new NoPipelineResultsError(0, 1); 

$s2 = new MalformedURIError(0, 1, 'snakes.com');

$errs = array($s, $s1, $s2);

foreach ($errs as $err){
	echo $err . '<br>';
}
