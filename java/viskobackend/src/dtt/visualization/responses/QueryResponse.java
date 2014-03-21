package dtt.visualization.responses;

import java.util.ArrayList;
import java.util.List;

import dtt.visualization.errors.VisualizationError;
import edu.utep.trustlab.visko.planning.pipelines.PipelineSet;

/**
 * A Json serializable response from the Query Servlet.
 * 
 * It contains the resulting pipelines from the query (which may be null)
 * and any Visualization errors that occurred while generating the pipelines.
 * Pipelines may be null even though there are no errors, and errors may coexist
 * with pipelines.
 * 
 * @author awknaust
 *
 */
public class QueryResponse extends VisualizationResponse {
	private PipelineSet pipelines;
	
	
	public void setPipelines(PipelineSet pipelines){
		this.pipelines = pipelines;
	}
	
	/**
	 * Get the PipelineSet associated with this response (may be null).
	 * @return
	 */
	public PipelineSet getPipelines(){
		return this.pipelines;
	}
}