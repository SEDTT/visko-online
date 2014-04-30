<?php
require_once __DIR__ . '/../ViskoVisualizer.php';
require_once __DIR__ . '/../ViskoPipelineSet.php';
require_once __DIR__ . '/../ViskoPipelineStatus.php';

/**
 * Test ViskoVisualizer class.
 *
 * Testing requires that viskobackend be running (and working)
 * @author MariannaPena & JuanRamirez
 *
 */
class ViskoVisualizerTest extends PHPUnit_Framework_TestCase{

	const QUERY_ONE_ID = 1;
	
	public function testGeneratePipelines(){
	
		//create a functioning query with the appropriate input data url.
		$vquery = new ViskoQuery();
		$vquery->setQueryText('PREFIX views http://openvisko.org/rdf/ontology/visko-view.owl#
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
		
		
		$viskoVisualizer = new ViskoVisualizer();
		$viskoPipelineSet = new ViskoPipelineSet();
		
		$array = $viskoVisualizer->generatePipelines($vquery);
		$viskoPipelineSet = $array[0];
		
		$array = $viskoPipelineSet->getPipelines();
		
		$count = 0;
		foreach($array as $val){
			$count++;
		}
		$this->assertEquals(24, $count);
		
	}
	
	public function testExecutePipeline(){
	
		//create a functioning query with the appropriate input data url.
		$vquery = new ViskoQuery();
		$vquery->setQueryText('PREFIX views http://openvisko.org/rdf/ontology/visko-view.owl#
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
		
		$viskoVisualizer = new ViskoVisualizer();
		
		$array = $viskoVisualizer->generatePipelines($vquery);
		$viskoPipelineSet = $array[0];
		
		$viskoPipeline = $viskoPipelineSet->getPipelines();
		
		$array = $viskoVisualizer->executePipeline(305,$vquery,$viskoPipeline[0]);

		$this->assertEquals(true, $array[0]->getCompletedNormally());
		
	}
}
