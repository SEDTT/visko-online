package dtt.visualization.errors;

/**
 * Thrown if a pipeline or service times out during execution.
 * 
 * @author awknaust
 * 
 */
public class PipelineExecutionTimeoutError extends PipelineExecutionError {

	private int serviceIdx;
	private long time;

	public PipelineExecutionTimeoutError(int serviceIdx, long time) {
		super("Pipeline execution timed out " + "while executing service #"
				+ serviceIdx);
		this.serviceIdx = serviceIdx;
		this.time = time;
	}
}
