<?php
namespace FW\Interfaces;

use \FW\Interfaces\GlobalInterface;

interface ExceptionsInterface extends GlobalInterface{
    
    //geral
    const NOTFOUD = 404;
    const FORBIDDEN = 403;
    const BADREQUEST = 400;
    const INTERNALSERVERERROR = 500;
    
    
    //controllers
    const CONTROLLERNOTFOUND = '404-1';
    const ACTIONNOTFOUND = '404-2';
    const SERVICENOTFOUND = '404-6';
    
    
    //views
    const VIEWNOTFOUND = '404-3';
    const VIEWNOTSETED = '404-4';
    const TEMPLATENOTFOUND = '404-5';
}

?>
