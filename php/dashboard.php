<?php

	require "./models/dashboard_model.php";
	require "./views/dashboard_view.php";
	require "./controllers/dashboard_controller.php";
	$model = new Model();
	$model->loadTemplateFile(dirname(__FILE__). "/../html/troy-kitchen-cms.html");
	$controller = new Controller($model);
	$view = new View($controller, $model);

	if(!empty($_POST)){

		//edit_vendor
		if(isset($_POST["edit_vendor"])){
			$controller->edit_vendor();
		}

		//add_vendor
		elseif(isset($_POST["add_vendor"])){
			$controller->add_vendor();
		}

		//delete_vendor
		elseif( isset($_POST["delete_vendor"]) ){
			$controller->delete_vendor();
		}

		//Activate Vendor
	    elseif( isset($_POST["activate_vendor"]) ){
			$controller->activate_vendor();
		}

		//Deactivate Vendor
		elseif( isset($_POST["deactivate_vendor"]) ){
			$controller->deactivate_vendor();
		}

		//assume first html button as per https://stackoverflow.com/questions/2680160/how-can-i-tell-which-button-was-clicked-in-a-php-form-submit;
		else{
			$controller->add_vendor();
		}
	}
	$view->output();
?>