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
			return;
	    }

	    public function delete_vendor(){
	    	if( !empty($_POST["vendor_name"])) ){
	    		$this->model->deleteVendor();
	    	}
	    }

	    public function activate_vendor(){
	    	if ( !empty($_POST["vendor_name"])) ) {
	    		$this->model->activateVendor();
	    	}
	    }

	    public function deactivate_vendor(){
	    	if ( !empty($_POST["vendor_name"])) ) {
	    		$this->model->deactivateVendor();
	    	}
	    }
	}
?>