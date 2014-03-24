package dtt.visualization.responses;

import edu.utep.trustlab.visko.execution.PipelineExecutorJob;
import edu.utep.trustlab.visko.execution.PipelineExecutorJobStatus;

/**
 * Class to store some useful state about an executing PipelineExecutorJob.
 * 
 * Relies on implicit gson serialization to turn it into json.
 * @author awknaust
 *
 */
@SuppressWarnings("unused") 
class PipelineStatus{
	
	private String type;
	private int id;
	
	private boolean completedNormally = false;
	private String resultURL = null;
	private int serviceIndex = 0;
	private String serviceURI = null;
	private PipelineExecutorJobStatus.PipelineState pipelineState;
	private String stateMessage = null;
	
	public PipelineStatus(int id, PipelineExecutorJob job){
		this.type = this.getClass().getSimpleName();
		this.id = id;
		
		this.completedNormally = job.getJobStatus().didJobCompletedNormally();
		this.resultURL = job.getFinalResultURL();
		this.serviceIndex = job.getJobStatus().getCurrentServiceIndex();
		this.serviceURI = job.getJobStatus().getCurrentServiceURI();
		this.pipelineState = job.getJobStatus().getPipelineState();
		this.stateMessage = job.getJobStatus().toString();
	}
}