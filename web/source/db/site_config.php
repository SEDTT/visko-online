<?PHP
require_once("./include/DBManager.php");

$fgmembersite = new DBManager();

//Provide your database login details here:
//hostname, user name, password, database name and table name
//note that the script will create the table (for example, fgusers in this case)
//by itself on submitting register.php for the first time
$fgmembersite->InitDB(/*hostname*/'earth.cs.utep.edu',
                      /*username*/'cs4311team3sp14',
                      /*password*/'cs4311!cs4311team3sp14',
                      /*database name*/'cs4311team3sp14',
                      /*table name*/'User');
?>