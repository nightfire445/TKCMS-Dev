<?php
require "./../classes/Model.php";
require "./../classes/View.php";
require "./../classes/Controller.php";
$model = new Model();
$model->loadTemplateFile("./../../html/troy-kitchen-cms.html");
$controller = new Controller($model);
$view = new View($controller, $model);

?>