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
        $vendors = $this->model->loadVendors();
        require_once($this->model->template);

        if(error_reporting() & E_ALL){
            var_dump($vendors);
        }
    }


}
?>