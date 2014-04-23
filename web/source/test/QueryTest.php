<?php
require_once __DIR__ . '/../Query.php';
require_once __DIR__ . '/../history/QueryError.php';

/**
 * Test Query class.
 * 
 * Testing requires that viskobackend be running (and working)
 * @author awknaust
 *
 */
class QueryTest extends PHPUnit_Framework_TestCase{

	public function testConstructor(){
		$userID = 1;
		$queryText = "snakes on a plane";
		$targetFormatURI = "snakes.com";
		$targetTypeURI = "bananas.com";
		$viewURI = "myspace.com";
		$viewerSetURI = "lol.com#me";
		$artifactURL = "imgur.com";
		$parameterBindings = ['a' => 'b'];
		$dateSubmitted = new DateTime();
		$id = 17;

		$q = new Query(
			$userID,
			$queryText,
			$targetFormatURI,
			$targetTypeURI,
			$viewURI,
			$viewerSetURI,
			$artifactURL,
			$parameterBindings,
			$dateSubmitted,
			$id
		);

		$this->assertEquals($userID,$q->getUserID());
		$this->assertEquals($id, $q->getID());
		$this->assertEquals($queryText, $q->getQueryText());
		$this->assertEquals($targetFormatURI, $q->getTargetFormatURI());
		$this->assertEquals($targetTypeURI, $q->getTargetTypeURI());
		$this->assertEquals($viewURI, $q->getViewURI());
		$this->assertEquals($viewerSetURI, $q->getViewerSetURI());
		$this->assertEquals($parameterBindings, $q->getParameterBindings());
		$this->assertEquals($dateSubmitted, $q->getDateSubmitted());
		$this->assertEquals($artifactURL, $q->getArtifactURL());
	}

	/**
	* TODO this is a bad test... depends on state of knowledege base.
	*/
	public function testSubmitGoodQuery(){
		$qid = 17;
		$q1 = 'PREFIX views http://openvisko.org/rdf/ontology/visko-view.owl#
			PREFIX formats http://openvisko.org/rdf/pml2/formats/
			PREFIX types http://rio.cs.utep.edu/ciserver/ciprojects/CrustalModeling/CrustalModeling.owl#
			PREFIX visko http://visko.cybershare.utep.edu:5080/visko-web/registry/module_webbrowser.owl#
			PREFIX params http://visko.cybershare.utep.edu:5080/visko-web/registry/grdcontour.owl#
			VISUALIZE http://visko.cybershare.utep.edu:5080/visko-web/test-data/gravity/gravityDataset.txt
			AS views:2D_ContourMap IN visko:web-browser
			WHERE
			FORMAT = formats:SPACESEPARATEDVALUES.owl#SPACESEPARATEDVALUES
			AND TYPE = types:d19';

		$query = new Query(1, $q1);
		$query->setID($qid);

		//submit!
		$pipes = $query->submit();
		
		//generates 24 pipelines with default knowledge base
		$this->assertEquals(24, count($pipes));

		//they must all stem from this query.
		foreach ($pipes as $pipe){
			$this->assertEquals($qid, $pipe->getQueryID());
		
		}

		$this->markTestIncomplete('Test individual pipelines/query updating?');
	}


	/**
	* @expectedException SyntaxError
	*/
	public function testSubmitSyntaxError(){
		//NOTE 'VIASUALIZE'
		$q2 = 'PREFIX views http://openvisko.org/rdf/ontology/visko-view.owl#
			PREFIX formats http://openvisko.org/rdf/pml2/formats/
			PREFIX types http://rio.cs.utep.edu/ciserver/ciprojects/CrustalModeling/CrustalModeling.owl#
			PREFIX visko http://visko.cybershare.utep.edu:5080/visko-web/registry/module_webbrowser.owl#
			PREFIX params http://visko.cybershare.utep.edu:5080/visko-web/registry/grdcontour.owl#
			VIASUALIZE http://visko.cybershare.utep.edu:5080/visko-web/test-data/gravity/gravityDataset.txt
			AS views:2D_ContourMap IN visko:web-browser
			WHERE
			FORMAT = formats:SPACESEPARATEDVALUES.owl#SPACESEPARATEDVALUES
			AND TYPE = types:d19';
		
		$qid = 17;
		
		$query = new Query(1, $q2);
		$query->setID($qid);
		
		//submit and get error!
		$pipes = $query->submit();
	}

	/**
	* @expectedException NoPipelineResultsError
	*/
	public function testSubmitEmptyError(){
		$q3 = 'PREFIX views http://openvisko.org/rdf/ontology/visko-view.owl#
			PREFIX formats http://openvisko.org/rdf/pml2/formats/
			PREFIX types http://rio.cs.utep.edu/ciserver/ciprojects/CrustalModeling/CrustalModeling.owl#
			PREFIX visko http://visko.cybershare.utep.edu:5080/visko-web/registry/module_webbrowser.owl#
			PREFIX params http://visko.cybershare.utep.edu:5080/visko-web/registry/grdcontour.owl#
			VISUALIZE http://visko.cybershare.utep.edu:5080/visko-web/test-data/gravity/gravityDataset.txt
			AS views:2D_ContourMap IN visko:paraview
			WHERE
			FORMAT = formats:SPACESEPARATEDVALUES.owl#SPACESEPARATEDVALUES
			AND TYPE = types:d19';
		
		$qid = 17;
		
		$query = new Query(1, $q3);
		$query->setID($qid);
		
		//submit and get error!
		$pipes = $query->submit();
	}
	
	/**
	 * @expectedException MalformedURIError 
	 */
	public function testSubmitBadURIError(){
		$qid = 17;
		//NOTE htp://
		$q1 = 'PREFIX views htp://openvisko.org/rdf/ontology/visko-view.owl#
			PREFIX formats http://openvisko.org/rdf/pml2/formats/
			PREFIX types http://rio.cs.utep.edu/ciserver/ciprojects/CrustalModeling/CrustalModeling.owl#
			PREFIX visko http://visko.cybershare.utep.edu:5080/visko-web/registry/module_webbrowser.owl#
			PREFIX params http://visko.cybershare.utep.edu:5080/visko-web/registry/grdcontour.owl#
			VISUALIZE http://visko.cybershare.utep.edu:5080/visko-web/test-data/gravity/gravityDataset.txt
			AS views:2D_ContourMap IN visko:web-browser
			WHERE
			FORMAT = formats:SPACESEPARATEDVALUES.owl#SPACESEPARATEDVALUES
			AND TYPE = types:d19';

		$query = new Query(1, $q1);
		$query->setID($qid);

		//submit!
		$pipes = $query->submit();
		
		$this->markTestIncomplete('Not yet implemented');
	}

}
