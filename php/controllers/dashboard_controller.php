<?php
	class Controller
	{
	    private $model;

	    public function __construct($model) {
	        $this->model = $model;
	    }

	    public function add_vendor(){
	    	if(  !empty($_POST["vendor_name"]) && !empty($_POST["description"])  ){
				$this->model->storeVendor();
			
			}

	    }

	    public function edit_vendor(){
	    	
	    }

	    public function delete_vendor($vendor_name){
	    	if( !empty($vendor_name) ){
	    		$this->model->deleteVendor($vendor_name);
	    	}
	    }

	    public function activate_vendor($vendor_name){
	    	if ( !empty($vendor_name) ) {
	    		$this->model->activateVendor($vendor_name);
	    	}
	    }

	    public function deactivate_vendor($vendor_name){
	    	if ( !empty($vendor_name) ) {
	    		$this->model->deactivateVendor($vendor_name);
	    	}
	    }
	}
?>