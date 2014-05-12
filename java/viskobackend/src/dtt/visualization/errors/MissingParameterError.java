package dtt.visualization.errors;

/**
 * Created if a Servlet is missing a necessary url parameter.
 * 
 * @author awknaust
 * 
 */
public class MissingParameterError extends VisualizationError {

	public MissingParameterError(String paramName, String description) {
		super("Missing '" + paramName + "' Parameter. Should be " + description);
	}
}
