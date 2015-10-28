<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     *
     * @name: class.log.php
     *
     */

    class Log {
	private $Config;
	private static $instance=null;

	/**
	 * Constructor
	 *
	 */
	public function __construct() {
	    $this->Config = Config::singleton();
	}

	/**
	 * Lista todo los registros del log
	 * @return <type>
	 */
	public function listarLog() {
	    $output = file_get_contents($this->Config->get('root').'/errores.log');
	    $output = explode("\n", $output);

	    //Ordenamos alreves
	    if(is_array($output)) {
		rsort($output);
	    }

	    return $output;
	}

	public function verLog($linea) {

	}

	/**
	 * vacia el archivo log
	 * @return <boolean>
	 */
	public function vaciarLog() {
	    if(file_put_contents($this->Config->get('root').'/errores.log', '')) {
		return true;
	    }
	    else {
		return false;
	    }

	}
	/**
	 * Creo el patron Singleton
	 *
	 * @return instance
	 */
	public static function singleton() {
	    if( self::$instance == null ) {
		self::$instance = new self();
	    }

	    return self::$instance;
	}
    }

?>