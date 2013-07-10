<?php
namespace FW\MVC\View;
use FW\Interfaces\GlobalInterface;
class Template implements GlobalInterface{
    private $docmentType,
                $encode ,
                $title,
                $layoutModel,
                $view,
                $variables;
    public function __construct($config, $view, $variables) {
        $this->variables = $variables;
        $this->layoutModel = $this::APPROOT.$config['layoutModel'];
        $this->setDocmentType(strtoupper($config['documentType']));
        $this->setEncode(strtoupper($config['encode']), strtolower($config['documentType']));
        $this->setTitle($config['defaultTitle']);
        $this->view = $view;
    }

    public function getTemplate(){
        include ($this->layoutModel);
    }
    public function getDocmentType() {
        return $this->docmentType;
    }

    public function setDocmentType($docmentType) {
        switch ($docmentType){
            case 'HTML': $this->docmentType = '<!DOCTYPE html>'.$this::EOL; break;
        }
    }

    public function getEncode() {
        return $this->encode;
    }

    public function setEncode($encode, $doctype) {
        switch ($encode){
            case 'UTF8' : $charset = 'UTF-8'; break;
        }
        $this->encode = '<meta http-equiv="Content-Type" content="text/'.$doctype.'; charset='.$charset.'">'.$this::EOL;
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
}

?>
