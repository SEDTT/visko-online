package dtt.visualization.servlets;

import java.io.IOException;
import java.io.PrintWriter;
import java.util.Arrays;

import javax.servlet.ServletContext;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import dtt.visualization.PipelineJobTable;
import dtt.visualization.errors.MissingParameterError;
import dtt.visualization.errors.NotInTableError;
import dtt.visualization.errors.PipelineStatusError;
import dtt.visualization.responses.PipelineStatusResponse;
import edu.utep.trustlab.visko.execution.PipelineExecutorJob;

@WebServlet("/status")
public class PipelineJobStatusServlet extends VisualizationServlet {

	private static final long serialVersionUID = 3873749900685092246L;
	private PipelineJobTable jobTable;
	
	/**
	 * TODO : is this a race condition? with PipelineExecutionServlet#init()
	 */
	public void init(){
		ServletContext sc = this.getServletContext();
		PipelineJobTable jobTable = (PipelineJobTable) sc.getAttribute("visualization.pipeline.jobtable");
		if (jobTable == null){
			jobTable = new PipelineJobTable();
			sc.setAttribute("visualization.pipeline.jobtable", jobTable);
		}
		this.jobTable = jobTable;
	}
	
	@Override
	protected void doJson(HttpServletRequest request,
			HttpServletResponse response) throws ServletException, IOException {
		
		PrintWriter out = response.getWriter();
		String[] rawIDs = request.getParameterValues("id");
		PipelineStatusResponse psresp = new PipelineStatusResponse();
		
		this.log("Received Status request for ids : " + Arrays.toString(rawIDs));
		
		if(rawIDs == null || rawIDs.length == 0){
			psresp.addError(new MissingParameterError("id", "List of integer ids of executing pipelines"));
		}else{
			/* Support multiple status requests simultaneously */
			for(String rawID : rawIDs){
				try{
					int id = Integer.parseInt(rawID);
					
					/* Add status to response for everything that is in the table */
					if(this.jobTable.containsKey(id)){
						PipelineExecutorJob job = this.jobTable.get(id);
						psresp.addStatus(id, job);
						
					}else{
						psresp.addError(new NotInTableError(id));
					}
				}catch(NumberFormatException e){
					psresp.addError(new PipelineStatusError(
							rawID, "Not a valid integer")
					);
				}
			}
		}
		
		out.println(this.gson.toJson(psresp));
		out.flush();
	}
}
