package json;

import com.google.gson.GsonBuilder;
import com.google.gson.Gson;

import edu.utep.trustlab.visko.planning.pipelines.Pipeline;
import edu.utep.trustlab.visko.planning.pipelines.PipelineSet;

public class GsonFactory{

	public static boolean PRETTY_PRINT = true;
	public static boolean SERIALIZE_NULLS = true;
	/**
	 * Creates a properly initialized gson object
	 * 
	 * Registers adapters for Visko objects.
	 * 
	 * @return An initialized gson object capable of formatting Visko Objects.
	 */
	public Gson makeGson(){
		
		GsonBuilder gbuilder = new GsonBuilder();
		
		if(PRETTY_PRINT){
			gbuilder.setPrettyPrinting();
		}
		
		gbuilder.registerTypeAdapter(PipelineSet.class, new PipelineSetAdapter());
		gbuilder.registerTypeAdapter(Pipeline.class, new PipelineAdapter());
		
		if(SERIALIZE_NULLS)
			gbuilder.serializeNulls();
		
		return gbuilder.create();
	}
}
