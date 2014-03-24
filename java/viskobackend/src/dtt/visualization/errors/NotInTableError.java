package dtt.visualization.errors;

public class NotInTableError extends PipelineStatusError {

	public NotInTableError(int id){
		super(Integer.toString(id), 
				" Has not yet been executed/has expired/" +
				"has already been reaped");
	}
}
