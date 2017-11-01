<?php
class View
{
    private $model;
    private $controller;
    private $dom;

    public function __construct($controller,$model) {
        $this->controller = $controller;
        $this->model = $model;
    }
	
    public function output(){
        require_once($this->model->template);
    }

}
?>