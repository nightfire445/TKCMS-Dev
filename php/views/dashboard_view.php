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
        require($this->model->template);
       if(error_reporting() == E_ALL){
          foreach ($vendors as $vendor) {
              var_dump($vendor);
           }
           
       }
    }


}
?>