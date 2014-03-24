package dtt.visualization.responses;

import java.util.ArrayList;
import java.util.List;

import edu.utep.trustlab.visko.execution.PipelineExecutorJob;

/**
 * Relies on implicit Gson serialization for communication.
 * @author awknaust
 *
 */
public class PipelineStatusResponse extends VisualizationResponse {

	private List<PipelineStatus> statuses;
	
	public PipelineStatusResponse(){
		super();
		this.statuses = new ArrayList<PipelineStatus>();
	}
	
	public void addStatus(int id, PipelineExecutorJob job){
		this.statuses.add(new PipelineStatus(id, job));
	}
}
