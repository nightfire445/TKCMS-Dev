<?php

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
}
?>