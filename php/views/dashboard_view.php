<?php
class View
{
    private $model;
    private $controller;

    public function __construct($controller,$model) {
        $this->controller = $controller;
        $this->model = $model;
    }
	
    public function output(){
        $vendors= $this->model->vendors;
        require_once($this->model->template);

    }

}
?>