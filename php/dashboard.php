<?php
require "./models/dashboard_model.php";
require "./views/dashboard_view.php";
require "./controllers/dashboard_controller.php";
$model = new Model();
$model->loadTemplateFile("./../../html/troy-kitchen-cms.html");
$controller = new Controller($model);
$view = new View($controller, $model);
$view->output();

?>