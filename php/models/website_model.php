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

    public function loadVendors(){
    	$get_vendors_query = "SELECT * FROM `vendor` WHERE `deployed` = 1";
        $get_vendors = $this->dbconn->query($get_vendors_query);
    	$this->vendors = $get_vendors->fetchAll();

    	return $this->vendors;
    }
}
?>