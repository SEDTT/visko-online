<?php
require_once __DIR__ . '/../ConfigurationManager.php';

/**
 * Class for exceptions thrown by Managers
 * @author awknaust
 *
 */
class ManagerException extends Exception{}

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

	public function getConnection(){
		return $this->connection;
	}
	
	public function handlePrepareError($conn){
		throw new ManagerException('Failed to prepare a statement;' . $conn->error);
	}
	
	public function handleExecuteError($stmt){
		throw new ManagerException('Failed to execute a statement;' . $stmt->error);
	}

	public function __destruct(){
		$conn = $this->getConnection();
		$conn->close();
	}

	//abstract protected function createTables(); 
}
