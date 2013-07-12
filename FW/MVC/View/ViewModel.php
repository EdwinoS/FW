<?php

namespace FW\MVC\View;

use FW\Interfaces\GlobalInterface;
use FW\Interfaces\ExceptionsInterface;

class ViewModel implements GlobalInterface {

    private $view,
            $exception,
            $type;

    public function __construct(array $variables, $type = NUll) {
        $this->setVariables($variables);
        $this->exception['code'] = 0;
        $this->type = $type;
    }

    public function setView($view) {
        if (file_exists($view)) {
            $this->view = $view;
        }
        else{
            $this->exception['code'] = ExceptionsInterface::VIEWNOTFOUND;
            $view[0] = null;
            $view[1] = null;
            $this->exception['items'][0] = $view;
        }
        
    }

    public function getView() {
        include $this->view;
    }

    private function setVariables($variables) {
        foreach ($variables as $key => $value) {
            $this->$key = $value;
        }
    }

    public function getException() {
        return $this->exception;
    }
    
    public function getType() {
        return $this->type;
    }
    public function setType($type) {
        $this->type = $type;
    }
    public function getViewPath(){
        return $this->view;
    }
}

?>
