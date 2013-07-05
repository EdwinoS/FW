<?php
namespace FW\MVC\View;
use FW\Interfaces\GlobalInterface;
class Template implements GlobalInterface{
    protected   $docmentType,
                $encode ,
                $title,
                $layoutModel;
    public function __construct($config) {
        $this->layoutModel = $this::APPROOT.$config['layoutModel'];
        $this->setDocmentType(strtoupper($config['documentType']));
        $this->setEncode(strtoupper($config['encode']), strtolower($config['documentType']));
        $this->setTitle($config['defaultTitle']);
    }

    public function getView(){
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

    public function setTitle($title) {
        $this->title = '<title>'.$title.'</title>'.$this::EOL;
    }
}

?>
