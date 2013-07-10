<?php
namespace Showdown\Controllers;

use \FW\MVC\Controller\AbstractController;
use FW\MVC\View\ViewModel;

class Controller1 extends AbstractController {
    public function index(){
        $this->setTemplateVariable('title', 'hey apple title');
        return new ViewModel(array('teste' => 'xd'));
    }
    public function test(){
        return new ViewModel(array('teste' => 'xd'));
    }
}

?>
