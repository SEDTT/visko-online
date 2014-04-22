<?php

require_once __DIR__ . '/../ErrorManager.php';
require_once __DIR__ . '/../../history/QueryError.php';


$em = new ErrorManager();

$e = new MalformedURIError(1, 1, 'snakes.com');


$em->insertError($e);

echo $em->countErrors('MalformedURIError');
