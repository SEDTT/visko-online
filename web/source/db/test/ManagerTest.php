<?php

/**
* Run with phpunit --configuration files/dbconfig.xml *ManagerTest
* Or substitute dbconfig with a dbconfig.xml for your specific database
* The database should be set up with structure before running any tests, but
* tables should be empty!
*
* @see http://phpunit.de/manual/current/en/database.html
* @author awknaust
*/
abstract class ManagerTest extends PHPUnit_Extensions_Database_TestCase
{
    // only instantiate pdo once for test clean-up/fixture load
    static private $pdo = null;

    // only instantiate PHPUnit_Extensions_Database_DB_IDatabaseConnection once per test
    private $conn = null;

    final public function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                self::$pdo = new PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_DBNAME']);
        }

        return $this->conn;
    }
    /** Hack to truncate despite foreign keys */
    public function getSetUpOperation()
    {
        $cascadeTruncates = true; // If you want cascading truncates, false otherwise. If unsure choose false.

        return new \PHPUnit_Extensions_Database_Operation_Composite(array(
            new TruncateOperation($cascadeTruncates),
            \PHPUnit_Extensions_Database_Operation_Factory::INSERT()
        ));
    }

	 /**
	 * Create a dataset from a mysqlfile. 
	 *
	 * @param string $filename the name of the dataset as a file
	 */
	 protected function dataSetFromFile($filename){
	 	$path =  __DIR__ . '/files/'. $filename . '.xml'; 
	 	return $this->createMySQLXMLDataSet($path);
	 }
	 
	 /**
	  * Compare an actual database table with an expected table from a dataset
	  *
	  * @param string $tableName name of table to check.
	  * @param string $fileName filename of dataset
	  */
	 protected function compareTable($tableName, $fileName){
	 	$queryTable = $this->getConnection()->createQueryTable(
	 			$tableName, 'SELECT * FROM ' . $tableName
	 	);
	 
	 	$expectedTable = $this->dataSetFromFile($fileName)->getTable($tableName);
	 
	 	$this->assertTablesEqual($expectedTable, $queryTable);
	 }
}

/**
 * Disables foreign key checks temporarily.
 */
class TruncateOperation extends \PHPUnit_Extensions_Database_Operation_Truncate
{
    public function execute(\PHPUnit_Extensions_Database_DB_IDatabaseConnection $connection, 
    	\PHPUnit_Extensions_Database_DataSet_IDataSet $dataSet)
    {
        $connection->getConnection()->query("SET foreign_key_checks = 0");
        parent::execute($connection, $dataSet);
        $connection->getConnection()->query("SET foreign_key_checks = 1");
    }
}
