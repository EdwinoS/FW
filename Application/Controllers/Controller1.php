<?php
namespace Showdown\Controllers;

use \FW\MVC\Controller\AbstractController;
use FW\MVC\View\ViewModel;

class Controller1 extends AbstractController {
    public function indexAction(){
        return new ViewModel(array('teste' => 'xd'));
    }
    public function testAction(){
        return new ViewModel(array('teste' => 'action de teste'));
    }
}

?>
