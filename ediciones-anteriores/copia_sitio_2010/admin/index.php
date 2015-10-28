<?php
/**
* @package Punk Framework
* @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
* @version 0.2
* @author Lucas M. Sastre
* @link http://www.oniricosistemas.com
* @name index.php
*/


    ob_start();
    require '../core/clases/FrontController.php';
    require '../core/clases/class.registry.php';

    
    $registry = new registry();
    $router = new Router($registry);
    $router->loader($_SERVER['PHP_SELF']);
    $router->route();  
    ob_flush();
?>