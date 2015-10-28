<?php
/**
* @package Punk Framework
* @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
* @version 0.2
* @author Lucas M. Sastre
* @link http://www.oniricosistemas.com
* @name /punk/core/clases/class.registry.php
*  
*/
class registry
	{
		
		 private $vars = array();
		
		 public function __set($index, $value)
		 {
			$this->vars[$index] = $value;
		 }
		
		 public function __get($index)
		 {
			return $this->vars[$index];
		 }
	}
	
?>