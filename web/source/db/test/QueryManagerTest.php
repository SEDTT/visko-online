<?php
require_once 'ManagerTest.php';
require_once __DIR__ . '/../QueryManager.php';
require_once __DIR__ . '/../../Query.php';

/**
* Tests the QueryManager class using DBTest cases.
*
* @author awknaust
*/
class QueryManagerTest extends ManagerTest{
	private $queryManager;

	/** Create the QueryManager instance from the testing configuration */
	public function setUp(){
		parent::setUp();
		$this->queryManager = new QueryManager(
			$GLOBALS['DB_HOST'],
			$GLOBALS['DB_USER'],
			$GLOBALS['DB_PASSWD'],
			$GLOBALS['DB_DBNAME']
		);
	}

	/**
	 * Test whether a query without parameters can be successfully inserted.
	 * 
	* @group InsertTest
	*
	*/
	public function testInsertQueryNoParameters(){
		$q = new Query(
			1,
			'This is some fake VSQL text',
			'http://visko.com#targetformat',
			'http://visko.com#targettype',
			'http://visko.com#view',
			'http://visko.com#viewer',
			'http://datasets.com/datasetone.dat',
			[],
			new DateTime('2012-07-08 11:14:15')
		);

		//perform the insert
		$qid = $this->queryManager->insertQuery($q);
		$this->assertNotNull($qid);
		$this->assertEquals($qid, $q->getID());
		
		//should create one new query
		$this->compareTable('Queries', 'query_insert_one');
		
		//should create zero new QueryParameters
		$this->compareTable('QueryParameters', 'query_insert_one');
	}
	


	/**
	 * Test whether a query referencing a non-existent user fails to insert.
	 * 
	* @depends testInsertQueryNoParameters
	* @expectedException ManagerException
	* @group InsertTest
	*
	*/
	public function testInsertQueryBadUser(){
		//query references an invalid user id
		$q = new Query(
			2,
			'This is some fake VSQL text',
			'http://visko.com#targetformat',
			'http://visko.com#targettype',
			'http://visko.com#view',
			'http://visko.com#viewer',
			'http://datasets.com/datasetone.dat',
			[],
			new DateTime('2012-07-08 11:14:15')
		);
		
		$qid = $this->queryManager->insertQuery($q);
		
		//should create zero new queries
		$this->compareTable('Queries', 'query_insert_one');
		
		//should create zero new QueryParameters
		$this->compareTable('QueryParameters', 'query_insert_one');
		
	}

	/**
	 * Test whether a query with several parameters successfully inserts.
	 * 
	 * @depends testInsertQueryNoParameters
	 * @group InsertTest
	 *
	 */
	public function testInsertQueryWithParameters(){
		//query references an invalid user id
		$q = new Query(
				1,
				'This is some fake VSQL text',
				'http://visko.com#targetformat',
				'http://visko.com#targettype',
				'http://visko.com#view',
				'http://visko.com#viewer',
				'http://datasets.com/datasetone.dat',
				[	'http://visko.com#param1' => 'yellow',
					'http://visko.com#param2' => 3
				],
				new DateTime('2012-07-08 11:14:15')
		);
	
		$qid = $this->queryManager->insertQuery($q);
		$this->assertNotNull($qid);
		$this->assertEquals($qid, $q->getID());
		
		//should create one new query row
		$this->compareTable('Queries', 'query_insert_two');
	
		//should create two new query parameters
		$this->compareTable('QueryParameters', 'query_insert_two');
	
	}

	/**
	 * Test whether a query with only query text set successfully inserts.
	 *
	 * @depends testInsertQueryWithParameters
	 * @group InsertTest
	 *
	 */
	public function testInsertQueryNull(){
		//query references an invalid user id
		$q = new Query(
				1,
				'This is some fake VSQL text',
				null,
				null,
				null,
				null,
				null,
				null,
				new DateTime('2012-07-08 11:14:15')
		);
	
		$qid = $this->queryManager->insertQuery($q);
		$this->assertNotNull($qid);
		$this->assertEquals($qid, $q->getID());
		
		//should create one new query row
		$this->compareTable('Queries', 'query_insert_three');
	
		//should create two new query parameters
		$this->compareTable('QueryParameters', 'query_insert_one');
	
	}
	
	
	/**
	 * Test retrieving Query Objects from the database.
	 * 
	 * @dataProvider getQueryProvider
	 */
	public function testGetQuery($query){
		$dbQuery = $this->queryManager->getQueryByID($query->getID());
		
		//assert the query is as expected.
		$this->assertEquals($query->getID(), $dbQuery->getID());
		$this->assertEquals($query->getUserID(), $dbQuery->getUserID());
		$this->assertEquals($query->getViewURI(), $dbQuery->getViewURI());
		$this->assertEquals($query->getQueryText(), $dbQuery->getQueryText());
		$this->assertEquals($query->getViewerSetURI(), $dbQuery->getViewerSetURI());
		$this->assertEquals($query->getArtifactURL(), $dbQuery->getArtifactURL());
		$this->assertEquals($query->getDateSubmitted(), $dbQuery->getDateSubmitted());
		$this->assertEquals($query->getTargetTypeURI(), $dbQuery->getTargetTypeURI());
		$this->assertEquals($query->getTargetFormatURI(), $dbQuery->getTargetFormatURI());
		$this->assertEquals($query->getParameterBindings(), $dbQuery->getParameterBindings());
	}
	
