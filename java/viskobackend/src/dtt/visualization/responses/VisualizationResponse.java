package dtt.visualization.responses;

import java.util.ArrayList;
import java.util.List;

import dtt.visualization.errors.VisualizationError;
import edu.utep.trustlab.visko.planning.pipelines.PipelineSet;

public abstract class VisualizationResponse {

	
	protected List<VisualizationError> errors;

	public VisualizationResponse(){
		this.errors = new ArrayList<VisualizationError>();
	}	
	
	/**
	 * Add an error to this response's list of errors.
	 * @param e
	 */
	public void addError(VisualizationError e){
		this.errors.add(e);
	}
	
	/**
	 * Get this responses list of errors.
	 * @return
	 */
	public List<VisualizationError> getErrors(){
		return this.errors;
	}
}
