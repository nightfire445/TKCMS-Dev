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

	}
?>