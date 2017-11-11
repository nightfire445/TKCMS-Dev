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

    public function uploadImgur(){
        

        return;
    }

    public function storeVendor(){
            //We need the vendor stored before storing images due to vendor_id foreign key constraint

            $insert_vendor = $this->dbconn->prepare("INSERT INTO `vendor` (`name`, `description`, `location`, `deployed` ) VALUES (:name, :description, :location, :deployed) ");

            $status = $insert_vendor->execute(array(':name' => $_POST["vendor-name"], ':description' => $_POST["description"], ':location' => 0, ':deployed' => 0 ));

            //images may or may not be included in adding the vendor.

            if(isset($_POST["images"])){
                $image_urls = [];
                foreach ($_POST["images"] as $value) {
                    $imgur_url = $this->model->uploadImgur($value);
                    $image_urls[] = $imgur_url;
                }
                
            }

            if(isset($_POST["menu"]) ){
               $menu_url = $this->model->uploadImgur($_POST["menu"]);

            }

            //TO DO: store the images and or menu in the db


        return;
    }

}
?>