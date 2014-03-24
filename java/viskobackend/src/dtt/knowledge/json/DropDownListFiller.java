package dtt.knowledge.json;

import com.hp.hpl.jena.query.ResultSet;

/***************************************************
 * DropDownListFiller is a wrapper class to
 * assist the InterfacePopulationAdapter class with
 * transforming multiple ResultSets to JSON.
 * 
 * @author Juan Ramirez
 ***************************************************/
public class DropDownListFiller {

	private ResultSet visualizationAbstractions;
	private ResultSet viewerSets;
	private ResultSet inputFormats;
	private ResultSet inputDataTypes;
	private ResultSet toolkits;
	
	/**********************************************
	 * Default constructor. Set all ResultSets
	 * to Null.
	 *********************************************/
	public DropDownListFiller(){
		visualizationAbstractions = null;
		viewerSets = null;
		inputFormats = null;
		inputDataTypes = null;
		toolkits = null;
	}
	
	/*******************************************************************
	 * Contructor that allows the ResultSets of the DropDownListFiller
	 * class to set as a unit.
	 * @param visualizationAdapters The ResultSet for visualization abstractions.
	 * @param viewerSets The ResultSet for viewer sets.
	 * @param inputFormats The ResultSet for input formats.
	 * @param inputDataTypes The ResultSet for input data types.
	 * @param toolkits The ResultSet for tool kits.
	 ******************************************************************/
	public DropDownListFiller(ResultSet visualizationAdapters, ResultSet viewerSets, ResultSet inputFormats, ResultSet inputDataTypes, ResultSet toolkits){
		this.visualizationAbstractions = visualizationAdapters;
		this.viewerSets = viewerSets;
		this.inputFormats = inputFormats;
		this.inputDataTypes = inputDataTypes;
		this.toolkits = toolkits;
	}
	
	/***************************************************************************
	 * Sets the ResultSet for visualization abstractions.
	 * @param visualizationAdapters The ResultSet for visualization abstractions.
	 ***************************************************************************/
	public void setVisualizationAdapters(ResultSet visualizationAdapters){
		this.visualizationAbstractions = visualizationAdapters;
	}
	
	/***********************************************************
	 * Sets the ResultSet for viewer sets.
	 * @param viewerSets The ResultSet for viewer sets.
	 ***********************************************************/
	public void setViewerSets(ResultSet viewerSets){
		this.viewerSets = viewerSets;
	}
	
	/***********************************************************
	 * Sets the ResultSet for input formats.
	 * @param inputFormats The ResultSet for input formats.
	 ***********************************************************/
	public void setInputFormats(ResultSet inputFormats){
		this.inputFormats = inputFormats;
	}
	
	/***********************************************************
	 * Sets the ResultSet for input data types.
	 * @param inputDataTypes The ResultSet for input data types.
	 ***********************************************************/
	public void setInputDataTypes(ResultSet inputDataTypes){
		this.inputDataTypes = inputDataTypes;
	}
	
	/***********************************************************
	 * Sets the ResultSet for toolkits.
	 * @param toolkits The ResultSet for toolkits.
	 **********************************************************/
	public void setToolkits(ResultSet toolkits){
		this.toolkits = toolkits;
	}
	
	/**********************************************************
	 * Gets the ResultSet for visualization abstractions.
	 * @return A ResultSet for visualization abstractions.
	 *********************************************************/
	public ResultSet getVisualizationAbstractions(){
		return this.visualizationAbstractions;
	}
	
	/***********************************************************
	 * Gets the ResultSet for viewer sets.
	 * @return A ResultSet for viewer sets.
	 ***********************************************************/
	public ResultSet getViewerSets(){
		return this.viewerSets;
	}
	
	/**********************************************************
	 * Gets the ResultSet for input formats.
	 * @return A ResultSet for input formats.
	 **********************************************************/
	public ResultSet getInputFormats(){
		return this.inputFormats;
	}
	
	/*********************************************************
	 * Gets the ResultSet for input data types.
	 * @return A ResultSet for input data types.
	 *********************************************************/
	public ResultSet getInputDataTypes(){
		return this.inputDataTypes;
	}
	
	/********************************************************
	 * Gets the ResultSet for tool kits.
	 * @return A ResultSet for tool kits.
	 ********************************************************/
	public ResultSet getToolkits(){
		return this.toolkits;
	}
	
	
}
