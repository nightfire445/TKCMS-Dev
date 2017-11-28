<?php

	require "./models/website_model.php";
	require "./views/website_view.php";
	require "./controllers/website_controller.php";
	$model = new Model();
	$model->loadTemplateFile(dirname(__FILE__). "/../html/troy-kitchen.html");
	$controller = new Controller($model);
	$view = new View($controller, $model);

	$view->output();
?>