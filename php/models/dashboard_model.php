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

    public function loadVendorImages($vendor_id){
        $get_images_query = $this->dbconn->prepare("SELECT * FROM `image` WHERE `vendor_FK` = :vendor_id");
        $get_images_query->execute(array(":vendor_id" => $vendor_id));
        return $get_images_query->fetchAll();
    }


    public function loadVendors(){
    	$get_vendors_query = "SELECT * FROM `vendor` LEFT JOIN `menu` ON `vendor`.vendor_id = `menu`.vendor_FK";
        $get_vendors = $this->dbconn->query($get_vendors_query);
    	$vendors = $get_vendors->fetchAll();

        //we need to get the images associated with each vendor
        foreach ($vendors as $key => $value) {
            $vendors[$key]["images"] = $this->loadVendorImages($vendors[$key]['vendor_id']);
        }

    	return $vendors;
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

    public function deleteImage($imagename){
        $uploads_dir = $_SERVER["DOCUMENT_ROOT"] .'/resources/';

        if(error_reporting() & E_ALL){
            var_dump($imagename);
        }

        if (file_exists($uploads_dir.$imagename)) {
            unlink($uploads_dir.$imagename);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function storeVendor(){
        
        $vendor_name = htmlspecialchars($_POST["vendor_name"], ENT_QUOTES);
        $vendor_description = htmlspecialchars($_POST["description"], ENT_QUOTES);


        //We need the vendor stored before storing images due to vendor_id foriegn key constraint
        $insert_vendor = $this->dbconn->prepare("INSERT INTO `vendor` (`name`, `description`, `location`, `deployed`, `logo` ) VALUES (:name, :description, :location, :deployed, :logo) ");

        //logo may or may not be included but needs some value to store the vendor.
        $status = $insert_vendor->execute(array(':name' => $vendor_name, ':description' => $vendor_description, ':location' => 0, ':deployed' => 0, ':logo' => $_FILES['logo']['error']==0 ? htmlspecialchars($_FILES["logo"]["name"], ENT_QUOTES) : null) );

        //logo may or may not be included in adding the vendor.
        if($_FILES['logo']['error']==0){
            $logo_url = $this->uploadImage($_FILES["logo"]);
        }


        $image_urls = [];

        //ensure the format of the array is what uploadImage expects
        $images = restructureFilesArray($_FILES["images"]);
        foreach ($images as $image) {

            //images may or may not be included in adding the vendor.
            if($image["error"] == 0){
                $image_url = $this->uploadImage($image);
                $image_urls[] = $image_url;
            }
            
        }
        foreach ($image_urls as $image_url) {
            
            $insert_image = $this->dbconn->prepare("INSERT INTO `image` (`image_url`, `vendor_FK`) VALUES (:image_url, (SELECT `vendor_id` FROM `vendor` WHERE name = :name) )");
            $status = $insert_image->execute(array(':name' => $vendor_name, ':image_url' => $image_url));
        }
        

        //menu may or may not be included in adding the vendor.
        if($_FILES['menu']['error']==0 ){
            $menu_url = $this->uploadImage($_FILES["menu"]);
            $insert_menu = $this->dbconn->prepare("INSERT INTO `menu` (`menu_url`, `vendor_FK`) VALUES (:menu_url, (SELECT `vendor_id` FROM `vendor` WHERE name = :name) )");
            $status = $insert_menu->execute(array(':name' => $vendor_name, ':menu_url' => $menu_url));
        }

        return;
    }


    public function editVendor(){
        $vendor_name = htmlspecialchars($_POST["vendor_name"], ENT_QUOTES);
        $vendor_description = htmlspecialchars($_POST["description"], ENT_QUOTES);
        $vendor_id = htmlspecialchars($_POST["vendor_id"], ENT_QUOTES);

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
        //get vendor and menu data 
        $get_vendor_query = $this->dbconn->prepare("SELECT * FROM `vendor` WHERE `vendor_id` = :id");
        $get_vendor = $get_vendor_query->execute(array(":id" => $vendor_id));
        $get_menu_query = $this->dbconn->prepare("SELECT * FROM `menu` WHERE `vendor_FK` = :id");
        $get_menu = $get_menu_query->execute(array(":id" => $vendor_id));

        //we need the filenames for existing vendor logo and menu if we are to delete them
        $old_vendor_logo = $get_vendor["logo"];
        $old_vendor_menu = $get_menu["menu_url"];
        echo "<script>console.log('here');</script>";
        echo "<script>console.log('".$old_vendor_menu."');</script>";
        echo "<script>console.log('".$old_vendor_logo."');</script>";
        //faster to use the result than to repeatedly compare
        $logo_upload_result = $_FILES['logo']['error'] == 0; 
        $menu_upload_result = $_FILES['menu']['error'] == 0; 


        //delete files if applicable
        if( $logo_upload_result ){
            $this->deleteImage($old_vendor_logo);
        }

        if( $menu_upload_result ){
            $this->deleteImage($old_vendor_menu);
        }




        //update vendor name, description, & logo if applicable in the DB if 
        if($vendor_name != $get_vendor["name"] || $vendor_description != $get_vendor["description"] || $logo_upload_result ){

            $update_vendor_query = "UPDATE `vendor` SET `name` = :name, `description` = :description";
            if( $_FILES['logo']['error'] == 0 ){
                $update_vendor_query .= ", `logo` = :logo";
            }

            $update_vendor_query .= " WHERE `vendor_id` = :id";

            $update_vendor = $this->dbconn->prepare($update_vendor_query);
            //handles logo cases.
            if( $logo_upload_result ){
                $update_vendor->execute(array(":name" => $vendor_name, ":description" => $vendor_description, ":logo" => htmlspecialchars($_FILES["logo"]["name"], ENT_QUOTES), ":id" => $vendor_id));
            }
            else{
                $update_vendor->execute(array(":name" => $vendor_name, ":description" => $vendor_description, ":id" => $vendor_id));
            }

        }    
            
        

       
        //logo may or may not be included in adding the vendor.
        if( $logo_upload_result ){
            $logo_url = $this->uploadImage($_FILES["logo"]);
        }
        $image_urls = [];

        //ensure the format of the array is what uploadImage expects
        $images = restructureFilesArray($_FILES["images"]);
        foreach ($images as $image) {

            //images may or may not be included in adding the vendor.
            if($image["error"] == 0){
                $image_url = $this->uploadImage($image);
                $image_urls[] = $image_url;
            }
            
        }
        foreach ($image_urls as $image_url) {
            
            $insert_image = $this->dbconn->prepare("INSERT INTO `image` (`image_url`, `vendor_FK`) VALUES (:image_url, (SELECT `vendor_id` FROM `vendor` WHERE `vendor_id` = :id) )");
            $status = $insert_image->execute(array(':id' => $vendor_id, ':image_url' => $image_url));
        }
        



        //menu may or may not be included in editing the vendor.
        if( $menu_upload_result ){
            $menu_url = $this->uploadImage($_FILES["menu"]);

             $insert_menu_query  = $this->dbconn->prepare("INSERT INTO `menu` (`menu_url`, `vendor_FK`) VALUES (:menu_url, (SELECT `vendor_id` FROM `vendor` WHERE `vendor_id` = :id) )");
            $status = $insert_menu_query->execute(array(':id' => $vendor_id, ':menu_url' => $menu_url));
        }

        return;
    }

    public function deleteVendor(){
        $vendor_name = htmlspecialchars($_POST["vendor_name"], ENT_QUOTES);

        //TODO: delete images, menu, and logo file from server;

        //images and menu must be deleted before the vendor due to FK constraints
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