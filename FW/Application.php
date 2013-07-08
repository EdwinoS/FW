<?php

namespace FW;
use FW\MVC\View\Template;
use FW\Interfaces\GlobalInterface;
use FW\Interfaces\ExceptionsInterface;
use FW\Exceptions\AbstractExceptions;

class Application implements GlobalInterface{

    protected   $controllers,
                $default,
                $appName,
                $URL,
                $viewConfig,
                $exception = 0;

    public function __construct() {
        $config = require $this::APPROOT.'Config.php';
        $this->appName = $config['appName'];
        $this->controllers = $config['controllers'];
        $this->default = $config['default'];
        $this->URL = explode('/', $_SERVER['REQUEST_URI']);
        $this->viewConfig = $config['view'];
    }

    public function load() {
        $action = null;
        if (empty($this->URL[1])) {
            if($controller = $this->loadDefault())
                $action = $this->getAction ($this->default['action'], $controller->getDefaultAction());
        }
        elseif (($controller = $this->loadController())) {
            //fixme, tira esse '@' que esconde o warnning
            @$action = $this->getAction ($this->URL[2], $controller->getDefaultAction());
        }
        
        if($this->isAction($controller, $action)){
            $controller->$action();
        }
        
        if($this->exception > 0){
            $exception = new AbstractExceptions($this->exception);
            echo 'Um erro aconteceu:<br>Codigo do erro: '.$exception->getCode().'<br>';
            echo 'Menssagem: '.$exception->getMessage();
        }
        else{
            echo 'Controller foi carregado ' . $controller->$action();
            $view = new Template($this->viewConfig);
            $view->getView();
        }
    }

    protected function initController($controller) {
        if (file_exists($this::CONTROLLERS_ROOT.$controller.'.php')) {
            $obj = '\\'.$this->appName.'\\Controllers\\'.$controller;
            require_once $this::CONTROLLERS_ROOT.$controller.'.php';
            return new $obj();
        }
        return FALSE;
    }
    
    protected function isAction($controller, $action){
        if(is_object($controller)){
            if (method_exists($controller, $action)) return TRUE;
            $this->exception = ExceptionsInterface::ACTIONNOTFOUND;
            return FALSE;
        }
    }

    protected function loadDefault(){
        if($controller = $this->initController(ucfirst($this->default['controller']))) return $controller;
        $this->exception = ExceptionsInterface::CONTROLLERNOTFOUND;
        return FALSE;
    }
    
    protected function loadController(){
        foreach ($this->controllers as $controller) {
            if (($controller = ucfirst($controller)) == ucfirst($this->URL[1])) {
                if($controller = $this->initController($controller)) return $controller;
            }
        }
        $this->exception = ExceptionsInterface::CONTROLLERNOTFOUND;
        return FALSE;
    }
    
    protected function getAction($action, $default){
        return (!empty($action)) ? $action : $default;
    }

}

?>
