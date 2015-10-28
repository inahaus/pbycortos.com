<?php
/**
* @package Punk Framework
* @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
* @version 0.2
* @author Lucas M. Sastre
* @link http://www.oniricosistemas.com
* @name class.database.php
*/

include_once('class.mysql.php');
class Database extends MySQL {
	private static $instance = null;

	/**
	 * Constructor de la clase
	 *
	 */
	public function __construct()
	{
		$config = Config::singleton();
		parent::__construct(true,$config->get('dbname'),$config->get('dbhost'),$config->get('dbuser'),$config->get('dbpass'),'');		
	}

	/**
	 * Singleton
	 * 
	 * @access public
	 * @return instancia de la clase
	 */
	public static function singleton()
	{
		if( self::$instance == null )
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

}
?>