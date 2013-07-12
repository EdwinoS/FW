<?php
namespace FW\MVC\View;
use FW\Interfaces\GlobalInterface;
use FW\Exceptions\Exceptions;

class Template implements GlobalInterface{
    private $docmentType = '<!DOCTYPE html>',
            $encode ='<meta http-equiv="Content-Type" content="text/HTML"; charset="UTF-8">',
            $title = '',
            $layoutModel = 'View/Layout.phtml',
            $view,
            $variables;
    public function __construct($config, $view, $variables) {
        $this->setEncode($config['encode']);
        $this->view = $view;
        $this->layoutModel = $this::APPROOT.(($config['layoutModel']) ? $config['layoutModel'] : $this->layoutModel);
        $this->setTitle($config['defaultTitle']);
        $this->setDocmentType(($view->getType()) ? $view->getType() : $config['documentType']);
        $this->variables = $variables;
        
    }

    public function getTemplate(){
            if($this->layoutModel instanceof \FW\MVC\View\ViewModel)
                $this->view->getView();
            else{
                if(file_exists($this->layoutModel)){
                    include ($this->layoutModel);
                }
                else{
                    $exception = new Exceptions(array('code' => '404-5', 'items' => array(0 => $this->layoutModel)));
                    $this->view = new ViewModel(array(
                        'code' => $exception->getCode(),
                        'message' => $exception->getMessage()
                    ), 'HTML');
                    $this->view->setView('../FW/Exceptions/view.phtml');
                    $this->setTitle('Um erro ocorreu');
                    include '../FW/Exceptions/layout.phtml';
                }
            }
    }
    public function getDocmentType() {
        return $this->docmentType;
    }

    public function setDocmentType($docmentType) {
        $docmentType = strtoupper($docmentType);
        switch ($docmentType){
            case 'HTML': 
                $this->docmentType = '<!DOCTYPE html>'.$this::EOL; 
                header('Content-type: text/html; charset='.$this->encode);
                $this->encode = '<meta http-equiv="Content-Type" content="text/HTML; charset='.$this->encode.'">'.$this::EOL;
            break;
            case 'XML': 
                header('Content-type: application/xml; charset='.$this->encode);
                echo $this->docmentType = '<?xml version="1.0" encoding="'.$this->encode.'"?>'.$this::EOL;
                $this->layoutModel = $this->view;
            break;
            case 'JSON': 
                header('Content-type: application/json; charset='.$this->encode);
                $this->layoutModel = $this->view;
            break;
            default :
                header('Content-type: text/html; charset='.$this->encode);
                $this->encode = '<meta http-equiv="Content-Type" content="text/HTML"; charset="'.$this->encode.'">';
                $this->docmentType = '<!DOCTYPE html>'.$this::EOL;
            break;
        }
    }
    
    public function getTitle() {
        return $this->title;
    }

    public function setTitle($defaultTitle) {
        $this->title = '<title>'.
                       ((isset($this->variables['title'])) ? $this->variables['title'] : $defaultTitle)
                       .'</title>'.$this::EOL;
    }
    
    public function getView(){
         $this->view->getView();
         echo $this::EOL;
    }
    public function getVariable($variable){
        return (isset($this->variables[$variable])) ? $this->variables[$variable] : NULL ;
    }

    public function getEncode() {
        return $this->encode;
    }

    public function setEncode($encode) {
        $encode = strtoupper($encode);
        preg_match_all ( "/(?:(UTF)-?(8|16)|(ISO)-?(?:(8859)-?([1-9][0-5]?))|(2022)-?(JP|KR)-?[1-2])/i" , $encode, $match, PREG_SET_ORDER);
        if(!isset($match[0])){
            $this->encode = 'UTF-8';
        }
        $match = array_filter(array_slice($match[0],1)); // o slice joga o $match[0][0] fora e coloca o $match[0] direto e o filter tira os undefined
        $this->encode = implode("-",$match);
    }
}

?>
