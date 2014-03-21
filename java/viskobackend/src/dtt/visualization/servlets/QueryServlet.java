package dtt.visualization.servlets;

import java.io.IOException;
import java.io.PrintWriter;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import dtt.visualization.QueryResponse;
import dtt.visualization.errors.InvalidQueryException;
import dtt.visualization.errors.JsonError;
import dtt.visualization.errors.UnexecutableQueryException;
import dtt.visualization.errors.VisualizationError;
import edu.utep.trustlab.visko.planning.Query;
import edu.utep.trustlab.visko.planning.QueryEngine;
import edu.utep.trustlab.visko.planning.pipelines.PipelineSet;
import edu.utep.trustlab.visko.sparql.SPARQL_EndpointFactory;

/**
 * This Servlet is responsible for serving the "/query" URL.
 * 
 * It accepts a Query from JSON and attempts to generate a PipelineSet in response. It actually
 * generates a QueryResponse object, which may contain a PipelineSet and any errors encountered
 * during production of the pipelines.
 * 
 */
@WebServlet("/query")
public class QueryServlet extends VisualizationServlet {
	private static final long serialVersionUID = 1L;
    
    /**
     * @see HttpServlet#HttpServlet()
     */
    public QueryServlet() {
        super();
    }


	
    /**
     * Pull a JSON'd Query object from the 'query' parameter, and respond with a QueryResponse (pipelineset).
     */
	@Override
	protected void doJson(HttpServletRequest request,
			HttpServletResponse response) throws ServletException, IOException {
		PrintWriter out = response.getWriter();
		String rawQuery = request.getParameter("query");
		
		
		QueryResponse qresponse = new QueryResponse();
		/* Failed to pass query => show sample query*/
		if(rawQuery == null){
			Query q = new Query(getSampleQuery());
			out.print(this.gson.toJson(q));
		}else{
			Query query;
			try{
				query = this.gson.fromJson(rawQuery, Query.class);
				QueryEngine queryEngine = new QueryEngine(query);
				
				/* Invalid Queries = error while getting pipelines */
				if(query.isValidQuery()){
					
					/* May generate pipelines, but they will be useless */
					if(!query.isExecutableQuery()){
						this.log("Unexecutable Query Received");
						qresponse.addError(new UnexecutableQueryException());
					}
					
					System.out.println(query.isExecutableQuery());
					/* Generate Pipelines and return */
					PipelineSet pipes = queryEngine.getPipelines();
					this.log("Generated " + pipes.size() + " pipelines from query");
					
					qresponse.setPipelines(pipes);
					
				
				}else{
					this.log("Invalid Query Received");
					qresponse.addError(new InvalidQueryException());
				}
				
			}catch(com.google.gson.JsonParseException e){
				qresponse.addError(new JsonError(e));
			}catch(Exception e1){ //this is for programmer error
				qresponse.addError(new VisualizationError(e1.getClass().getSimpleName()));
				e1.printStackTrace();
			}
				
			//spit out the response
			out.print(this.gson.toJson(qresponse));
		}
		out.flush();
		
	}
	
	//TODO remove this
	public static String getSampleQuery(){
		String NEWLINE = "\n";
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
