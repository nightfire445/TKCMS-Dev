<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
	require "./models/dashboard_model.php";
	require "./views/dashboard_view.php";
	require "./controllers/dashboard_controller.php";
	$model = new Model();
	$model->loadTemplateFile(dirname(__FILE__). "/../html/troy-kitchen-cms.html");
	$controller = new Controller($model);
	$view = new View($controller, $model);

	if(!empty($_POST)){
		//add_vendor
		if(isset($_POST["add_vendor"])){
			$controller->add_vendor();
		}

		//edit_vendor
		if(isset($_POST["edit_vendor"])){
			$controller->edit_vendor();
		}

		//delete_vendor
		if( isset($_POST["delete_vendor"]) ){
			$controller->delete_vendor($_POST["vendor_name"]);
		}

		//Activate Vendor
	    if( isset($_POST["activate_vendor"]) ){
			$controller->activate_vendor($_POST["vendor_name"]);
		}

		//Deactivate Vendor
		if( isset($_POST["deactivate_vendor"]) ){
			$controller->deactivate_vendor($_POST["vendor_name"]);
		}

		//refresh the page to reflect action after posting



	}
	$view->output();
?>