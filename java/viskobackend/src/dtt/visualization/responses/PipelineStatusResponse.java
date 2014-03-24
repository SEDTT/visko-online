package dtt.visualization.responses;

import java.util.ArrayList;
import java.util.List;

import edu.utep.trustlab.visko.execution.PipelineExecutorJob;
import edu.utep.trustlab.visko.execution.PipelineExecutorJobStatus;

/**
 * Relies on implicit Gson serialization for communication.
 * @author awknaust
 *
 */
public class PipelineStatusResponse extends VisualizationResponse {

	private List<PipelineStatus> statuses;
	
	public PipelineStatusResponse(){
		super();
		this.statuses = new ArrayList<PipelineStatus>();
	}
	
	public void addStatus(int id, PipelineExecutorJob job){
		this.statuses.add(new PipelineStatus(id, job));
	}
	
	/**
	 * Class to store some useful state about an executing PipelineExecutorJob.
	 * 
	 * Relies on implicit gson serialization to turn it into json.
	 * @author awknaust
	 *
	 */
	@SuppressWarnings("unused")
	private class PipelineStatus{
		
		private String type;
		private int id;
		
		private boolean completedNormally = false;
		private String resultURL = null;
		private int currentServiceIndex = 0;
		private String currentServiceURI = null;
		private PipelineExecutorJobStatus.PipelineState pipelineState;
		private String stateMessage = null;
		
		public PipelineStatus(int id, PipelineExecutorJob job){
			this.type = this.getClass().getSimpleName();
			this.id = id;
			
			this.completedNormally = job.getJobStatus().didJobCompletedNormally();
			this.resultURL = job.getFinalResultURL();
			this.currentServiceIndex = job.getJobStatus().getCurrentServiceIndex();
			this.currentServiceURI = job.getJobStatus().getCurrentServiceURI();
			this.pipelineState = job.getJobStatus().getPipelineState();
			this.stateMessage = job.getJobStatus().toString();
		}
	}
}
