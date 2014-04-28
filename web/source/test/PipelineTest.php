<?php
require_once __DIR__ . '/../Pipeline.php';
require_once __DIR__ . '/../Query.php';

/**
 * Test Pipeline class.
 *
 * Testing execution requires that viskobackend be running (and working)
 * @author awknaust
 *
 */
class PipelineTest extends PHPUnit_Framework_TestCase{

	/**
	* @dataProvider constructorProvider
	*/
	public function testConstructor($queryID, $viewURI, $viewerURI, $toolkit, 
		$requiresInputURL, $outputFormat, $services, $viewerSets, $id){
		
		$p = new Pipeline(
			$queryID,
			$viewURI,
				$viewerURI,
				$toolkit,
				$requiresInputURL,
				$outputFormat,
				$services,
				$viewerSets,
				$id
		);
		
		$this->assertEquals($queryID, $p->getQueryID());
		$this->assertEquals($viewURI, $p->getViewURI());
		$this->assertEquals($viewerURI, $p->getViewerURI());
		$this->assertEquals($toolkit, $p->getToolkitURI());
		$this->assertEquals($id, $p->getID());
		$this->assertEquals($outputFormat, $p->getOutputFormat());
		$this->assertEquals($requiresInputURL, $p->getRequiresInputURL());
		
		$this->assertEquals($services, $p->getServices());
		$this->assertEquals($viewerSets, $p->getViewerSets());
		
	}

	/**
	* Data provider for constructor test.
	* Case #0 is All valid strings for constructor variables
	* Case #1 is all null values for constructor variables
	* Case #2 is all null values except queryID
	*/
	public function constructorProvider(){
		return array(
			array(1, 'http://visko.com#viewer', 'http://visko.com#viewer', 
				'http://visko.com#toolkit', true, 'http://visko.com#format',
				array('http://visko.com#service1', 'http://visko.com#service2'), 
				array('http://visko.com#viewer'), 1
			),
			array(null, null, null, null, null, null, null, null, null),
			array(1, null, null, null, null, null, null, null, null)
		);
	}
		
	/**
	 * Test Pipeline Execution on a pipeline with a query that has a bad
	 * inputdataurl/artifact url.
	 *
	 * @group ExecuteTest
	 * @dataProvider urlexceptExecuteProvider
	 * @expectedException InputDataURLError
	 */
	public function testExecuteInputDataURLError($query, $pipeline){
		
		$ps = $pipeline->execute($query);
	}

	/**
	* Test Pipeline execution on pipelines that should be successful and
	* result in a visualization.
	* 
	* @group ExecuteTest
	* @dataProvider successfulExecuteProvider
	*/
	public function testExecuteSuccessful($query, $pipeline){

		$ps = $pipeline->execute($query);
		
		//cannot easily test specific URL because they are random
		$this->assertTrue($ps->getResultURL() != null);
		$this->assertEquals(count($pipeline->getServices()), $ps->getLastServiceIndex());
		$this->assertTrue($ps->completedNormally());
	}
	
	/**
	 * Test Pipeline execution on pipelines that have a service that times out.
	 *
	 * @group ExecuteTest
	 * @dataProvider timeoutExecuteProvider 
	 * @expectedException ServiceTimeoutError
	 */
	public function testExecuteServiceTimeoutError($query, $pipeline){
		//how to test this???
		$this->markTestIncomplete('Not yet implemented');
	}
	
	/**
	 * Test Pipeline execution on pipelines that have a service that fails to execute.
	 *
	 * @group ExecuteTest
	 * @dataProvider executeExecuteProvider 
	 * @expectedException ServiceExecutionError
	*/
	public function testExecuteServiceExecutionError($query, $pipeline){
		//There is a way to test this by sending a query
		//with missing parameters for a pipeline, but requires work on ViskoQuery
		// class first (to send parameters)
		$this->markTestIncomplete('Not yet implemented');
	}

