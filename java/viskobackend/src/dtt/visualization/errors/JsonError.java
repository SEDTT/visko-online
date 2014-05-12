package dtt.visualization.errors;

import com.google.gson.JsonParseException;

/**
 * Passed on if a servlet failed to parse the a json object.
 * @author awknaust
 *
 */
public class JsonError extends VisualizationError {

	public JsonError(JsonParseException e) {
		super(e.getMessage());
	}

}