	/**
	 * Test case #0 is a query object without parameters (id 1)
	 * Test case #1 is a query object with parameters (id 8)
	 * 
	 * @return multitype:multitype:Query
	 */
	public function getQueryProvider(){
		$q1 = new Query(1, 
					'PREFIX views http://openvisko.org/rdf/ontology/visko-view.owl# 
PREFIX formats http://openvisko.org/rdf/pml2/formats/ 
PREFIX types http://rio.cs.utep.edu/ciserver/ciprojects/CrustalModeling/CrustalModeling.owl# 
PREFIX visko http://visko.cybershare.utep.edu:5080/visko-web/registry/module_webbrowser.owl# 
PREFIX params http://visko.cybershare.utep.edu:5080/visko-web/registry/grdcontour.owl# 
VISUALIZE http://visko.cybershare.utep.edu:5080/visko-web/test-data/gravity/gravityDataset.txt 
AS views:2D_ContourMap 
IN visko:web-browser 
WHERE
	FORMAT = http://openvisko.org/rdf/pml2/formats/SPACESEPARATEDVALUES.owl#SPACESEPARATEDVALUES
	AND TYPE = http://rio.cs.utep.edu/ciserver/ciprojects/CrustalModeling/CrustalModeling.owl#d19
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/psxyz.owl#G = lightgray
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/nearneighbor.owl#R = -109/-107/33/34
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/psxyz.owl#E = 200/30
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/nearneighbor.owl#S = 0.2
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/psxyz.owl#J = x6c
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#plotVariable = z
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map_raster.owl#colorTable = WhiteBlueGreenYellowRed
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/nearneighbor.owl#I = 0.02
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/psxyz.owl#S = o0.1
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/psxyz.owl#R = -109/-107/33/34/-300/-100
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map_raster.owl#lbOrientation = vertical
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/psxyz.owl#W = thinnest
	AND params:Wc = thinnest,black
	AND params:Wa = thinnest,black
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#cnLevelSpacingF = 10
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/surface.owl#I = 0.02
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/surface.owl#C = 0.1
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#font = helvetica
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#cnLinesOn = False
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/surface.owl#R = -109/-107/33/34
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map_raster.owl#font = helvetica
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/surface.owl#T = 0.25
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map_raster.owl#lonVariable = x
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map_raster.owl#plotVariable = z
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#cnFillOn = True
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/psxyz.owl#B = 1/1/50
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#indexOfZ = -1
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/psxy.owl#indexOfY = 1
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#indexOfY = 0
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#indexOfX = 1
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/psxy.owl#indexOfX = 0
	AND params:S = 5
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/XYZDataFieldFilter.owl#indexOfY = 1
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map_raster.owl#indexOfX = 1
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/XYZDataFieldFilter.owl#indexOfZ = 2
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map_raster.owl#indexOfY = 0
	AND params:A = 20
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#lbOrientation = vertical
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map_raster.owl#indexOfZ = -1
	AND params:B = 0.5
	AND params:C = 10
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/grd2xyz.owl#N = 0
	AND params:J = x4c
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/psxy.owl#B = 1
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/grdimage.owl#R = -109/-107/33/34
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map_raster.owl#latVariable = y
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#colorTable = WhiteBlueGreenYellowRed
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/grdimage.owl#T = -200/200/10
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/grd2xyz_esri.owl#N = 0
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/psxy.owl#J = x4c
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/psxy.owl#G = blue
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/XYZDataFieldFilter.owl#indexOfX = 0
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#lonVariable = x
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/psxyz.owl#JZ = 5c
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/psxy.owl#R = -109/-107/33/34
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/grdimage.owl#B = 1
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/grdimage.owl#C = hot
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#latVariable = y
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/grdimage.owl#J = x4c
	AND http://visko.cybershare.utep.edu:5080/visko-web/registry/psxy.owl#S = c0.04c',
					null,
					'http://www.w3.org/2002/07/owl#Thing',
					'http://openvisko.org/rdf/ontology/visko-view.owl#2D_ContourMap',
					'http://visko.cybershare.utep.edu:5080/visko-web/registry/module_webbrowser.owl#web-browser',
					'http://visko.cybershare.utep.edu:5080/visko-web/test-data/gravity/gravityDataset.txt',
					[],
					new DateTime('2014-04-17 17:20:12')
					,1
				);
		
		$q2 = new Query($q1->getID(), $q1->getQueryText(), $q1->getTargetFormatURI(), $q1->getTargetTypeURI(),
				$q1->getViewURI(), $q1->getViewerSetURI(), $q1->getArtifactURL(),
		array(
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/psxyz.owl#G"=>"lightgray",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/nearneighbor.owl#R"=>"-109/-107/33/34",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/psxyz.owl#E"=>"200/30",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/nearneighbor.owl#S"=>"0.2",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/psxyz.owl#J"=>"x6c",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#plotVariable"=>"z",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map_raster.owl#colorTable"=>"WhiteBlueGreenYellowRed",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/nearneighbor.owl#I"=>"0.02",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/psxyz.owl#S"=>"o0.1",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/psxyz.owl#R"=>"-109/-107/33/34/-300/-100",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map_raster.owl#lbOrientation"=>"vertical",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/psxyz.owl#W"=>"thinnest",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/grdcontour.owl#Wc"=>"thinnest,black",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/grdcontour.owl#Wa"=>"thinnest,black",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#cnLevelSpacingF"=>"10",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/surface.owl#I"=>"0.02",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/surface.owl#C"=>"0.1",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#font"=>"helvetica",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#cnLinesOn"=>"False",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/surface.owl#R"=>"-109/-107/33/34",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map_raster.owl#font"=>"helvetica",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/surface.owl#T"=>"0.25",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map_raster.owl#lonVariable"=>"x",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map_raster.owl#plotVariable"=>"z",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#cnFillOn"=>"True",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/psxyz.owl#B"=>"1/1/50",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#indexOfZ"=>"-1",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/psxy.owl#indexOfY"=>"1",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#indexOfY"=>"0",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#indexOfX"=>"1",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/psxy.owl#indexOfX"=>"0",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/grdcontour.owl#S"=>"5",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/XYZDataFieldFilter.owl#indexOfY"=>"1",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map_raster.owl#indexOfX"=>"1",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/XYZDataFieldFilter.owl#indexOfZ"=>"2",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map_raster.owl#indexOfY"=>"0",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/grdcontour.owl#A"=>"20",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#lbOrientation"=>"vertical",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map_raster.owl#indexOfZ"=>"-1",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/grdcontour.owl#B"=>"0.5",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/grdcontour.owl#C"=>"10",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/grd2xyz.owl#N"=>"0",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/grdcontour.owl#J"=>"x4c",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/psxy.owl#B"=>"1",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/grdimage.owl#R"=>"-109/-107/33/34",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map_raster.owl#latVariable"=>"y",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#colorTable"=>"WhiteBlueGreenYellowRed",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/grdimage.owl#T"=>"-200/200/10",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/grd2xyz_esri.owl#N"=>"0",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/psxy.owl#J"=>"x4c",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/psxy.owl#G"=>"blue",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/XYZDataFieldFilter.owl#indexOfX"=>"0",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#lonVariable"=>"x",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/psxyz.owl#JZ"=>"5c",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/psxy.owl#R"=>"-109/-107/33/34",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/grdimage.owl#B"=>"1",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/grdimage.owl#C"=>"hot",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/gsn_csm_contour_map.owl#latVariable"=>"y",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/grdimage.owl#J"=>"x4c",
				"http://visko.cybershare.utep.edu:5080/visko-web/registry/psxy.owl#S"=>"c0.04c",
				"snakes"=>"are the best"
		), new DateTime('2014-04-28 18:41:14'), 8);
		
		return array(
				array($q1),
				array($q2)
		);
		
	}

	/**
	* Setup the Queries, QueryParameters, and Users tables. 
	*/
	public function getDataSet(){
		return $this->dataSetFromFile('query_start'); 
	}
	
	
	
}
