<?php
namespace FW\MVC\Controller\Input;

class Post extends AbstractInput {
    public function __construct() {
        $_POST['teste'] = 1234;
        $this->antiInjection($_POST);
    }
}
?>
