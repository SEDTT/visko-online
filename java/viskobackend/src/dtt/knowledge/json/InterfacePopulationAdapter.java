package dtt.knowledge.json;

import java.lang.reflect.Type;
import java.util.StringTokenizer;

import com.google.gson.JsonArray;
import com.google.gson.JsonDeserializationContext;
import com.google.gson.JsonDeserializer;
import com.google.gson.JsonElement;
import com.google.gson.JsonObject;
import com.google.gson.JsonParseException;
import com.google.gson.JsonSerializationContext;
import com.google.gson.JsonSerializer;
import com.hp.hpl.jena.query.ResultSet;

/********************************************************************
 * The Interface Population Adapter class is for transforming 
 * visualization abstractions, viewer sets, input formats, input
 * data types, and toolkits to JSON format.
 * @see GsonFactory.java
 * @author Juan Ramirez
 ********************************************************************/
public class InterfacePopulationAdapter  implements JsonSerializer<DropDownListFiller>, JsonDeserializer<DropDownListFiller> {

	/****************************************************************
	 * Serialize a DropDownListFiller class containing all
	 * required ResultSets needed for drop down list population.
	 ***************************************************************/
	@Override
	public JsonElement serialize(DropDownListFiller set, Type type, JsonSerializationContext context){
		JsonObject	jobj = new JsonObject();
		
		JsonArray abstractionSet = new JsonArray();
		JsonArray viewerSet = new JsonArray();
		JsonArray inputFormats = new JsonArray();
		JsonArray inputDataTypes = new JsonArray();
		JsonArray toolkits = new JsonArray();
		String viewURI;
		
		ResultSet abstractions = set.getVisualizationAbstractions();
		ResultSet sets = set.getViewerSets();
		ResultSet formats = set.getInputFormats();
		ResultSet types = set.getInputDataTypes();
		ResultSet kits = set.getToolkits();
		
		// Traverse 
		while(abstractions.hasNext()) {
			JsonObject jsonName = new JsonObject();
			
			viewURI = abstractions.nextSolution().get("?visualizationAbstraction").toString();
			
			// Tokenize the viewURI to just pull the name
			StringTokenizer token = new StringTokenizer(viewURI, "#");
			token.nextToken();
			String abstractionName = token.nextToken();
			

			jsonName.addProperty("abstractionName", abstractionName);
			jsonName.addProperty("abstractionURI", viewURI);
			
			
			abstractionSet.add(jsonName);
		}
		
		jobj.add("abstractions", abstractionSet);
		
		// Traverse Viewer set ResultSet and add to JSON Array.
		while(sets.hasNext()) {
			JsonObject jsonName = new JsonObject();
			
			viewURI = sets.nextSolution().get("?viewerSet").toString();
			
			// Tokenize the viewURI to just pull the name
			StringTokenizer token = new StringTokenizer(viewURI, "#");
			token.nextToken();
			String abstractionName = token.nextToken();
			

			jsonName.addProperty("viewerSetName", abstractionName);
			jsonName.addProperty("viewerSetURI", viewURI);
			
			
			viewerSet.add(jsonName);
		}
		
		jobj.add("viewerSets", viewerSet);
		
		// Traverse Input Format ResultSet and add to JSON Array
		while(formats.hasNext()) {
			JsonObject jsonName = new JsonObject();
			
			viewURI = formats.nextSolution().get("?inputFormat").toString();
			
			// Tokenize the viewURI to just pull the name
			StringTokenizer token = new StringTokenizer(viewURI, "#");
			token.nextToken();
			String abstractionName = token.nextToken();
			

			jsonName.addProperty("inputFormatName", abstractionName);
			jsonName.addProperty("inputFormatURI", viewURI);
			
			
			inputFormats.add(jsonName);
		}
		jobj.add("inputFormats", inputFormats);
		
		// Traverse Input Data Type ResultSet and add to JSON Array object
		while(types.hasNext()) {
			JsonObject jsonName = new JsonObject();
			
			viewURI = types.nextSolution().get("?dataType").toString();
			
			// Tokenize the viewURI to just pull the name
			StringTokenizer token = new StringTokenizer(viewURI, "#");
			token.nextToken();
			String abstractionName = token.nextToken();
			

			jsonName.addProperty("inputDataTypeName", abstractionName);
			jsonName.addProperty("inputDataTypeURI", viewURI);
			
			
			inputDataTypes.add(jsonName);
		}
		
		jobj.add("inputDataTypes", inputDataTypes);
		
		
		// Traverse toolkit ResultSet and add to JSON Array object
		while(kits.hasNext()) {
			JsonObject jsonName = new JsonObject();
			
			viewURI = kits.nextSolution().get("?toolkit").toString();
			
			// Tokenize the viewURI to just pull the name
			StringTokenizer token = new StringTokenizer(viewURI, "#");
			token.nextToken();
			String abstractionName = token.nextToken();
			

			jsonName.addProperty("toolkitName", abstractionName);
			jsonName.addProperty("toolkitURI", viewURI);
			
			
			toolkits.add(jsonName);
		}
		
		jobj.add("toolkits", toolkits);
		
		
		return jobj;
	}

	/*****************************************************************
	 * Required but not implemented, should deserialize functions.
	 *****************************************************************/
	@Override
	public DropDownListFiller deserialize(JsonElement arg0, Type arg1,
			JsonDeserializationContext arg2) throws JsonParseException {
		// TODO Auto-generated method stub
		return null;
	}

	
}
