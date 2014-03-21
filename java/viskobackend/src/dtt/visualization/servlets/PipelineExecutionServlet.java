package dtt.visualization.servlets;

import java.io.IOException;
import java.io.PrintWriter;

import javax.servlet.Servlet;
import javax.servlet.ServletContext;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import dtt.visualization.PipelineJobTable;
import edu.utep.trustlab.visko.execution.PipelineExecutorJob;
import edu.utep.trustlab.visko.planning.pipelines.Pipeline;

/**
 * Servlet implementation class PipelineExecutionServlet
 */
@WebServlet("/execute")
public class PipelineExecutionServlet extends VisualizationServlet implements Servlet {
	private static final long serialVersionUID = 1L;
	private PipelineJobTable jobTable;

	/**
	 * Initialize the PipelineJobTable in the server context.
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
		out.println("Welcome to Pipeline Execution Page");
		
	}

}
