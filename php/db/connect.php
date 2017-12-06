
<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
$url = getenv('JAWSDB_MARIA_URL');
if($url != FALSE){

	$dbparts = parse_url($url);
	$connection_result;
	$hostname = $dbparts['host'];
	$username = $dbparts['user'];
	$password = $dbparts['pass'];
	$database = ltrim($dbparts['path'],'/');
	$error;



	try {
	    $dbconn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
	    // set the PDO error mode to exception
	    $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $connection_result = TRUE;
	    }
	catch(PDOException $e)
	    {
	     $connection_result = FALSE;
	        $error = $e->getMessage();
	    }



}
else{
	require_once "config.php";
	$hostname =  $config['DB_HOST'];
	$database = $config['DB_NAME'];
	try {
	    $dbconn = new PDO("mysql:host=$hostname;dbname=$database", $config['DB_USERNAME'], $config['DB_PASSWORD']);
	    // set the PDO error mode to exception
	    $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $connection_result = TRUE;
	    }
	catch(PDOException $e)
	    {
	     $connection_result = FALSE;
	        $error = $e->getMessage();
	        var_dump($error);
	        die();
	    }

}





?>