<?php

namespace FW;
use FW\MVC\View\Template;
use FW\Interfaces\GlobalInterface;
use FW\Interfaces\ExceptionsInterface;
use FW\Exceptions\Exceptions;
use FW\Util\Route;

class Application implements GlobalInterface{

    protected   $controllers,
                $default,
                $appName,
                $controllerName,
                $route,
                $viewConfig,
                $exception = 0;
    

    public function __construct() {
        $config = require $this::APPROOT.'Config.php';
        $this->appName = $config['appName'];
        $this->controllers = $config['controllers'];
        $this->default = $config['default'];
        $this->route = new Route();
        $this->viewConfig = $config['view'];
    }

    public function load() {
        $action = null;
        if ($this->route->controllerIsNull()) {
            if($controller = $this->loadDefault())
                $action = $this->getAction ($this->default['action'], $controller->getDefaultAction());
        }
        elseif (($controller = $this->loadController())) {
            $action = $this->getAction ($this->route->getAction(), $controller->getDefaultAction());
        }
        
        if($this->isAction($controller, $action)){
            $view = $controller->$action();
            if($view instanceof \FW\MVC\View\ViewModel){
                $view->setView($this::VIEW_ROOT.$this->controllerName.'/'.$action.'.phtml');
                $this->exception = $view->getException();
            }
            else
                $this->exception = ExceptionsInterface::VIEWNOTSETED;
        }
        
        if($this->exception > 0){
            $exception = new Exceptions($this->exception);
            echo 'Um erro aconteceu:<br>Codigo do erro: '.$exception->getCode().'<br>';
            echo 'Menssagem: '.$exception->getMessage();
        }
        else{
            $view = new Template($this->viewConfig, $view);
            $view->getTemplate();
        }
    }
    
    /**
     * Cria uma instancia de Controller
     * @param String $controller
     * @return \FW\MVC\Controller|boolean
     */
    protected function initController($controller) {
        if (file_exists($this::CONTROLLERS_ROOT.$controller.'.php')) {
            $this->controllerName = strtolower($controller);
            $obj = '\\'.$this->appName.'\\Controllers\\'.$controller;
            require_once $this::CONTROLLERS_ROOT.$controller.'.php';
            return new $obj();
        }
        return FALSE;
    }
    
    /**
     * Verifica se $action existe no $controller
     * @param \FW\MVC\Controller $controller
     * @param string $action
     * @return boolean
     */
    
    protected function isAction($controller, $action){
        if(is_object($controller)){
            if (method_exists($controller, $action)) return TRUE;
            $this->exception = ExceptionsInterface::ACTIONNOTFOUND;
            return FALSE;
        }
    }
    /**
     * Seta controller padrão definidos em \Application\Config
     * @return string|boolean
     */

    protected function loadDefault(){
        if($controller = $this->initController(ucfirst($this->default['controller']))) return $controller;
        $this->exception = ExceptionsInterface::CONTROLLERNOTFOUND;
        return FALSE;
    }
    
    /**
     * Seta controller passados por \FW\Util\Route 
     * @return string|boolean
     */
    
    protected function loadController(){
        foreach ($this->controllers as $controller) {
            if (($controller = ucfirst($controller)) == ucfirst($this->route->getController())) {
                if($controller = $this->initController($controller)) return $controller;
            }
        }
        $this->exception = ExceptionsInterface::CONTROLLERNOTFOUND;
        return FALSE;
    }
    
    /**
     * Retorna o nome da action a ser executada
     * @param string $action
     * @param string $default
     * @return string
     */
    
    protected function getAction($action, $default){
        return (!empty($action)) ? $action : $default;
    }

}

?>
