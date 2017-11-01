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
        return "<p>" . $this->model->string . "</p>";
    }

    public function loadHTMLFile(filelocation){
        $this->dom = new DOMDocument();
        $this->dom->loadHTMLFile(filelocation);

    }

    public function outputDOM(){
        if(isset($this->dom)){
            echo $this->dom->saveHTML();
        }

    }
}
?>