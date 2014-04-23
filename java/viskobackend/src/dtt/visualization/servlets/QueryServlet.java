package dtt.visualization.servlets;

import java.io.IOException;
import java.io.PrintWriter;
import java.net.URL;
import java.util.ArrayList;
import java.util.Collection;
import java.util.List;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import dtt.visualization.errors.InvalidQueryException;
import dtt.visualization.errors.JsonError;
import dtt.visualization.errors.MalformedURIError;
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
				
				/* Currently it is infeasible to separate a malformeduri
				 * from a syntax error due to the way that errors are hidden
				 * by the query parser
				Collection<MalformedURIError> uriErrors = this.checkURIs(query);
				if(uriErrors.size() > 0){
					qresponse.addErrors(uriErrors);
				}
				*/
				
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
		this.log(this.gson.toJson(qresponse));
		out.print(this.gson.toJson(qresponse));
		out.flush();
		
	}
	
	/**
	 * Checks a query for malformed URIs, returns an appropriate exception if one is found, null otherwise
	 */
	private Collection<MalformedURIError> checkURIs(Query query){
		
		ArrayList<MalformedURIError> errors = new ArrayList<MalformedURIError>();
		
		String viewerSetURI = query.getViewerSetURI();
		if(viewerSetURI != null && !isURI(viewerSetURI)){
			errors.add(new MalformedURIError("viewerSetURI", viewerSetURI));
		}
		
		String viewURI = query.getViewURI();
		if(viewURI != null && !isURI(viewURI)){
			errors.add(new MalformedURIError("viewURI", viewURI));
		}
		
		String targetFormatURI = query.getTargetFormatURI();
		if(targetFormatURI != null && !isURI(targetFormatURI)){
			errors.add(new MalformedURIError("targetFormatURI", targetFormatURI));
		}
		
		String targetTypeURI = query.getTargetTypeURI();
		if(targetTypeURI != null && !isURI(targetTypeURI)){
			errors.add(new MalformedURIError("targetTypeURI", targetTypeURI));
		}

		
		return errors;
	}
	
	/**
	 * Stolen from Del Rio in QueryParser... tweaked to be more useful.
	 */
	private static boolean isURI(String uri) {
		boolean isURI;
		try {
			URL addr = new URL(uri);
			addr.toURI();
			isURI = true;
			
		} catch (Exception e) {
			isURI = false;
		}

		return isURI;
	}

}
