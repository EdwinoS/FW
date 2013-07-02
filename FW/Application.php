<?php

namespace FW;

class Application {

    protected   $controllers,
                $appName,
                $URL;

    public function __construct() {
        $config = require '../Application/Config.php';
        $this->appName = $config['appName'];
        $this->controllers = $config['controllers'];
        $this->URL = explode('/', $_SERVER['REQUEST_URI']);
    }

    public function load() {
        if (($controller = $this->initController())) {
            $action = (!empty($this->URL[2])) ? $this->URL[2] : $controller->getDefaultAction();
            if (method_exists($controller, $action))
                echo 'Controller foi carregado ' . $controller->$action();
            else
                echo 'Açao não existe';
        }
        else
            echo 'Erro 404';
    }

    protected function initController() {
        foreach ($this->controllers as $controller) {
            if (($controller = ucfirst($controller)) == ucfirst($this->URL[1])) {
                if (file_exists('../Application/Controllers/' . $controller . '.php')) {
                    $obj = '\\' . $this->appName . '\\Controllers\\' . $controller;
                    require_once '../Application/Controllers/' . $controller . '.php';
                    return new $obj();
                }
                break;
            }
        }
        return FALSE;
    }

}

?>
