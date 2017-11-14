<?php
class Model
{
    public $string; 
    public $vendors;   
    private $dbconn;

    public function __construct(){
        require_once dirname(__FILE__). "/../connect.php";
        
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

    	return;
    }

    public function uploadImage(){
        
        return;
    }

    public function storeVendor(){
            //We need the vendor stored before storing images due to vendor_id foriegn key constraint


            $insert_vendor = $this->dbconn->prepare("INSERT INTO `vendor` (`name`, `description`, `location`, `deployed`, `logo` ) VALUES (:name, :description, :location, :deployed, :logo) ");

            //logo may or may not be included but needs some value to store the vendor.
            $status = $insert_vendor->execute(array(':name' => $_POST["vendor_name"], ':description' => $_POST["description"], ':location' => 0, ':deployed' => 0, ':logo' => !empty($_POST["logo"]) ? $_POST["logo"] : null) );

             
            //images may or may not be included in adding the vendor.
            if(!empty($_POST["images"])){
                $image_urls = [];
                foreach ($_POST["images"] as $value) {
                    $image_url = $this->model->uploadImage($value);
                    $image_urls[] = $image_url;
                }

                foreach ($image_urls as $value) {
                    $this->dbconn->prepare("INSERT INTO `image` (`image_url`, `vendor_FK`) VALUES (".$value. ", (SELECT `vendor_id` FROM `vendor` WHERE name = :name) )");
                    $this->dbconn->execute(array(':name' => $_POST["vendor_name"]));
                }
            

            }

            //menu may or may not be included in adding the vendor.
            if(!empty($_POST["menu"]) ){
               $menu_url = $this->model->uploadImage($_POST["menu"]);
               $this->dbconn->prepare("INSERT INTO `menu` (`menu_url`, `vendor_FK`) VALUES (".$menu_url. ", (SELECT `vendor_id` FROM `vendor` WHERE name = :name) )");
                $this->dbconn->execute(array(':name' => $_POST["vendor_name"]));
            }



        return;
    }

    public function deleteVendor($vendor_name){
        $delete_vendor = $this->dbconn->prepare("DELETE FROM `vendor` WHERE `name` = :name");
        $status = $delete_vendor->execute(array(":name" => $_POST["vendor_name"]));
    }

    public function activateVendor($vendor_name){
        $activate_vendor = $this->dbconn->prepare("UPDATE `vendor` SET `deployed` = 1 WHERE `name` = :name");
        $status = $activate_vendor->execute(array(":name" => $_POST["vendor_name"]));
    }

    public function deactivateVendor($vendor_name){
        $deactivate_vendor = $this->dbconn->prepare("UPDATE `vendor` SET `deployed` = 0 WHERE `name` = :name");
        $status = $deactivate_vendor->execute(array(":name" => $_POST["vendor_name"]));
    }


}
?>