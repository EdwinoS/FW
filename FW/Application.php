<?php

namespace FW;
use FW\MVC\View\Template;
use FW\Interfaces\GlobalInterface;
use FW\Interfaces\ExceptionsInterface;
use FW\Exceptions\AbstractExceptions;

class Application implements GlobalInterface{

    protected   $controllers,
                $appName,
                $URL,
                $viewConfig;

    public function __construct() {
        $config = require $this::APPROOT.'Config.php';
        $this->appName = $config['appName'];
        $this->controllers = $config['controllers'];
        $this->URL = explode('/', $_SERVER['REQUEST_URI']);
        $this->viewConfig = $config['view'];
    }

    public function load() {
        if (($controller = $this->initController())) {
            $action = (!empty($this->URL[2])) ? $this->URL[2] : $controller->getDefaultAction();
            if (method_exists($controller, $action)){
                echo 'Controller foi carregado ' . $controller->$action();
                $view = new Template($this->viewConfig);
                $view->getView();
            }
                
            else{
                $exception = new AbstractExceptions(ExceptionsInterface::ACTIONNOTFOUND);
                echo 'Um erro aconteceu:<br>Codigo do erro: '.$exception->getCode().'<br>';
                echo 'Menssagem: '.$exception->getMessage();
            }
        }
        else{
            $exception = new AbstractExceptions(ExceptionsInterface::CONTROLLERNOTFOUND);
            echo 'Um erro aconteceu:<br>Codigo do erro: '.$exception->getCode().'<br>';
            echo 'Menssagem: '.$exception->getMessage();
        }
    }

    protected function initController() {
        foreach ($this->controllers as $controller) {
            if (($controller = ucfirst($controller)) == ucfirst($this->URL[1])) {
                if (file_exists($this::CONTROLLERS_ROOT.$controller.'.php')) {
                    $obj = '\\'.$this->appName.'\\Controllers\\'.$controller;
                    require_once $this::CONTROLLERS_ROOT.$controller.'.php';
                    return new $obj();
                }
                break;
            }
        }
        return FALSE;
    }

}

?>
