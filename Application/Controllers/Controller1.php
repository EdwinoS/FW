<?php
namespace Showdown\Controllers;

use \FW\MVC\Controller\AbstractController;
use FW\MVC\View\ViewModel;

class Controller1 extends AbstractController {
    public function indexAction(){
        $rtn = '<h1>Uma pagina em HTML</h1>';
        return new ViewModel(array('teste' => $rtn));
    }
    public function jsonAction(){
        $rtn = json_encode(array('Pagina' => 'JSON','teste'=> array('lala', 'hey apple')));
        return new ViewModel(array('teste' => $rtn),'JSON');
    }
    public function xmlAction(){
        return new ViewModel(array(),'XML');
    }
}

?>
