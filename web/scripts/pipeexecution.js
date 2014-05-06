/** I don't know how to JS but this is stuff for executing pipelines! 
* 
* @see forwardstatus.php
* @see execute.php
* @author awknaust
*/

/* This might in the future update the image */
function executionComplete(data, textStatus, jqXHR){
	//alert(data);
}

function createButtonNode(pipelineID){
	var button = document.createElement('button');
	button.innerHTML = 'Remove';
	button.onclick = function(){removeClicked(pipelineID);};
	button.type = 'button';
	
	return button;
}

function loadingStatus(){
	var loadingImg = document.createElement("img");
	loadingImg.src = "images/loading.gif";
	return loadingImg;
}

function updateExecutionTable(pipelineID, pipeStatus, error){
	var rowName = "pipeExecRow" + pipelineID;
	var table = document.getElementById("pipeExecTable");

	var row;
	var statusCell;

	if(document.getElementById(rowName)){
		//update existing row
		row = document.getElementById(rowName);
		statusCell = row.cells[1];
	}
	else{ //add new row to table
		row = table.insertRow(-1);
		row.id = rowName;
		var idCell = row.insertCell(0);
		idCell.class = 'execIDCell';
		statusCell = row.insertCell(1);
		statusCell.class = 'execStatusCell';
		var buttonCell = row.insertCell(2);
		buttonCell.class = 'execButtonCell';
		
		idCell.innerHTML = pipelineID;
		buttonCell.appendChild(createButtonNode(pipelineID));
	}

	
	
	if(pipeStatus == null){
		if (error.type == 'NotInTableError'){
			if(statusCell.firstChild)
				statusCell.firstChild = loadingStatus();
			else
				statusCell.appendChild(loadingStatus());
		}else{
			statusCell.innerHTML = error.type;
		}
	}
	else if(pipeStatus.pipelineState == 'RUNNING'){
		statusCell.innerHTML = 'Running Service #' + pipeStatus.serviceIndex;
	}else if(pipeStatus.pipelineState == 'COMPLETE'){
		statusCell.innerHTML = '';
		var visLink = document.createElement("a");
		var visImg = document.createElement("img");
		visImg.src = pipeStatus.resultURL;
		visLink.href = visImg.src;
		visImg.width = 150;
		visLink.appendChild(visImg);
		
		statusCell.appendChild(visLink);
		statusCell.appendChild(visImg);

		visImg.onclick = function(){
			  window.open("ViewResult.php?img="+visImg.src+"&id="+pipelineID);  
		};
	}
}


function pollStatus(pipelineID){
	$.getJSON('forwardstatus.php', {'id' : pipelineID}, 
		function(data, textStatus, jqXHR){
		
			console.log(data);
			
			if(data.errors.length > 0){
				var deadError = false;
				var j = 0;
				//look for InputDataURLError, etc. indicating the pipeline will never be run.
				for(var i = 0; i < data.errors.length; i++){
					var err = data.errors[i];
					if(err.type != 'NotInTableError'){
						j = i;
						deadError = true;
						break;
					}
				}
				
				//probably just too soon to be in table.
				if(!deadError){
					setTimeout(function (){ pollStatus(pipelineID);}, 100);
					updateExecutionTable(pipelineID, null, data.errors[0]);
				}else{
					updateExecutionTable(pipelineID, null, data.errors[j])
				}
			}else{
				var firstStatus = data.status;
	
				updateExecutionTable(pipelineID, firstStatus, null);

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

function removeClicked(pipelineID){
	var rowName = "pipeExecRow" + pipelineID;
	var row = document.getElementById(rowName);
	row.parentNode.removeChild(row);
	return false;
}


