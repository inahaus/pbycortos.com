<?php
/**
* @package Punk Framework
* @copyright Copyright (C) 2009 Onírico Sistemas. Todos los derechos reservados.
* @version 0.1
* @author Lucas M. Sastre
* @link http://www.oniricosistemas.com
*
* @name class.breadCrumbs.php
*/

class breadCrumbs {
	/**
	 * constructor
	 *
	 */
	function __construct(){
		
	}
	
	/**
	 * devuelve la lista de breadcrumb
	 *
	 * @param string $ruta
	 */
	public function listarBreadCrumb($ruta){
		
		$breadCrumb.='
		<ul id="mainNav">
		<li>
			<a href="index.php"'; if($ruta['controlador']=='' ){$breadCrumb.=' class="active"';}
		$breadCrumb.='>
				Inicio
			</a>
		</li>
                <li>
			<a href="../index.php" title="Ver Sitio" target="_blank">
				Ver Sitio
			</a>
		</li>
                ';
        if($ruta['controlador']!='' && $ruta['controlador']!='index'  && $ruta['accion']==''){
        $breadCrumb.='
        <li>
        	<a href="index.php?controlador='.$ruta['controlador'].'" class="active">
        		 '.ucfirst(strtolower(preg_replace('/([A-Z])/', ' $1', $ruta['controlador']))).'
        	</a>
        </li>';
        }
        elseif ($ruta['controlador']!='' && $ruta['controlador']!='index'){
        $breadCrumb.='
        <li>
        	<a href="index.php?controlador='.$ruta['controlador'].'">
        		'.ucfirst(strtolower(preg_replace('/([A-Z])/', ' $1', $ruta['controlador']))).'
        	</a>
        </li>';
        }
        if($ruta['accion']!='' && $ruta['accion']!='index' && $ruta['accion']!='login'){
        $breadCrumb.='
        <li>
        	<a href="#" class="active">
        		'.ucfirst(preg_replace('/([A-Z])/', ' $1', $ruta['accion'])).'
        	</a>
        </li>';
        }

        $breadCrumb.='
        <li class="logout">
        	<a href="index.php?controlador=index&amp;accion=salir">
        		Salir
        	</a>
        </li>
        </ul>
        <div id="containerHolder">
			<div id="container">';
        
        return $breadCrumb;
		
	}
}
?>