<?php
if( !isset($dbconn) ){
	require "./connect.php";
}


$drop_tables = "DROP TABLE IF EXISTS product, user, vendor, menu, image, metadata_image;";

try{

	$result = $dbconn->query($drop_tables);
}
catch (Exception $e){
	echo "Error: " . $e->getMessage();
}

echo "tables uninstalled\n";

?>