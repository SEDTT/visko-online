package dtt.visualization.json;

import java.lang.reflect.Type;

import edu.utep.trustlab.visko.planning.pipelines.Pipeline;

import com.google.gson.JsonArray;
import com.google.gson.JsonDeserializationContext;
import com.google.gson.JsonDeserializer;
import com.google.gson.JsonElement;
import com.google.gson.JsonObject;
import com.google.gson.JsonParseException;
import com.google.gson.JsonSerializationContext;
import com.google.gson.JsonSerializer;

/**
 * An adapter to convert Pipeline objects to JSON.
 * 
 * Should only be used indirectly by PipelineSetAdapter.
 * @author awknaust
 *
 */
public class PipelineAdapter implements JsonSerializer<Pipeline> {

	@Override
	public JsonElement serialize(Pipeline pipe, Type type, JsonSerializationContext context) {
		JsonObject	jobj = new JsonObject();
		
		jobj.addProperty("type", Pipeline.class.getSimpleName());
		jobj.addProperty("viewerURI", pipe.getViewerURI());
		jobj.addProperty("viewURI", pipe.getViewURI());
		
		//Add vector of services
		JsonArray services = new JsonArray();
		for (String svc : pipe){
			services.add(context.serialize(svc));
		}
		jobj.add("services", services);
		
		//Add viewer set URIs
		
		JsonArray viewerSets = new JsonArray();
		for(String vset : pipe.getViewerSets()){
			viewerSets.add(context.serialize(vset));
		}
		jobj.add("viewerSets", viewerSets);
		
		//Add some method call results
		jobj.addProperty("requiresInputURL", pipe.requiresInputURL());
		jobj.addProperty("getToolkitThatGeneratesView", pipe.getToolkitThatGeneratesView());
		jobj.addProperty("getOutputFormat", pipe.getOutputFormat());
		
		return jobj;
	}

}
