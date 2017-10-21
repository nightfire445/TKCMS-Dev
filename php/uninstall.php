<?php
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

?>