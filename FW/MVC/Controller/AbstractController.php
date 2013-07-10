<?php
namespace FW\MVC\Controller;

abstract class AbstractController {
    protected $defaultAction = 'index',
              $templatesVariables = null;
    public function index(){
        return NULL;
    }
    public function getDefaultAction(){
        return $this->defaultAction;
    }
    public function setTemplateVariable($variable, $value){
        $this->templatesVariables[$variable] = $value;
    }
    public function getTemplateVariable(){
        return $this->templatesVariables;
    }
}

?>
