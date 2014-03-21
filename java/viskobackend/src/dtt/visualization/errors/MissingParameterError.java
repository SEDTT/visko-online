package dtt.visualization.errors;

public class MissingParameterError extends VisualizationError {

	public MissingParameterError(String paramName, String description){
		super("Missing '"+ paramName + "' Parameter. Should be " + description);
	}
}
