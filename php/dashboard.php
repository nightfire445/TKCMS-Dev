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
		//add_vendor
		if(isset($_POST["add_vendor"])){
			$msg = $controller->add_vendor();
		}

		//edit_vendor
		if(isset($_POST["edit_vendor"])){
			$msg = $controller->edit_vendor();
		}

		//delete_vendor
		if( isset($_POST["delete_vendor"]) ){
			$msg = $controller->delete_vendor($_POST["vendor_name"]);
		}

		//Activate Vendor
	    if( isset($_POST["activate_vendor"]) ){
			$msg = $controller->activate_vendor($_POST["vendor_name"]);
		}

		//Deactivate Vendor
		if( isset($_POST["deactivate_vendor"]) ){
			$msg = $controller->deactivate_vendor($_POST["vendor_name"]);
		}

		//refresh the page to reflect action after posting
		echo "<meta http-equiv='refresh' content='0'>";



	}
?>