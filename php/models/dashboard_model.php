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

        if(isset($_POST["add_vendor"])){
            //We need the vendor stored before we can store the images due to vendor id being a foriegn key 

            $insert_vendor = $this->prepare("INSERT INTO `vendor` (`name`, `description`, `location`, `deployed` ) VALUES (:name, :description, :location, :deployed) ");

            $insert_vendor->execute(array(':name' => $_POST["vendor-name"], ':description' => $_POST["description"], ':location' => $_POST["location"], ':deployed' => 0 ));


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


        }


        return;
    }

}
?>