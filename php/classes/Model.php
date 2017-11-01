<?php
class Model
{
    public $string;

    public function __construct(){
        $this->string = "MVC + PHP = Awesome!";
    }

      public function loadTemplateFile($filelocation){
        $this->template = $filelocation;
    }
}
?>