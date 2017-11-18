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

        $uploads_dir = $_SERVER["DOCUMENT_ROOT"] .'/resources';
        if ($image["error"] == UPLOAD_ERR_OK) {
            $tmp_name = $image["tmp_name"];
            // basename() may prevent filesystem traversal attacks;
            // further validation/sanitation of the filename may be appropriate
            $name = basename($image["name"]);
            $status = move_uploaded_file($tmp_name, "$uploads_dir/$name");
            return $name;
        }

    }

    public function storeVendor(){
    try {
        
        $vendor_name = htmlspecialchars($_POST["vendor_name"], ENT_QUOTES);
        $vendor_description = htmlspecialchars($_POST["description"], ENT_QUOTES);


        //We need the vendor stored before storing images due to vendor_id foriegn key constraint
        $insert_vendor = $this->dbconn->prepare("INSERT INTO `vendor` (`name`, `description`, `location`, `deployed`, `logo` ) VALUES (:name, :description, :location, :deployed, :logo) ");

        //logo may or may not be included but needs some value to store the vendor.
        $status = $insert_vendor->execute(array(':name' => $vendor_name, ':description' => $vendor_description, ':location' => 0, ':deployed' => 0, ':logo' => !empty($_FILES["logo"]) ? htmlspecialchars($_FILES["logo"]["name"], ENT_QUOTES) : null) );
        //logo may or may not be included in adding the vendor.
        if($_FILES['logo']['error']==0){
            $logo_url = $this->uploadImage($_FILES["logo"]);
        }

        //images may or may not be included in adding the vendor.
        if($_FILES['images']['error']==0){
            $image_urls = [];

            //ensure the format of the array is what uploadImage expects
            $images = restructureFilesArray($_FILES["images"]);
            foreach ($images as $image) {
                $image_url = $this->uploadImage($image);
                $image_urls[] = $image_url;
            }
            foreach ($image_urls as $image_url) {
                
                $insert_image = $this->dbconn->prepare("INSERT INTO `image` (`image_url`, `vendor_FK`) VALUES (:image_url, (SELECT `vendor_id` FROM `vendor` WHERE name = :name) )");
                $status = $insert_image->execute(array(':name' => $vendor_name, ':image_url' => $image_url));
            }
        
        }

        //menu may or may not be included in adding the vendor.
        if($_FILES['menu']['error']==0 ){
            $menu_url = $this->uploadImage($_FILES["menu"]);
            $insert_menu = $this->dbconn->prepare("INSERT INTO `menu` (`menu_url`, `vendor_FK`) VALUES (:menu_url, (SELECT `vendor_id` FROM `vendor` WHERE name = :name) )");
            $status = $insert_menu->execute(array(':name' => $vendor_name, ':menu_url' => $menu_url));
        }

    } catch (Exception $e) {
        echo $e;
    }
        return;
    }

    public function deleteVendor(){
        $vendor_name = htmlspecialchars($_POST["vendor_name"], ENT_QUOTES);

        //images and menu must be delete before the vendor due to FK constraints
        $delete_images = $this->dbconn->prepare("DELETE FROM `image` WHERE `vendor_FK` = (SELECT `vendor_id` FROM `vendor` WHERE name =:name)");
        $status = $delete_images->execute(array(":name" => $vendor_name));
        $delete_menu = $this->dbconn->prepare("DELETE FROM `menu` WHERE `vendor_FK` = (SELECT `vendor_id` FROM `vendor` WHERE name =:name)");
        $status = $delete_menu->execute(array(":name" => $vendor_name));

        $delete_vendor = $this->dbconn->prepare("DELETE FROM `vendor` WHERE `name` = :name");
        $status = $delete_vendor->execute( array(  ":name" => $vendor_name  ) );
    }

    public function activateVendor($vendor_name){
        $activate_vendor = $this->dbconn->prepare("UPDATE `vendor` SET `deployed` = 1 WHERE `name` = :name");
        $status = $activate_vendor->execute( array(  ":name" => htmlspecialchars($_POST["vendor_name"], ENT_QUOTES) )  );
    }

    public function deactivateVendor($vendor_name){
        $deactivate_vendor = $this->dbconn->prepare("UPDATE `vendor` SET `deployed` = 0 WHERE `name` = :name");
        $status = $deactivate_vendor->execute( array(  ":name" => htmlspecialchars($_POST["vendor_name"], ENT_QUOTES) )  );
    }


}
?>