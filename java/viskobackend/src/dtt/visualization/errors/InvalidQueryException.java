package dtt.visualization.errors;

/**
 * An error generated if Query#isValidQuery() fails.
 * @author awknaust
 *
 */
public class InvalidQueryException extends VisualizationError {


	public InvalidQueryException(){
		super("This Query is not valid");
	}
	
}
