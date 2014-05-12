package dtt.visualization.json;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;

import dtt.visualization.IdentifiedPipeline;
import edu.utep.trustlab.visko.planning.Query;
import edu.utep.trustlab.visko.planning.pipelines.Pipeline;
import edu.utep.trustlab.visko.planning.pipelines.PipelineSet;

public class GsonFactory {

	public static boolean PRETTY_PRINT = true;
	public static boolean SERIALIZE_NULLS = true;

	/**
	 * Creates a properly initialized gson object
	 * 
	 * Registers adapters for Visko objects.
	 * 
	 * @return An initialized gson object capable of formatting Visko Objects.
	 */
	public Gson makeGson() {

		GsonBuilder gbuilder = new GsonBuilder();

		if (PRETTY_PRINT) {
			gbuilder.setPrettyPrinting();
		}

		gbuilder.registerTypeAdapter(Query.class, new QueryAdapter());
		gbuilder.registerTypeAdapter(PipelineSet.class,
				new PipelineSetAdapter());
		gbuilder.registerTypeAdapter(Pipeline.class, new PipelineAdapter());
		gbuilder.registerTypeAdapter(IdentifiedPipeline.class,
				new IdentifiedPipelineAdapter());
		// gbuilder.registerTypeAdapter(QueryResponse.class, new
		// QueryResponseAdapter());

		if (SERIALIZE_NULLS)
			gbuilder.serializeNulls();

		return gbuilder.create();
	}
}
