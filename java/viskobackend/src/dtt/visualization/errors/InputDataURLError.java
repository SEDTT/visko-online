package dtt.visualization.errors;

public class InputDataURLError extends VisualizationError {

	private String inputDataURL;
	
	public InputDataURLError(String url) {
		super("Input Data URL is unreachable (" + url + ")");
		this.inputDataURL = url;
	}

}
