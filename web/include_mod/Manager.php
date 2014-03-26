<?php
require_once __DIR__ . '/../source/ConfigurationManager.php';

abstract class Manager{
	private $connection;

	public function __construct(){	
		$this->init();
	}

	/* Build a database connection from the configuration options */
	protected function init(){
		$cfgMgr = new ConfigurationManager();
		$conn = new mysqli(
			$cfgMgr->getMysqlHost(),
			$cfgMgr->getMysqlUser(),
			$cfgMgr->getMysqlPassword(),
			$cfgMgr->getMysqlDatabase()
		);
		$this->connection = $conn;

	}

	protected function getConnection(){
		return $this->connection;
	}
	
	protected function handlePrepareError($conn){
		echo 'Failed to prepare a statement <br>';
		var_dump($conn->error);
	}
	
	protected function handleExecuteError($stmt){
		echo 'Failed to execute a statement <br>';
		var_dump($stmt->error);
	}

	public function __destruct(){
		$conn = $this->getConnection();
		$conn->close();
	}

	//abstract protected function createTables(); 
}
