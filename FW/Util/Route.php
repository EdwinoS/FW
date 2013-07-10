<?php
namespace FW\Util;

/*
 * Classe Responsavel por tratar rotas para o formato /controller/action
 */

class Route {
    protected $controller, $action;
    public function __construct() {
        $url = explode('/', $_SERVER['REQUEST_URI']);
        if(count($url) <= 3){
            $this->controller = (!empty($url[1]) || !isset($url[1])) ? $this->removeInput($url[1]) : null;
            $this->action = (!empty($url[2]) || !isset($url[2])) ? $this->removeInput($url[2]) : null;
        }
        else{
            Header('location:/'.$url[1].'/'.$url[2].$this->getInput($url));
        }
    }
    
    public function getController() {
        return $this->controller;
    }

    public function getAction() {
        return $this->action;
    }
    
    public function controllerIsNull(){
        return ($this->controller) ? false : true;
    }
    
    private function removeInput($url){
        return explode('?', $url)[0];
    }
    private function getInput($url){
        $input = explode('?', end($url))[1];
        return ($input) ? '?'.$input : NULL;
    }

}

?>
