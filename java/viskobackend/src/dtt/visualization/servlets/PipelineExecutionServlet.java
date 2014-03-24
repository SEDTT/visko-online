package dtt.visualization.servlets;

import java.io.IOException;
import java.io.PrintWriter;

import javax.servlet.Servlet;
import javax.servlet.ServletContext;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import dtt.visualization.IdentifiedPipeline;
import dtt.visualization.PipelineJobTable;
import dtt.visualization.errors.JsonError;
import dtt.visualization.errors.MissingParameterError;
import dtt.visualization.errors.PipelineExecutionError;
import dtt.visualization.errors.UnexecutableQueryException;
import dtt.visualization.errors.VisualizationError;
import dtt.visualization.responses.PipelineExecutionResponse;
import edu.utep.trustlab.visko.execution.PipelineExecutor;
import edu.utep.trustlab.visko.execution.PipelineExecutorJob;
import edu.utep.trustlab.visko.planning.pipelines.PipelineSet;

/**
 * Servlet implementation class PipelineExecutionServlet. Receives a PipelineSet
 * with exactly 1 identifiedpipeline, (pipelineset must also have proper query, and
 * artifactURL). It puts the pipelinejob into the job table, and then executes the job.
 * 
 * Upon completion of execution, the servlet responds with a json serialized PipelineExecutionResponse
 * that includes the final pipelinejobstatus, and result URL if it exists.
 * 
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


	/**
	 * TODO : only executes first pipeline in pipelineset!
	 */
	@Override
	protected void doJson(HttpServletRequest request,
			HttpServletResponse response) throws ServletException, IOException {
		PrintWriter out = response.getWriter();
		
		PipelineExecutionResponse presp = new PipelineExecutionResponse();
		String rawPipelineSet = request.getParameter("pipelineset");
		
		if(rawPipelineSet == null){
			presp.addError(new MissingParameterError(
					"pipelineset",
					"JSON Serialized PipelineSet with uniquely identified Pipelines," +
					"and responsible Query, that will be executed"
					));
		}else{
			try{
				
				PipelineSet pset = gson.fromJson(rawPipelineSet, PipelineSet.class);
				
				if(!pset.getQuery().isExecutableQuery()){
					presp.addError(new UnexecutableQueryException());
				}
				else if(pset.isEmpty()){
					presp.addError(new PipelineExecutionError("Input PipelineSet is missing pipelines"));
				}else if(pset.size() > 1){
					presp.addError(new PipelineExecutionError("Only single pipeline execution is supported."));
				}
				else{
					IdentifiedPipeline pipe = (IdentifiedPipeline)pset.firstElement();
					this.log("Received Pipe with ID " + pipe.getID());
					
					/* Put the job into the table so we can fetch its status*/
					if(this.jobTable.containsKey(pipe.getID())){
						presp.addError(new PipelineExecutionError("Conflicting pipeline ID in table"));
					}else{
						PipelineExecutorJob job = new PipelineExecutorJob(pipe);
						this.jobTable.put(pipe.getID(), job);
						
						
						/* Set up the job to be executed */
						PipelineExecutor executor = new PipelineExecutorWithErrors();
						
						executor.setJob(job);
							//fork thread to run service
							executor.process();
							
							/* 
							 * Error handling on PipelineExecutors is impossible without altering the API
							 * We can only know if it failed or not.
							 * TODO how long to try this if it doesn't work ?? 
							 * 
							 * Also, while polling is bad-form... consider changing to sleeping/notify.
							 * (This also seems extremely difficult to fix without redesigning the API, possibly
							 * by extending PipelineExecutor)
							 */
							synchronized(this){
								//TODO test this better
								this.wait();
							}
							/*
							while(executor.isAlive()){
								this.log("executing serivce with index: " + job.getJobStatus().getCurrentServiceIndex());
								this.log("executing: " + job.getJobStatus().getCurrentServiceURI());
								this.log(job.getJobStatus().getPipelineState().toString());
							}
							*/
							
							this.log("Pipeline execution completed Normally? : " +
									job.getJobStatus().didJobCompletedNormally());
							
							/* Set up the response with the results */
							presp.setCompletedNormally(job.getJobStatus().didJobCompletedNormally());
							presp.setLastPipelineState(job.getJobStatus().getPipelineState());
							presp.setLastService(job.getJobStatus().getCurrentServiceIndex());
							presp.setStateMessage(job.getJobStatus().toString());
							presp.setResultURL(job.getFinalResultURL());
					}
				}
				
			}catch(com.google.gson.JsonParseException e){
				presp.addError(new JsonError(e));
			}catch(Exception e1){ //this is for programmer error
				presp.addError(new VisualizationError(
						"Unexpected Error of type (" + e1.getClass().getSimpleName() 
						+ ") Check Tomcat log"));
				e1.printStackTrace();
			}
		}
		
		out.println(gson.toJson(presp));
		out.flush();
	}

	class PipelineExecutorWithErrors extends PipelineExecutor{
		
		/* Override run to notify the executing servlet */
		@Override
		public void run(){
			synchronized(PipelineExecutionServlet.this){
				super.run();
				PipelineExecutionServlet.this.notify();
			}
		}
	}
}





