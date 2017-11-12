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
			echo "<script>console.log('added vendor');</script>";;
		}
		
	    //edit_vendor
	}
?>