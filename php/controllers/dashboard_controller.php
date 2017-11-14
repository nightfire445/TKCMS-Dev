<?php
	class Controller
	{
	    private $model;

	    public function __construct($model) {
	        $this->model = $model;
	    }

	    public function add_vendor(){
	    	if(  isset($_POST["vendor_name"]) && isset($_POST["description"])  ){
				$this->model->storeVendor();
			
			}

	    }

	    public function delete_vendor($vendor_name){
	    	if( !empty($_POST["vendor_name"]) ){
	    		$this->model->deleteVendor($vendor_name);
	    	}



	    }

	    public function activate_vendor($vendor_name){
	    	if ( !empty($_POST["vendor_name"]) ) {
	    		$this->model->activateVendor($vendor_name);
	    	}
	    }

	    public function deactivate_vendor($vendor_name){
	    	if ( !empty($_POST["vendor_name"]) ) {
	    		$this->model->deactivateVendor($vendor_name);
	    	}
	    }
	}
?>