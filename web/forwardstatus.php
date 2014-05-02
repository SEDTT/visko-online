<?php
require_once 'source/viskoapi/ViskoVisualizer.php';

//hack thing.
function getStatus($id){
	$vv = new ViskoVisualizer();
	return $vv->pollPipelineStatus($id);
}

if(isset($_GET['id'])){
	echo getStatus($_GET['id']);
}

?>
