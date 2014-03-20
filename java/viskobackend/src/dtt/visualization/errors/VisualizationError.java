package dtt.visualization.errors;

/**
 * Errors that will get rolled into responses and serialized into JSON.
 * 
 * The name of any subclass should give a good indication of its meaning. An
 * additional message should be provided for more detail. These are automatically
 * serialized by Gson because they are so simple.
 * 
 * I.e. they will look like
 * {
 * 	"message" : message
 * 	"type" : class_name
 * }
 * 
 * @author awknaust
 *
 */
public class VisualizationError{

	protected String message;
	protected String type;
	
	public VisualizationError(String message){
		this.type = this.getClass().getSimpleName();
		this.message = message;
	}
	
	public String getMessage(){
		return this.message;
	}

}
