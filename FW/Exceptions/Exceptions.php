<?php
namespace FW\Exceptions;

use FW\Interfaces\GlobalInterface;

class Exceptions implements GlobalInterface {
    protected $exceptionCode,
              $Messages;
    
    
    public function __construct($exception) {
        $this->exceptionCode = $exception;
        $this->getExceptionsMessages();
    }
    
    public function getCode(){
        return $this->exceptionCode;
    }

    public function getMessage(){
        return $this->Messages[$this->exceptionCode];
    }
    
    private function getExceptionsMessages(){
        $this->Messages = json_decode(file_get_contents($this::FWROOT.'Exceptions/Exceptions.json'),true);
    }
}
?>
