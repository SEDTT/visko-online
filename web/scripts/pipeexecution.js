/** I don't know how to JS but this is stuff for executing pipelines! 
* 
* @see forwardstatus.php
* @see execute.php
* @author awknaust
*/

/* This might in the future update the image */
function executionComplete(data, textStatus, jqXHR){
	alert(data);
}

function startExecution(pipelineID){
	//use jQuery to tell visko to start execution.
	$.get('execute.php',
		{'id' : pipelineID },
		executionComplete
	);
}

/** Called when user clicks an execute button on a pipeline
* Start pipeline execution and grey out button
**/
function runClicked(pipelineID){
	startExecution(pipelineID);
	document.getElementById("runPipe" + pipelineID).disabled = true;
	return false;
}


