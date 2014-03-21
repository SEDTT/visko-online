package dtt.visualization.errors;

public class NoQueryError extends VisualizationError {

	public NoQueryError(){
		super("Missing the query parameter. Should be a JSON Serialized Visko Query.");
	}
}
