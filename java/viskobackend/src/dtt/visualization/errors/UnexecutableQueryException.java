package dtt.visualization.errors;

/**
 * An error generated if Query#isExecutableQuery() fails.
 * 
 * @author awknaust
 * 
 */
public class UnexecutableQueryException extends VisualizationError {

	public UnexecutableQueryException() {
		super("Query is invalid or query datasetURL is not a valid URL");
	}
}
