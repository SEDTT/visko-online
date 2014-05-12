package dtt.visualization.servlets;

import java.io.IOException;
import java.io.PrintWriter;
import java.net.HttpURLConnection;
import java.net.URL;

import javax.servlet.Servlet;
import javax.servlet.ServletContext;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import dtt.visualization.IdentifiedPipeline;
import dtt.visualization.PipelineJobTable;
import dtt.visualization.errors.InputDataURLError;
import dtt.visualization.errors.JsonError;
import dtt.visualization.errors.MissingParameterError;
import dtt.visualization.errors.PipelineExecutionError;
import dtt.visualization.errors.PipelineExecutionTimeoutError;
import dtt.visualization.errors.UnexecutableQueryException;
import dtt.visualization.errors.VisualizationError;
import dtt.visualization.responses.PipelineExecutionResponse;
import edu.utep.trustlab.visko.execution.PipelineExecutor;
import edu.utep.trustlab.visko.execution.PipelineExecutorJob;
import edu.utep.trustlab.visko.execution.PipelineExecutorJobStatus.PipelineState;
import edu.utep.trustlab.visko.planning.QueryEngine;
import edu.utep.trustlab.visko.planning.pipelines.PipelineSet;

/**
 * Servlet implementation class PipelineExecutionServlet. Receives a PipelineSet
 * with exactly 1 identifiedpipeline, (pipelineset must also have proper query,
 * and artifactURL). It puts the pipelinejob into the job table, and then
 * executes the job.
 * 
 * Upon completion of execution, the servlet responds with a json serialized
 * PipelineExecutionResponse that includes the final pipelinejobstatus, and
 * result URL if it exists.
 * 
 */
