<?php
class Model
{
    public $string; 
    public $vendors;   
    private $dbconn;

    require_once "./../connect.php";

    public function __construct(){
        $this->string = "";
        $this->dbconn = $dbconn;
        $this->loadVendors();

    }

    public function loadTemplateFile($filelocation){
        $this->template = $filelocation;
    }

    public function loadVendors(){
    	$get_vendors = "SELECT * FROM `vendor`";
    	$this->vendors = $dbconn->query($get_vendors);
    	return;
    }

    public function uploadImage(){
    	return;
    }
}
?>