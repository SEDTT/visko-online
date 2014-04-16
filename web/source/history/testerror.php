<?php
require_once 'PipelineError.php';

$s = new ServiceExecutionError(0, 1, 2, 'http://imgur.com');

echo $s;