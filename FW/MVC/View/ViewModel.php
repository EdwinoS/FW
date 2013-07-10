<?php

namespace FW\MVC\View;

use FW\Interfaces\GlobalInterface;
use FW\Interfaces\ExceptionsInterface;

class ViewModel implements GlobalInterface {

    private $view,
            $exception = 0;

    public function __construct(array $variables) {
        $this->setVariables($variables);
    }

    public function setView($view) {
        if (file_exists($view)) {
            $this->view = $view;
        }
        else
            $this->exception = ExceptionsInterface::VIEWNOTFOUND;
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

}

?>
