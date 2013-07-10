<?php
namespace FW\Interfaces;

use \FW\Interfaces\GlobalInterface;

interface ExceptionsInterface extends GlobalInterface{
    
    //geral
    const CONTROLLERNOTFOUND = 404;
    const ACTIONNOTFOUND = 405;
    const FORBIDDEN = 403;
    const BADREQUEST = 400;
    const INTERNALSERVERERROR = 500;
    
    
    //controllers
    
    
    
    //views
    const VIEWNOTFOUND = 304;
    const VIEWNOTSETED = 305;
}

?>
