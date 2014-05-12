package dtt.visualization.errors;

/**
 * Created if a request for a pipeline status cannot be answered because the
 * table knows nothing about it.
 * 
 * @author awknaust
 * 
 */
public class NotInTableError extends PipelineStatusError {
	private int pipelineID;

	public NotInTableError(int id) {
		super(Integer.toString(id), " Has not yet been executed/has expired/"
				+ "has already been reaped");
		this.pipelineID = id;
	}
}
