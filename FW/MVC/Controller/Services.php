<?php
namespace FW\MVC\Controller;
use \FW\Exceptions\Exceptions;
use \FW\Interfaces\ExceptionsInterface;
use \FW\Interfaces\GlobalInterface;

class Services implements GlobalInterface{
    public function __construct($config) {
        foreach ($config as $service){
            $this->initService($service);
        }
    }
    protected function initService($serviceName){
        $serviceName = ucfirst($serviceName);
        $class = $this::SERVICES_ROOT.$serviceName.'.php';
        if(file_exists($class)){
            require_once $class;
            $this->$serviceName = new $serviceName();
        }
    }
    
    public function get($serviceName){
        
        if(property_exists($this, $serviceName)){
            return $this->$serviceName;
        }
        else{
            $service = $this::SERVICES_ROOT.$serviceName.'.php';
            $service[0] = null;
            $service[1] = null;
            $exception = new Exceptions(array('code' => ExceptionsInterface::SERVICENOTFOUND, 'items' => array($serviceName,$service)));
            echo '<b>'.$exception->getCode().'</b> - '.$exception->getMessage();
            exit();
        }
    }
}

?>
