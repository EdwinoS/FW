<?php
namespace Showdown;
return array(
    'appName' => __NAMESPACE__,
    'controllers' => array(
        'Controller1',
        'controller2',
        'controller3'
    ),
    'default' => array('controller' => 'controller1', 'action' => 'index'),
    'view' => array(
        'documentType' => 'HTML',
        'encode' => 'UTF8',
        'defaultTitle' => 'Titulo Padrão',
        'layoutModel' => 'View/Layout.phtml'
    )
);