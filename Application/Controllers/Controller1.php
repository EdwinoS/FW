<?php
namespace Showdown\Controllers;

use \FW\MVC\Controller\AbstractController;
use FW\MVC\View\ViewModel;

class Controller1 extends AbstractController {
    public function index(){
        return new ViewModel(array('teste' => 'xd'));
    }
    public function test(){
        return new ViewModel(array('teste' => 'xd'));
    }
}

?>
