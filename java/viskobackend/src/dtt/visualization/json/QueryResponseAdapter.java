package dtt.visualization.json;

import java.lang.reflect.Type;

import com.google.gson.JsonArray;
import com.google.gson.JsonElement;
import com.google.gson.JsonObject;
import com.google.gson.JsonSerializationContext;
import com.google.gson.JsonSerializer;

import dtt.visualization.QueryResponse;
import dtt.visualization.errors.VisualizationError;

/**
 * Serialize a QueryResponse to JSON.
 * 
 * Example : 
 * 	{
  "type": "QueryResponse",
  "pipelines": null,
  "errors": [
    {
      "message": "This Query is not valid",
      "type": "InvalidQueryException"
    }
  ]
}
 * @author awknaust
 *
 */
public class QueryResponseAdapter implements JsonSerializer<QueryResponse>{

	@Override
	public JsonElement serialize(QueryResponse qresp, Type arg1,
			JsonSerializationContext context) {
		
		JsonObject jobj = new JsonObject();
		jobj.addProperty("type", QueryResponse.class.getSimpleName());
		jobj.add("pipelines", context.serialize(qresp.getPipelines()));
		
		JsonArray errors = new JsonArray();
		
		for (VisualizationError e : qresp.getErrors()){
			errors.add(context.serialize(e));
		}
		jobj.add("errors", errors);
		
		return jobj;
	}

}