@WebServlet("/execute")
public class PipelineExecutionServlet extends VisualizationServlet implements
		Servlet {
	private static final long serialVersionUID = 1L;
	private PipelineJobTable jobTable;

	/* Maximum time to execute a service in ms */
	private static final int SERVICE_TIMEOUT = 10000;

	/* Maximum time for entire pipeline in ms */
	private static final int PIPELINE_TIMEOUT = 30000;

	/* How often to check pipeline status while executing in ms */
	private static final int POLL_INTERVAL = 100;

	/* How long to wait after execution *should* have completed */
	private static final int JOIN_TIMEOUT = 1000;

	/* Maximum wait time on input data url */
	private static final int INPUT_TIMEOUT = 3000;

	/**
	 * Initialize the PipelineJobTable in the server context.
	 * 
	 * @throws ServletException
	 */
	public void init() throws ServletException {
		super.init();
		ServletContext sc = this.getServletContext();

		PipelineJobTable jobTable = (PipelineJobTable) sc
				.getAttribute("visualization.pipeline.jobtable");
		if (jobTable == null) {
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

		if (rawPipelineSet == null) {
			presp.addError(new MissingParameterError("pipelineset",
					"JSON Serialized PipelineSet with uniquely identified Pipelines,"
							+ "and responsible Query, that will be executed"));
		} else {
			try {

				PipelineSet pset = gson.fromJson(rawPipelineSet,
						PipelineSet.class);
				IdentifiedPipeline pipe = (IdentifiedPipeline) pset
						.firstElement();

				if (!pset.getQuery().isExecutableQuery()) {
					presp.addError(new UnexecutableQueryException());
					this.jobTable.put(pipe.getID(),
							new UnexecutableQueryException());
				} else if (pset.isEmpty()) {
					PipelineExecutionError e = new PipelineExecutionError(
							"Input PipelineSet is missing pipelines");
					presp.addError(e);
					this.jobTable.put(pipe.getID(), e);
				} else if (pset.size() > 1) {
					PipelineExecutionError e = new PipelineExecutionError(
							"Only single pipeline execution is supported.");
					presp.addError(e);
					this.jobTable.put(pipe.getID(), e);
				} else if (!this.isURLReachable(new URL(pset.getQuery()
						.getArtifactURL()))) {
					InputDataURLError e = new InputDataURLError(pset.getQuery()
							.getArtifactURL());
					presp.addError(e);
					this.jobTable.put(pipe.getID(), e);
				} else {
					// TODO this is a hack to get default pipeline parameters
					// for the query
					// and should be replaced by smarter viskopipeline codes.
					QueryEngine queryEngine = new QueryEngine(pset.getQuery());
					queryEngine.getPipelines();
					pset.setParameterBindings(queryEngine.getQuery()
							.getParameterBindings());

					this.log("Received Pipe with ID " + pipe.getID());

					/* Put the job into the table so we can fetch its status */
					if (this.jobTable.containsKey(pipe.getID())) {
						VisualizationError e = new PipelineExecutionError(
								"Conflicting pipeline ID in table");
						presp.addError(e);
						this.jobTable.put(pipe.getID(), e);
					} else {
						PipelineExecutorJob job = new PipelineExecutorJob(pipe);
						this.jobTable.put(pipe.getID(), job);

						// execute the job (blocking)
						VisualizationError ve = this.executePipelineJob(job);

						if (ve == null) {
							// actual success ~ ish
							presp.setStatus(pipe.getID(), job);

							this.log("Pipeline execution completed Normally? : "
									+ job.getJobStatus()
											.didJobCompletedNormally());

						} else {
							presp.addError(ve);
							this.jobTable.get(pipe.getID()).setError(ve);
							this.log("Interrupted Pipeline Execution");
						}
					}
				}

			} catch (com.google.gson.JsonParseException e) {
				presp.addError(new JsonError(e));
			} catch (Exception e1) { // this is for programmer error
				presp.addError(new VisualizationError(
						"Unexpected Error of type ("
								+ e1.getClass().getSimpleName()
								+ ") Check Tomcat log"));
				e1.printStackTrace();
			}
		}

		this.log(gson.toJson(presp));
		out.println(gson.toJson(presp));
		out.flush();
	}

	/**
	 * Checks if a url is reachable via a HEAD request
	 * 
	 * @param url
	 *            URL to test.
	 * @return true if reachable, false otherwise.
	 */
	private boolean isURLReachable(URL url) {
		HttpURLConnection connection;
		try {

			connection = (HttpURLConnection) url.openConnection();
			connection.setReadTimeout(INPUT_TIMEOUT);
			connection.setConnectTimeout(INPUT_TIMEOUT);

			connection.setRequestMethod("HEAD");
			int responseCode = connection.getResponseCode();
			connection.disconnect();
			return responseCode == 200;

		} catch (IOException e1) {
			this.log("Unreachable URL : " + e1.getMessage());
			return false;
		}
	}

	/**
	 * Converts nanoseconds to milliseconds
	 * 
	 * @param nanos
	 * @return
	 */
	private long toMilliSeconds(long nanos) {
		return nanos / 1000000;
	}

	/**
	 * Converts milliseconds to nanoseconds
	 * 
	 * @param millis
	 * @return
	 */
	private long toNanoSeconds(long millis) {
		return millis * 1000000;
	}

	/**
	 * Execute a pipeline job and monitor how long it takes to run.
	 * 
	 * Unfortunately there doesn't seem to be a way to actually kill the thread.
	 * It can timeout itself in another call and never get to the
	 * isScheduledForTermination... part.
	 * 
	 * @param job
	 * 
	 * @return a PipelineExecutionTimeoutError if any of the services or the
	 *         entire pipeline took too long to execute. returns null if
	 *         successful
	 * 
	 * @throws InterruptedException
	 *             if this thread is interrupted
	 */
	private PipelineExecutionTimeoutError executePipelineJob(
			PipelineExecutorJob job) throws InterruptedException {
		/* Set up executor, but start in our own thread */
		PipelineExecutor executor = new PipelineExecutor();
		executor.setJob(job);
		Thread t = new Thread(executor);
		t.start();

		boolean live = true;
		long serviceStart = 0;
		long pipelineStart = 0;
		int serviceIdx = -1;
		boolean interrupted = false;

		// poll every POLL_INTERVAL, sleep in between
		while (live) {
			if (job.getJobStatus().getPipelineState() == PipelineState.RUNNING) {
				// check pipeline time
				if (serviceIdx >= 0
						&& System.nanoTime() - pipelineStart > toNanoSeconds(PIPELINE_TIMEOUT)) {
					executor.scheduleForTermination();
					live = false;
					interrupted = true;
				}

				// start timing this service
				if (job.getJobStatus().getCurrentServiceIndex() != serviceIdx) {
					if (serviceIdx < 0)
						pipelineStart = System.nanoTime();
					serviceStart = System.nanoTime();
					serviceIdx = job.getJobStatus().getCurrentServiceIndex();
				}
				// check service time
				else {
					if (System.nanoTime() - serviceStart > toNanoSeconds(SERVICE_TIMEOUT)) {
						executor.scheduleForTermination();
						live = false;
						interrupted = true;
					}
				}
			}

			// PipelineExecution has not yet started
			else if (job.getJobStatus().getPipelineState() == PipelineState.NEW) {
				;
			}

			// PipelineExecution has errored/reached a final state
			else {
				live = false;
			}

			if (live) {
				Thread.sleep(POLL_INTERVAL);
			}
		}

		// Thread should be stopping, wait for it to finish
		t.join(JOIN_TIMEOUT);

		if (interrupted) {
			return new PipelineExecutionTimeoutError(serviceIdx,
					toMilliSeconds(System.nanoTime() - pipelineStart));
		} else {
			return null;
		}

	}

}
