<?php
require "./../classes/Model.php";
require "./../classes/View.php";
require "./../classes/Controller.php";
$model = new Model();
$controller = new Controller($model);
$view = new View($controller, $model);
$view->loadHTMLFile( "./../../html/troy-kitchen-cms.html");
$view->outputDOM();


?>