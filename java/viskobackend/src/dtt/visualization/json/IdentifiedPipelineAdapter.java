package dtt.visualization.json;

import java.lang.reflect.Type;

import dtt.visualization.IdentifiedPipeline;

import com.google.gson.JsonArray;
import com.google.gson.JsonDeserializationContext;
import com.google.gson.JsonDeserializer;
import com.google.gson.JsonElement;
import com.google.gson.JsonObject;
import com.google.gson.JsonParseException;


/**
 * An adapter to retrieve Pipelines with IDs (IdentifiedPipelines) from JSON.
 * 
 * Should only be used indirectly by PipelineSetAdapter.
 * @author awknaust
 *
 */
public class IdentifiedPipelineAdapter implements JsonDeserializer<IdentifiedPipeline> {



	@Override
	public IdentifiedPipeline deserialize(JsonElement jelement, Type type,
			JsonDeserializationContext context) throws JsonParseException {
		
		JsonObject jobj = (JsonObject) jelement;
		
		//get named fields
		String viewerURI = jobj.get("viewerURI").getAsString();
		String viewURI = jobj.get("viewURI").getAsString();
		
		
		IdentifiedPipeline pipe = new IdentifiedPipeline(viewerURI, viewURI, null);
		
		/* When deserializing they should have a unique w.r.t table ID! */
		int id = jobj.get("id").getAsInt();
		pipe.setID(id);
		
		JsonArray services = jobj.getAsJsonArray("services");
		
		/* Get the list of services */
		for(JsonElement svc : services){
			pipe.add(svc.getAsString());
		}
		
		return pipe;
	}

}
