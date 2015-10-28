<?php
/**
* @package Punk Framework
* @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
* @version 0.2
* @author Lucas M. Sastre
* @link http://www.oniricosistemas.com
* @name Modelo.php
*/

abstract class Modelo
{
	protected $db;
 
	/**
	 * Contructor
	 * 
	 * @access Public
	 * @version 0.1
	 */
	public function __construct()
	{
		$this->db = Database::singleton();
	}
}
?>