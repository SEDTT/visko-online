package dtt.visualization.errors;

/**
 * Error getting a pipeline's status.
 * @author awknaust
 *
 */
public class PipelineStatusError extends VisualizationError {

	protected String pipelineJobID;
	public PipelineStatusError(String id, String msg){
		super("(" + id + ")" + " : " + msg);
		this.pipelineJobID = id;
	}
}
