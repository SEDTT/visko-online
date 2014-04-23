package dtt.visualization.errors;

public class NotInTableError extends PipelineStatusError {
	private int pipelineID;
	
	public NotInTableError(int id){
		super(Integer.toString(id), 
				" Has not yet been executed/has expired/" +
				"has already been reaped");
		this.pipelineID = id;
	}
}
