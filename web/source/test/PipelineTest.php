<?php
require_once __DIR__ . '/../Pipeline.php';
require_once __DIR__ . '/../Query.php';

/**
 * Test Pipeline class.
 *
 * Testing requires that viskobackend be running (and working)
 * @author awknaust
 *
 */
class PipelineTest extends PHPUnit_Framework_TestCase{

	const QUERY_ONE_ID = 1;
	
	public function testConstructor(){
		$queryID = 1;
		$viewURI = "myspace.com";
		$viewerURI = "bananas.com";
		$toolkit = "myspace.com#vtk";
		$requiresInputURL = false;
		$outputFormat = "3.com";
		$services = ["service1", "service2"];
		$viewerSets = ["vtk", "paraview"];
		$id = 7;

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
	 * @expectedException InputDataURLError
	 */
	public function testExecuteInputDataURLError(){
		$q = $this->getQueryOneBadInput();
		$p = $this->getPipelineOne(self::QUERY_ONE_ID);

		$ps = $p->execute($q);
	}

	public function testExecuteSuccessful(){
		$q = $this->getQueryOne();
		$p = $this->getPipelineOne(self::QUERY_ONE_ID);

		$ps = $p->execute($q);
		
		//TODO add successful url
		//$this->assertEquals('result.com', $ps->getResultURL());
		$this->markTestIncomplete('Need to run on UTEP network to get actual results');
	}
	
	/**
	 * @expectedException ServiceTimeoutError
	 */
	public function testExecuteServiceTimeoutError(){
		$this->markTestIncomplete('Not yet implemented');
	}
	
	/**
	 * @expectedException ServiceExecutionError
	 */
	public function testExecuteServiceExecutionError(){
		$this->markTestIncomplete('Not yet implemented');
	}

	/**
	 * @return Query a functioning Query object
	 */
	public function getQueryOneBadInput(){
		
		//NOTE datasetdoesntexist.txt
		$q = new Query(1, 'PREFIX views http://openvisko.org/rdf/ontology/visko-view.owl#
			PREFIX formats http://openvisko.org/rdf/pml2/formats/
			PREFIX types http://rio.cs.utep.edu/ciserver/ciprojects/CrustalModeling/CrustalModeling.owl#
			PREFIX visko http://visko.cybershare.utep.edu:5080/visko-web/registry/module_webbrowser.owl#
			PREFIX params http://visko.cybershare.utep.edu:5080/visko-web/registry/grdcontour.owl#
			VISUALIZE http://visko.cybershare.utep.edu:5080/visko-web/test-data/gravity/gravityDataset.txt
			AS views:2D_ContourMap IN visko:web-browser
			WHERE
			FORMAT = formats:SPACESEPARATEDVALUES.owl#SPACESEPARATEDVALUES
			AND TYPE = types:d19',
				null,
				null,
				null,
				null,
				"http://visko.cybershare.utep.edu:5080/visko-web/test-data/gravity/datasetdoesntexist.txt"
		);
		
		$q->setID(self::QUERY_ONE_ID);
		
		return $q;
	}

	/**
	 * @return Query a functioning Query object
	 */
	public function getQueryOne(){
		
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
			AND TYPE = types:d19',
				null,
				null,
				null,
				null,
				"http://visko.cybershare.utep.edu:5080/visko-web/test-data/gravity/gravityDataset.txt"
		);
		
		$q->setID(self::QUERY_ONE_ID);
		
		return $q;
	}
	
	
	/**
	 * Get the first Pipeline from the pipelineset genereated by QueryOne
	 * which should be executable with a result.
	 * 
	 * @param int $id the id of the pipeline to execute
	 * @return Pipeline
	 */
	public function getPipelineOne($id){
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
				self::QUERY_ONE_ID,
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
