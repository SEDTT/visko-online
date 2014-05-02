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

function updateExecutionTable(pipelineID, pipeStatus, pending){
	var rowName = "pipeExecRow" + pipelineID;
	var table = document.getElementById("pipeExecTable");

	var row;
	var idCell;
	var statusCell;
	var buttonCell;

	if(document.getElementById(rowName)){
		//update existing row
		row = document.getElementById(rowName);
		idCell = row.cells[0];
		statusCell = row.cells[1];
		buttonCell = row.cells[2];
	}
	else{ //add new row to table
		row = table.insertRow(-1);
		row.id = rowName;
		idCell = row.insertCell(0);
		statusCell = row.insertCell(1);
		buttonCell = row.insertCell(2);
	}

	idCell.innerHTML = pipelineID;
	buttonCell.innerHTML = 'hello';
	
	if(pending){
		statusCell.innerHTML = 'Sending...';
	}
	else if(pipeStatus.pipelineState == 'RUNNING'){
		statusCell.innerHTML = 'Running Service #' + pipeStatus.serviceIndex;
	}else if(pipeStatus.pipelineState == 'COMPLETE'){
		statusCell.innerHTML = '';
		var visImg = document.createElement("img");
		visImg.src = pipeStatus.resultURL;
		visImg.width = 150;
		statusCell.appendChild(visImg);
	}
}

function pollStatus(pipelineID){
	$.getJSON('forwardstatus.php', {'id' : pipelineID}, 
		function(data, textStatus, jqXHR){
		
			if(data.errors.length > 0){
				//errors almost always mean we are asking too soon
				setTimeout(function (){ pollStatus(pipelineID);}, 100);
				updateExecutionTable(pipelineID, null, true);
			}else{
				var firstStatus = data.statuses[0];
	
				updateExecutionTable(pipelineID, firstStatus, false);

				//continue to poll if pipeline is still running
				if(((firstStatus.pipelineState == 'NEW') ||
					firstStatus.pipelineState == 'RUNNING')){
					setTimeout(function (){ pollStatus(pipelineID);}, 100);
				}
			}
		}
	);
	return false;
}

function startExecution(pipelineID){
	//use jQuery to tell visko to start execution.
	$.get('execute.php',
		{'id' : pipelineID },
		executionComplete
	);
	pollStatus(pipelineID);
}

/** Called when user clicks an execute button on a pipeline
* Start pipeline execution and grey out button
**/
function runClicked(pipelineID){
	startExecution(pipelineID);
	document.getElementById("runPipe" + pipelineID).disabled = true;
	return false;
}


