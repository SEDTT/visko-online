package dtt.visualization.errors;

import com.google.gson.JsonParseException;

public class JsonError extends VisualizationError {

	public JsonError(JsonParseException e) {
		super(e.getMessage());
	}

}
