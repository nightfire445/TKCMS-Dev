<?php
require "./connect.php";

try{

$create_user = 		"CREATE TABLE IF NOT EXISTS user (
                  	username varchar(50) PRIMARY KEY,
                  	salt varchar(100) NOT NULL,
                  	salted_password varchar(100) NOT NULL
                	) COLLATE utf8_unicode_ci;";


$create_vendor =	"CREATE TABLE IF NOT EXISTS vendor (	
					vendor_id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					order_position int(4) NOT NULL,
					name varchar(500),
					description varchar(500),
					deployed bit NOT NULL
					) COLLATE utf8_unicode_ci;";

$create_menu =		"CREATE TABLE IF NOT EXISTS menu (
					menu_id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					visible bit NOT NULL,
					menu_url nvarchar(2083) NOT NULL,
					vendor_FK INT(5) UNSIGNED NOT NULL,
					FOREIGN KEY (vendor_FK) REFERENCES vendor (vendor_id)
					) COLLATE utf8_unicode_ci;";


$create_price = 	"CREATE TABLE IF NOT EXISTS product (
					product_id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					price decimal(5,2) NOT NULL,
					description varchar(500),
					menu_FK INT(5) UNSIGNED NOT NULL,
					FOREIGN KEY (menu_FK) REFERENCES menu (menu_id)
					) COLLATE utf8_unicode_ci;";

$create_image =		"CREATE TABLE IF NOT EXISTS image (
					image_id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					image_url nvarchar(2083) NOT NULL,
					vendor_FK INT(5) UNSIGNED NOT NULL,
					FOREIGN KEY (vendor_FK) REFERENCES vendor (vendor_id)
					) COLLATE utf8_unicode_ci;";

$create_metadata_image =	"CREATE TABLE IF NOT EXISTS metadata_image (
							alt_text varchar(100),
							vendor_FK INT(5) UNSIGNED NOT NULL,
							image_FK INT(5) UNSIGNED NOT NULL,
							FOREIGN KEY (image_FK) REFERENCES image (image_id),
							FOREIGN KEY (vendor_FK) REFERENCES vendor (vendor_id)
							) COLLATE utf8_unicode_ci;";


 $result_0 = $dbconn->query($create_user);
 $result_1 = $dbconn->query($create_vendor);
 $result_2 = $dbconn->query($create_menu);
 $result_3 = $dbconn->query($create_price);
 $result_4 = $dbconn->query($create_image);
 $result_5 = $dbconn->query($create_metadata_image);
}
catch (Exception $e){
    echo "Error: " . $e->getMessage();
}

?>