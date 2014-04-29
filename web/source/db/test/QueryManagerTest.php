<?php
require_once 'ManagerTest.php';
require_once __DIR__ . '/../QueryManager.php';
require_once __DIR__ . '/../../Query.php';

class QueryManagerTest extends ManagerTest{
	private $queryManager;

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


		$qid = $this->queryManager->insertQuery($q);

		$this->markTestIncomplete('Not Yet implemented');
	}


	/**
	* @depends testInsertQueryOne
	* @group InsertTest
	*
	*/
	public function testInsertQueryTwo(){
		$this->markTestIncomplete('Not yet implementd');	
	}



	/**
	* Setup the Queries, QueryParameters, and Users tables. 
	*/
	public function getDataSet(){
		return $this->createMySQLXMLDataSet(__DIR__ . '/files/query_start.xml'); 
	}
}
