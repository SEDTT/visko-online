package dtt.visualization.errors;

public class MalformedURIError extends VisualizationError {

	private String uri;
	private String field;
	
	public MalformedURIError(String field, String uri) {
		super("Detected malformed URI : " + field + " (" + uri + ")");
		this.uri = uri;
		this.field = field;
	}

}
