package dtt.visualization.responses;

import edu.utep.trustlab.visko.execution.PipelineExecutorJobStatus;


public class PipelineExecutionResponse extends VisualizationResponse {

	private boolean completedNormally = false;
	private String resultURL = null;
	private int lastService = 0;
	private PipelineExecutorJobStatus.PipelineState lastPipelineState;
	private String stateMessage = null;
	
	
	public boolean isCompletedNormally() {
		return completedNormally;
	}
	public void setCompletedNormally(boolean completedNormally) {
		this.completedNormally = completedNormally;
	}
	public String getResultURL() {
		return resultURL;
	}
	public void setResultURL(String resultURL) {
		this.resultURL = resultURL;
	}
	public int getLastService() {
		return lastService;
	}
	public void setLastService(int lastService) {
		this.lastService = lastService;
	}
	public PipelineExecutorJobStatus.PipelineState getLastPipelineState() {
		return lastPipelineState;
	}
	public void setLastPipelineState(
			PipelineExecutorJobStatus.PipelineState pipelineState) {
		this.lastPipelineState = pipelineState;
	}
	public String getStateMessage() {
		return stateMessage;
	}
	public void setStateMessage(String stateMessage) {
		this.stateMessage = stateMessage;
	}

}