	public function urlexceptExecuteProvider(){
		//NOTE datasetdoesntexist.txt is an invalid input url.
		$q = new Query(1, 'PREFIX views http://openvisko.org/rdf/ontology/visko-view.owl#
			PREFIX formats http://openvisko.org/rdf/pml2/formats/
			PREFIX types http://rio.cs.utep.edu/ciserver/ciprojects/CrustalModeling/CrustalModeling.owl#
			PREFIX visko http://visko.cybershare.utep.edu:5080/visko-web/registry/module_webbrowser.owl#
			PREFIX params http://visko.cybershare.utep.edu:5080/visko-web/registry/grdcontour.owl#
			VISUALIZE http://visko.cybershare.utep.edu:5080/visko-web/test-data/gravity/datasetdoesntexist.txt
			AS views:2D_ContourMap IN visko:web-browser
			WHERE
			FORMAT = formats:SPACESEPARATEDVALUES.owl#SPACESEPARATEDVALUES
			AND TYPE = types:d19'
		);
		
		$q->setID(1);
		$p = $this->getPipelineOne(1, 99);

		return array(array($q, $p));
	}

	public function successfulExecuteProvider(){
		$qid = 1;

		//create a functioning query with the appropriate input data url.
		$q = new Query(1, 'PREFIX views http://openvisko.org/rdf/ontology/visko-view.owl#
			PREFIX formats http://openvisko.org/rdf/pml2/formats/
			PREFIX types http://rio.cs.utep.edu/ciserver/ciprojects/CrustalModeling/CrustalModeling.owl#
			PREFIX visko http://visko.cybershare.utep.edu:5080/visko-web/registry/module_webbrowser.owl#
			PREFIX params http://visko.cybershare.utep.edu:5080/visko-web/registry/grdcontour.owl#
			VISUALIZE http://visko.cybershare.utep.edu:5080/visko-web/test-data/gravity/gravityDataset.txt
			AS views:2D_ContourMap IN visko:web-browser
			WHERE
			FORMAT = formats:SPACESEPARATEDVALUES.owl#SPACESEPARATEDVALUES
			AND TYPE = types:d19'
		);
		
		$q->setID($qid);
		$p = $this->getPipelineOne($qid, 1);	
		
		return array(array($q, $p));
	}
	
	public function timeoutExecuteProvider(){
		return array();
	}

	public function executeExecuteProvider(){
		return array();
	}
	/**
	 * Get the first Pipeline from the pipelineset genereated by QueryOne
	 * which should be executable with a result.
	 * 
	 * @param int $qid the id of the query that generated this pipeline.
	 * @param int $id the id of the pipeline to execute
	 * @return Pipeline
	 */
	private function getPipelineOne($qid, $id){
		$services = 	[
		"http://visko.cybershare.utep.edu:5080/visko-web/registry/module_gmt.owl#surface",
		"http://visko.cybershare.utep.edu:5080/visko-web/registry/module_gmt.owl#grdcontour",
		"http://visko.cybershare.utep.edu:5080/visko-web/registry/module_gs.owl#ps2pdf"
				];
		$viewerSets = [
          "http://visko.cybershare.utep.edu:5080/visko-web/registry/module_webbrowser.owl#web-browser"
        ];
		
		$viewURI = "http://openvisko.org/rdf/ontology/visko-view.owl#2D_ContourMap";
		$viewerURI =  "http://visko.cybershare.utep.edu:5080/visko-web/registry/module_webbrowser.owl#web-browser-pdf-viewer";
		$toolkit = "http://visko.cybershare.utep.edu:5080/visko-web/registry/module_gmt.owl#gmt";
		$outputFormat = "http://openvisko.org/rdf/pml2/formats/PDF.owl#PDF";
		$requiresInputURL = true;
		
		$p = new Pipeline(
				$qid,
				$viewURI,
				$viewerURI,
				$toolkit,
				$requiresInputURL,
				$outputFormat,
				$services,
				$viewerSets
		);
		
		$p->setID($id);
		return $p;
	}
	
	

}
