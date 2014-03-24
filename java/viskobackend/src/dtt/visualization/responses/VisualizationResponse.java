package dtt.visualization.responses;

import java.util.ArrayList;
import java.util.List;

import dtt.visualization.errors.VisualizationError;

public abstract class VisualizationResponse {

	@SuppressWarnings("unused")
	private String type;
	protected List<VisualizationError> errors;

	public VisualizationResponse(){
		this.type = this.getClass().getSimpleName();
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
