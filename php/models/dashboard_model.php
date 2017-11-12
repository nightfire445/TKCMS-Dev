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
    	$get_vendors = "SELECT * FROM `vendor`";
    	$this->vendors = $this->dbconn->query($get_vendors);
    	return;
    }

    public function uploadImage(){
        
        return;
    }

    public function storeVendor(){
            //We need the vendor stored before storing images due to vendor_id foriegn key constraint

            //all or nothing with the data insertion
            $this->dbconn->beginTransaction();

            $insert_vendor = $this->dbconn->prepare("INSERT INTO `vendor` (`name`, `description`, `location`, `deployed`, `logo` ) VALUES (:name, :description, :location, :deployed, :logo) ");

            $status = $insert_vendor->execute(array(':name' => $_POST["vendor_name"], ':description' => $_POST["description"], ':location' => 0, ':deployed' => 0, ':logo' => isset($_POST["logo"]) ? $_POST["logo"] : null));
            $insert_vendor->debugDumpParams();
            //images may or may not be included in adding the vendor.
            if(isset($_POST["images"])){
                $image_urls = [];
                foreach ($_POST["images"] as $value) {
                    $imgur_url = $this->model->uploadImage($value);
                    $image_urls[] = $imgur_url;
                }

                foreach ($image_urls as $value) {
                    $this->dbconn->prepare("INSERT INTO `image` (`image_url`, `vendor_FK`) VALUES (".$value. ", (SELECT `vendor_id` FROM `vendor` WHERE name = :name) )");
                    $this->dbconn->execute(array(':name' => $_POST["vendor_name"]));
                }
            

            }
            //menu may or may not be included in adding the vendor.
            if(isset($_POST["menu"]) ){
               $menu_url = $this->model->uploadImgur($_POST["menu"]);
               $this->dbconn->prepare("INSERT INTO `menu` (`menu_url`, `visible`, `vendor_FK`) VALUES (".$menu_url. ", 1 , (SELECT `vendor_id` FROM `vendor` WHERE name = :name) )");
                $this->dbconn->execute(array(':name' => $_POST["vendor_name"]));
            }

            //TO DO: store the images and or menu in the db
            $this->dbconn->commit();



        return;
    }

}
?>