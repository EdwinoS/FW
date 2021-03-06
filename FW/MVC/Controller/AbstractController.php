<?php
namespace FW\MVC\Controller;

use FW\MVC\Controller\Input\Get;
use FW\MVC\Controller\Input\Post;
use FW\MVC\View\ViewModel;

abstract class AbstractController {
    protected $defaultAction = 'index',
              $templatesVariables = array(),
              $controllerName,
              $templateType = NULL,
              $services;
    
    private $get, $post;
    
    public function indexAction(){
        return new ViewModel(array());
    }
    public function getDefaults(){
        return $this->defaultAction;
    }
    public function setTemplateVariable($variable, $value){
        $this->templatesVariables[$variable] = $value;
    }
    public function getTemplateVariable(){
        return $this->templatesVariables;
    }
    
    public function setTemplateType($templateType){
        $this->templateType = $templateType;
    }
    
    public function getTemplateType() {
        return $this->templateType;
    }
    
    public function inputGet(){
        if(!$this->get) $this->get = new Get();
        return $this->get;
    }
    public function inputPost(){
        if(!$this->post) $this->post = new Post();
        return $this->post;
    }
    
    public function getControllerName($offset = null) {
        if($offset){
            if($offset == 'name') return $this->controllerName['name'];
            if($offset == 'space') return $this->controllerName['space'];
            return NULL;
        }
        else return $this->controllerName;
    }

    public function setControllerName($controllerName) {
        $this->controllerName = $controllerName;
    }
    
    public function setServices(\FW\MVC\Controller\Services $services){
        if($services !== NULL){
            $this->services = $services;
        }
    }
    
    public function getService($serviceName){
        return $this->services->get($serviceName);
    }
    
}

?>
