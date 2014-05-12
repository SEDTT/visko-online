<?php
require_once __DIR__ . '/../ConfigurationManager.php';

/**
 * Class for exceptions thrown by Managers
 *
 * @author awknaust
 *        
 */
class ManagerException extends Exception {
}

/**
 * The boss class for Manager objects.
 * Any code that is used across all of them should be put here, especially related to establishing the database connection and creating errors, which could be performed more robustly in the future.
 *
 * @author awknaust
 *        
 */
abstract class Manager {
	private $connection;

	public function __construct($mysqlHost = null, $mysqlUser = null, $mysqlPassword = null, $mysqlDB = null) {
		if ($mysqlDB == null)
			$this->initDefault ();
		else {
			$this->connection = new mysqli ( $mysqlHost, $mysqlUser, $mysqlPassword, $mysqlDB );
		}
	}
	
	/* Build a database connection from the configuration options */
	protected function initDefault() {
		$cfgMgr = new ConfigurationManager ();
		$conn = new mysqli ( $cfgMgr->getMysqlHost (), $cfgMgr->getMysqlUser (), $cfgMgr->getMysqlPassword (), $cfgMgr->getMysqlDatabase () );
		$this->connection = $conn;
	}

	public function getConnection() {
		return $this->connection;
	}

	/**
	 * Perform some action (logging, etc) for a mysqli error while preparing a statement.
	 *
	 * @param unknown $conn        	
	 * @throws ManagerException
	 */
	public function handlePrepareError($conn) {
		throw new ManagerException ( 'Failed to prepare a statement;' . $conn->error );
	}

	/**
	 * Perform some action (logging, etc) for a mysqli error while executing a statement.
	 *
	 * @param unknown $conn        	
	 * @throws ManagerException
	 */
	public function handleExecuteError($stmt) {
		throw new ManagerException ( 'Failed to execute a statement;' . $stmt->error );
	}

	public function __destruct() {
		$conn = $this->getConnection ();
		$conn->close ();
	}
	
	// abstract protected function createTables();
}
