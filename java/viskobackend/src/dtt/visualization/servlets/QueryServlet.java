package dtt.visualization.servlets;

import java.io.IOException;
import java.io.PrintWriter;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import dtt.visualization.errors.InvalidQueryException;
import dtt.visualization.errors.JsonError;
import dtt.visualization.errors.MissingParameterError;
import dtt.visualization.errors.UnexecutableQueryException;
import dtt.visualization.errors.VisualizationError;
import dtt.visualization.responses.QueryResponse;
import edu.utep.trustlab.visko.planning.Query;
import edu.utep.trustlab.visko.planning.QueryEngine;
import edu.utep.trustlab.visko.planning.pipelines.PipelineSet;

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
			qresponse.addError(new MissingParameterError("query",
					"A JSON serialized ViskoQuery object"));
			this.log("Received request without query.");
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
				qresponse.addError(new VisualizationError(
						"Unexpected Error of type (" + e1.getClass().getSimpleName() 
						+ ") Check Tomcat log"));
				e1.printStackTrace();
			}
				
			
		}
		//spit out the response
		out.print(this.gson.toJson(qresponse));
		out.flush();
		
	}

}
