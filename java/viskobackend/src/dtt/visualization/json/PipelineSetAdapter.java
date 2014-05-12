package dtt.visualization.json;

import java.lang.reflect.Type;

import com.google.gson.JsonArray;
import com.google.gson.JsonDeserializationContext;
import com.google.gson.JsonElement;
import com.google.gson.JsonObject;
import com.google.gson.JsonParseException;
import com.google.gson.JsonSerializationContext;
import com.google.gson.JsonSerializer;
import com.google.gson.JsonDeserializer;

import dtt.visualization.IdentifiedPipeline;

import edu.utep.trustlab.visko.planning.Query;
import edu.utep.trustlab.visko.planning.pipelines.Pipeline;
import edu.utep.trustlab.visko.planning.pipelines.PipelineSet;

/**
 * Adapter class for transforming PipelineSets to and from JSON.
 * 
 * This implementation depends on a slightly modified version of VisKo. TODO :
 * Currently ignores Query and bound Parameters.
 * 
 * @author awknaust
 * 
 */
public class PipelineSetAdapter implements JsonSerializer<PipelineSet>,
		JsonDeserializer<PipelineSet> {

	/**
	 * Deserialize a PipelineSet from JSON.
	 * 
	 */
	@Override
	public PipelineSet deserialize(JsonElement jelement, Type type,
			JsonDeserializationContext context) throws JsonParseException {

		JsonObject jobj = (JsonObject) jelement;

		JsonElement jquery = jobj.get("query");
		Query query = context.deserialize(jquery, Query.class);
		PipelineSet pipeSet = new PipelineSet(query);

		JsonArray jarray = jobj.get("pipelines").getAsJsonArray();

		boolean needsInput = false;
		for (JsonElement jsonPipe : jarray) {
			Pipeline p = context
					.deserialize(jsonPipe, IdentifiedPipeline.class);

			needsInput |= p.requiresInputURL();
			// This depends on a modified visko version
			p.setParentPipelineSet(pipeSet);
			pipeSet.add(p);
		}

		JsonElement pipelineArtifactURL = jobj.get("artifactURL");
		if (!pipelineArtifactURL.isJsonNull()) {
			pipeSet.setArtifactURL(pipelineArtifactURL.getAsString());
		} else if (needsInput) {
			pipeSet.setArtifactURL(query.getArtifactURL());
		}

		return pipeSet;
	}

	/**
	 * Serialize a Pipeline set.
	 * 
	 */
	@Override
	public JsonElement serialize(PipelineSet pipeSet, Type type,
			JsonSerializationContext context) {
		JsonObject jobj = new JsonObject();

		jobj.addProperty("artifactURL", pipeSet.getArtifactURL());
		jobj.addProperty("type", PipelineSet.class.getSimpleName());
		jobj.add("query", context.serialize(pipeSet.getQuery()));

		// serialize the pipelines in this set
		JsonArray pipelines = new JsonArray();
		for (Pipeline pipe : pipeSet) {
			pipelines.add(context.serialize(pipe));
		}
		jobj.add("pipelines", pipelines);

		return jobj;
	}

}
