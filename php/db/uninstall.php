<?php
//only cli can run this script for security.
$sapi_type = php_sapi_name();
if (substr($sapi_type, 0, 3) == 'cli') {

	if( !isset($dbconn) ){
		require "./connect.php";
	}

	$drop_tables = "DROP TABLE IF EXISTS metadata_image, image, product, menu, vendor, user;";

	try{
		$result = $dbconn->query($drop_tables);
		echo "tables uninstalled\n";
	}
	catch (Exception $e){
		echo "Error: " . $e->getMessage();
	}
	
    
} else {
    die('cli only');
}



?>