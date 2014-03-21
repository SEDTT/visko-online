package dtt.visualization;

import edu.utep.trustlab.visko.planning.pipelines.Pipeline;
import edu.utep.trustlab.visko.planning.pipelines.PipelineSet;

/**
 * Bind a pipeline to an ID for deserializing from the JSON interface.
 * @author awknaust
 */
public class IdentifiedPipeline extends Pipeline{

	private static final long serialVersionUID = -6721348464168529366L;
	private int id;
	
	public IdentifiedPipeline(String aViewerURI, String aViewURI,
			PipelineSet parent) {
		super(aViewerURI, aViewURI, parent);
	}
	
	public void setID(int id){
		this.id = id;
	}
	
	public int getID(){
		return this.id;
	}
}