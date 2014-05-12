package dtt.visualization.errors;

/**
 * Some sort of problem occurred when executing a pipeline.
 * 
 * @author awknaust
 * 
 */
public class PipelineExecutionError extends VisualizationError {

	public PipelineExecutionError(String message) {
		super(message);
	}
}
