<?php
namespace FW\MVC\Controller\Input;

abstract class AbstractInput {
    private $data;
    
    protected function antiInjection($method){
        foreach ($method as $key => $value) {
            $this->data[$key] = addslashes($value);
        }
    }
    
    public function get($offset = NULL){
        if($offset != NULL){
            return $this->data[$offset];
        }
        else return $this->data;
    }
    
    public function isSeted($offset){
        return isset($this->data[$offset]);
        
    }
}
?>
