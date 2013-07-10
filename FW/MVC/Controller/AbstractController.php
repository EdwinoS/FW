<?php
namespace FW\MVC\Controller;

use FW\MVC\Controller\Input\Get;
use FW\MVC\Controller\Input\Post;

abstract class AbstractController {
    protected $defaultAction = 'index',
              $templatesVariables = null;
    private $get, $post;
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
    public function inputGet(){
        if(!$this->get) $this->get = new Get();
        return $this->get;
    }
    public function inputPost(){
        if(!$this->post) $this->post = new Post();
        return $this->post;
    }
}

?>
