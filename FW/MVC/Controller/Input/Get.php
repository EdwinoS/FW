<?php
namespace FW\MVC\Controller\Input;

class Get extends AbstractInput{
    public function __construct() {
        $this->antiInjection($_GET);
    }
}
?>
