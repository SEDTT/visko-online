package dtt.visualization.errors;

public class PipelineStatusError extends VisualizationError {

	protected String pipelineJobID;
	public PipelineStatusError(String id, String msg){
		super("(" + id + ")" + " : " + msg);
		this.pipelineJobID = id;
	}
}
