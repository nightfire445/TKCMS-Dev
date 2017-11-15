<?php
	require "./models/dashboard_model.php";
	require "./views/dashboard_view.php";
	require "./controllers/dashboard_controller.php";
	$model = new Model();
	$model->loadTemplateFile(dirname(__FILE__). "/../html/troy-kitchen-cms.html");
	$controller = new Controller($model);
	$view = new View($controller, $model);
	$view->output();

	if(!empty($_POST)){
		if(isset($_POST["add_vendor"])){
			$controller->add_vendor();
		}
		//TO DO:
		//edit_vendor

	    //Activate Vendor
	    if( isset($_POST["activate_vendor"]) ){
			$controller->activate_vendor($_POST["vendor_name"]);
		}

		//Deactivate Vendor
		if( isset($_POST["deactivate_vendor"]) ){
			$controller->deactivate_vendor($_POST["vendor_name"]);
		}

		//delete_vendor
		if( isset($_POST["delete_vendor"]) ){
			$controller->delete_vendor($_POST["vendor_name"]);
		}



		echo "<meta http-equiv='refresh' content='0'>";



	}
?>