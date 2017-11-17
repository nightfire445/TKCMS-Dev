<?php

function restructureFilesArray($files)
{
    $output = [];
    foreach ($files as $attrName => $valuesArray) {
        foreach ($valuesArray as $key => $value) {
            $output[$key][$attrName] = $value;
        }
    }
    return $output;
}

class Model
{
    public $string; 
    public $vendors;   
    private $dbconn;

    public function __construct(){
        require_once dirname(__FILE__). "/../db/connect.php";
        
        $this->string = "";
        $this->dbconn = $dbconn;
        $this->loadVendors();

    }

    public function loadTemplateFile($filelocation){
        $this->template = $filelocation;
    }

    public function loadVendors(){
    	$get_vendors_query = "SELECT * FROM `vendor`";
        $get_vendors = $this->dbconn->query($get_vendors_query);
    	$this->vendors = $get_vendors->fetchAll();

    	return $this->vendors;
    }

    public function uploadImage($image){
        $uploads_dir = $_SERVER['DOCUMENT_ROOT'] .'/resources';
        if ($image["error"] == UPLOAD_ERR_OK) {
            $tmp_name = $image["tmp_name"];
            // basename() may prevent filesystem traversal attacks;
            // further validation/sanitation of the filename may be appropriate
            $name = basename($image["name"]);
            $status = move_uploaded_file($tmp_name, "$uploads_dir/$name");
            echo "<script>console.log('status:". $status==TRUE."');</script>\n";
            return $name;
        }
    }

    public function storeVendor(){
        $vendor_name = htmlentities($_POST["vendor_name"]);
        $vendor_description = htmlentities($_POST["description"];


        //We need the vendor stored before storing images due to vendor_id foriegn key constraint
        $insert_vendor = $this->dbconn->prepare("INSERT INTO `vendor` (`name`, `description`, `location`, `deployed`, `logo` ) VALUES (:name, :description, :location, :deployed, :logo) ");

        //logo may or may not be included but needs some value to store the vendor.
        $status = $insert_vendor->execute(array(':name' => $vendor_name, ':description' => $vendor_description, ':location' => 0, ':deployed' => 0, ':logo' => !empty($_FILES["logo"]) ? htmlentities($_FILES["logo"]["name"]) : null) );
        //logo may or may not be included in adding the vendor.
        if(!empty($_FILES["logo"])){
            $logo_url = $this->uploadImage($_FILES["logo"]);
        }

        //images may or may not be included in adding the vendor.
        if(!empty($_FILES["images"])){
            $image_urls = [];

            //ensure the format of the array is what uploadImage expects
            $images = restructureFilesArray($_FILES["images"]);
            foreach ($images as $image) {
                $image_url = $this->uploadImage($image);
                $image_urls[] = $image_url;
            }
            echo "<script>console.log(". json_encode($image_urls) .");</script>\n";
            foreach ($image_urls as $value) {
                
                $insert_image = $this->dbconn->prepare("INSERT INTO `image` (`image_url`, `vendor_FK`) VALUES (".$value. ", (SELECT `vendor_id` FROM `vendor` WHERE name = :name) )");
                $status = $insert_image->execute(array(':name' => $vendor_name));
            }
        
            echo "<script>console.log('images status:". $status ."');</script>\n";
        }

        //menu may or may not be included in adding the vendor.
        if(!empty($_FILES["menu"]) ){
            $menu_url = $this->uploadImage($_FILES["menu"]);
            echo "<script>console.log('menu_url:". $menu_url ."');</script>\n";
            $insert_menu = $this->dbconn->prepare("INSERT INTO `menu` (`menu_url`, `vendor_FK`) VALUES (".$menu_url. ", (SELECT `vendor_id` FROM `vendor` WHERE name = :name) )");
            $status = $insert_menu->execute(array(':name' => $vendor_name));
        }

        echo "<script>console.log('done with function');</script>";
        return;
    }

    public function deleteVendor($vendor_name){
        $delete_vendor = $this->dbconn->prepare("DELETE FROM `vendor` WHERE `name` = :name");
        $status = $delete_vendor->execute( array(  ":name" => htmlentities($_POST["vendor_name"])  ) );
    }

    public function activateVendor($vendor_name){
        $activate_vendor = $this->dbconn->prepare("UPDATE `vendor` SET `deployed` = 1 WHERE `name` = :name");
        $status = $activate_vendor->execute( array(  ":name" => htmlentities($_POST["vendor_name"]) )  );
    }

    public function deactivateVendor($vendor_name){
        $deactivate_vendor = $this->dbconn->prepare("UPDATE `vendor` SET `deployed` = 0 WHERE `name` = :name");
        $status = $deactivate_vendor->execute( array(  ":name" => htmlentities($_POST["vendor_name"]) )  );
    }


}
?>