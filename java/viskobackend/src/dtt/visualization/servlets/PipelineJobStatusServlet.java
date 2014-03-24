package dtt.visualization.servlets;

import java.io.IOException;
import java.io.PrintWriter;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.Servlet;
import javax.servlet.ServletContext;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import dtt.visualization.PipelineJobTable;

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
		out.println("Welcome to the pipeline status page!!");
		

	}

}
