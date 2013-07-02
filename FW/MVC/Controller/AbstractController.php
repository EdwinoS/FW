<?php
namespace FW\MVC\Controller;

abstract class AbstractController {
    protected $defaultAction = 'index';
    public function index(){
        return NULL;
    }
    public function getDefaultAction(){
        return $this->defaultAction;
    }
}

?>
