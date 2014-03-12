
import json.GsonFactory;
import edu.utep.trustlab.visko.execution.PipelineExecutor;
import edu.utep.trustlab.visko.execution.PipelineExecutorJob;
import edu.utep.trustlab.visko.planning.Query;
import edu.utep.trustlab.visko.planning.QueryEngine;
import edu.utep.trustlab.visko.planning.pipelines.Pipeline;
import edu.utep.trustlab.visko.planning.pipelines.PipelineSet;
import edu.utep.trustlab.visko.sparql.SPARQL_EndpointFactory;

import com.google.gson.*;

public class Tester {
	
	public static void main(String[] args){
	
		GsonFactory gfact = new GsonFactory();
		Gson gson = gfact.makeGson();
		
		
		//Specify Location of Triple Store (created with visko/visko-build/build with target build-triple-store)
		SPARQL_EndpointFactory.setUpEndpointConnection("../../../visko/visko/visko-web/WebContent/registry-tdb/");
		
		
		Query query = new Query(getSampleQuery());
		QueryEngine engine = new QueryEngine(query);
		PipelineSet pipes = engine.getPipelines();
		
		Pipeline crackpipe = pipes.get(0);
		
		String crackjson = gson.toJson(crackpipe);
		System.out.println(gson.toJson(crackpipe));
		
		Pipeline cokepipe = gson.fromJson(crackjson, Pipeline.class);
		System.out.println(cokepipe.getViewerSets());
		
		System.out.println("Testing Pipeline Set");
		
		String setjson = gson.toJson(pipes);
		
		System.out.println(setjson);
		
		PipelineSet pset = gson.fromJson(setjson, PipelineSet.class);
		System.out.println(pset.size());
		
		
	}
	
	private static final String NEWLINE = "\n";
	
	public static String getSampleQuery(){
		String queryString =
				"PREFIX views http://openvisko.org/rdf/ontology/visko-view.owl#" + NEWLINE +
				"PREFIX formats http://openvisko.org/rdf/pml2/formats/" + NEWLINE +
				"PREFIX types http://rio.cs.utep.edu/ciserver/ciprojects/CrustalModeling/CrustalModeling.owl#" + NEWLINE +
				"PREFIX visko http://visko.cybershare.utep.edu:5080/visko-web/registry/module_webbrowser.owl#" + NEWLINE +
				"PREFIX params http://visko.cybershare.utep.edu:5080/visko-web/registry/grdcontour.owl#" + NEWLINE +
				"VISUALIZE http://visko.cybershare.utep.edu:5080/visko-web/test-data/gravity/gravityDataset.txt" + NEWLINE +
				"AS views:2D_ContourMap IN visko:web-browser" + NEWLINE +
				"WHERE" + NEWLINE +
				"FORMAT = formats:SPACESEPARATEDVALUES.owl#SPACESEPARATEDVALUES" + NEWLINE +
				"AND TYPE = types:d19";

		return queryString;	
	}
}