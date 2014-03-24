package knowledge;

import java.io.IOException;
import java.io.PrintWriter;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import json.DropDownListFiller;
import json.GsonFactory;

import com.google.gson.Gson;
import com.hp.hpl.jena.query.ResultSet;

import dtt.JsonServlet;
import edu.utep.trustlab.visko.sparql.SPARQL_EndpointFactory;
import edu.utep.trustlab.visko.sparql.ViskoTripleStore;

@WebServlet("/dropdownlists")
public class DropDownLists extends JsonServlet {

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;

	@Override
	protected void doJson(HttpServletRequest request,
			HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		PrintWriter out = response.getWriter();
		
		GsonFactory gfact = new GsonFactory();
		Gson gson = gfact.makeGson();
		
		//SPARQL_EndpointFactory.setUpEndpointConnection("../../../visko/visko/visko-web/WebContent/registry-tdb/");
		//SPARQL_EndpointFactory.setUpEndpointConnection("/Users/JuanRamirez/Desktop/visko/visko/visko-web/WebContent/registry-tdb");
		
		ViskoTripleStore store = new ViskoTripleStore();
		
		// ResultSets to populate drop-down lists
		ResultSet visualizationAbstractions = store.getVisualizationAbstractions();
		ResultSet viewerSets = store.getViewerSets();
		ResultSet inputFormats = store.getInputFormats();
		ResultSet inputDataTypes = store.getInputDataTypes();
		ResultSet toolkits = store.getToolkits();
		
		DropDownListFiller test = new DropDownListFiller(visualizationAbstractions, viewerSets, inputFormats, inputDataTypes, toolkits);
		
		String json = gson.toJson(test);
		out.println(json);
	}

}
