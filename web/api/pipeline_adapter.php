<?php 
echo "Hello World"

class PipelineSet{

	function fromJSON(json){
		$result = json_decode(json);
		echo var_dump($result);
	}
}


$pset =  new PipelineSet;
echo file_get_contents('serialized_pipeline.json');

pset->fromJSON(file_get_contents('serialized_pipeline.json'));
?>
