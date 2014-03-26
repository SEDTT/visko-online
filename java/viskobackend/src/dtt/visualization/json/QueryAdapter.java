package dtt.visualization.json;

import java.lang.reflect.Type;
import java.util.HashMap;
import java.util.Map;

import com.google.gson.JsonDeserializationContext;
import com.google.gson.JsonDeserializer;
import com.google.gson.JsonElement;
import com.google.gson.JsonObject;
import com.google.gson.JsonParseException;
import com.google.gson.JsonSerializationContext;
import com.google.gson.JsonSerializer;
import com.google.gson.reflect.TypeToken;

import edu.utep.trustlab.visko.planning.Query;

/**
 * Class for serializing/deserializing a query object.
 * 
 * In json a query can be deserialized from either all of its fields, or from the VSQL text.
 * If using the VSQL text directly, simply pass "vsql : text", and other fields will be ignored.
 * 
 * TODO : add support for parameter bindings
 * 
 * @author awknaust
 *
 */
public class QueryAdapter implements JsonSerializer<Query>, JsonDeserializer<Query>{

	/**
	 * Deserialize a query from either its fields or from a vsql string.
	 */
	@Override
	public Query deserialize(JsonElement json, Type type,
			JsonDeserializationContext context) throws JsonParseException {
		
		JsonObject jobj = (JsonObject)json;
		
		JsonElement vsql = jobj.get("vsql");
				
		//required
		JsonElement jFormatURI = jobj.get("formatURI");
		JsonElement jViewerSetURI = jobj.get("viewerSetURI");
		JsonElement jDatasetURL = jobj.get("artifactURL");
		
		//optional
		JsonElement jTypeURI = jobj.get("typeURI");
		JsonElement jViewURI = jobj.get("viewURI");
		JsonElement jTargetFormatURI = jobj.get("targetFormatURI");
		JsonElement jTargetTypeURI = jobj.get("targetTypeURI");
		
		//parameters
		JsonElement jParameterBindings = jobj.get("parameterBindings");
		
		
		Query query;
		
		//Check if it was submitted as VSQL and override other features
		if (vsql != null && vsql.isJsonPrimitive()){
			
			query = new Query(vsql.getAsString().trim());
			
		}
		else {//parse from elements
			
			if((jFormatURI == null || !jFormatURI.isJsonPrimitive())
					|| (jViewerSetURI == null || !jViewerSetURI.isJsonPrimitive())){
						throw new JsonParseException("Missing VSQL or viewerSetURI/formatURI");
					}
			else{
				//TODO is dataset really optional??
				if(jDatasetURL == null || !jDatasetURL.isJsonPrimitive()){
					query = new Query(null, jFormatURI.getAsString(), jViewerSetURI.getAsString());
				}else{
					query = new Query(jDatasetURL.getAsString(), jFormatURI.getAsString(), jViewerSetURI.getAsString());
				}
			}
			
			//get optional fields
			if(jTypeURI != null && jTypeURI.isJsonPrimitive()){
				query.setTypeURI(jTypeURI.getAsString());
			}
			if(jViewURI != null && jViewURI.isJsonPrimitive()){
				query.setViewURI(jViewURI.getAsString());
			}
			if(jTargetFormatURI != null && jTargetFormatURI.isJsonPrimitive()){
				query.setTargetFormatURI(jTargetFormatURI.getAsString());
			}
			if(jTargetTypeURI != null && jTargetTypeURI.isJsonPrimitive()){
				query.setTargetTypeURI(jTargetTypeURI.getAsString());
			}
			if(jParameterBindings != null){
				Type typeOfHashMap = new TypeToken<HashMap<String, String>>() { }.getType();
				HashMap<String, String> parameterBindings = context.deserialize(
					jobj.get("parameterBindings"), 
					typeOfHashMap);
				query.setParameterBindings(parameterBindings);
				
			}
			
		}
		
		return query;
	}

	/**
	 * Serialize a Query, including all of its fields, and the VSQL as "vsql"
	 */
	@Override
	public JsonElement serialize(Query query, Type type,
			JsonSerializationContext context) {
		
		JsonObject jobj = new JsonObject();
		jobj.addProperty("type", Query.class.getSimpleName());
		jobj.addProperty("formatURI", query.getFormatURI());
		jobj.addProperty("viewerSetURI", query.getViewerSetURI());
		jobj.addProperty("artifactURL", query.getArtifactURL());
		jobj.addProperty("targetFormatURI", query.getTargetFormatURI());
		jobj.addProperty("targetTypeURI", query.getTargetTypeURI());
		jobj.addProperty("viewURI", query.getViewURI());
		jobj.addProperty("vsql", query.toString().trim());
		
		Type typeOfHashMap = new TypeToken<HashMap<String, String>>() { }.getType();
		jobj.add("parameterBindings", 
				context.serialize(query.getParameterBindings(), typeOfHashMap));
		
		return jobj;
	}

}
