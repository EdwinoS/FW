<?php
namespace Showdown;
return array(
    'appName' => __NAMESPACE__,
    'controllers' => array(
        'Controller1',
        'controller2',
        'controller3'
    ),
    'default' => array('controller' => 'controller1', 'action' => ''),
    'view' => array(
        'documentType' => 'HTML',
        'encode' => 'UTF8',
        'defaultTitle' => '',
        'layoutModel' => 'View/Layout.phtml'
    )
);