<?php
namespace FW\Exceptions;

use FW\Interfaces\GlobalInterface;

class Exceptions implements GlobalInterface {
    protected $exceptionCode,
              $exceptionSubCode,
              $items,
              $Messages;
    
    
    public function __construct($exception) {
        $exception['code'] .= '-';
        $code = explode('-', $exception['code']);
        $this->exceptionCode = $code[0];
        $this->exceptionSubCode = (empty($code[1])) ? 0 : $code[1] ;
        $this->items = $exception['items'];
        $this->getExceptionsMessages();
    }
    
    public function getCode(){
        return $this->exceptionCode;
    }

    public function getMessage(){
        $message = null;
        $count = 0;
        $texts = explode('%',$this->Messages[$this->exceptionCode][$this->exceptionSubCode]);
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
