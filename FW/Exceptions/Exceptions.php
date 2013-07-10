<?php
namespace FW\Exceptions;

use FW\Interfaces\GlobalInterface;

class Exceptions implements GlobalInterface {
    protected $exceptionCode,
              $items,
              $Messages;
    
    
    public function __construct($exception) {
        $this->exceptionCode = $exception['code'];
        $this->items = $exception['items'];
        $this->getExceptionsMessages();
    }
    
    public function getCode(){
        return $this->exceptionCode;
    }

    public function getMessage(){
        $message = null;
        $count = 0;
        $texts = explode('%',$this->Messages[$this->exceptionCode]);
        foreach ($texts as $part){
            $message .= $part;
            if(isset($this->items[$count])){
                $message .= '<b>'.$this->items[$count].'</b>';
                $count++;
            }
        }
        
        return $message;
    }
    
    private function getExceptionsMessages(){
        $this->Messages = json_decode(file_get_contents($this::FWROOT.'Exceptions/Exceptions.json'),true);
    }
}
?>
