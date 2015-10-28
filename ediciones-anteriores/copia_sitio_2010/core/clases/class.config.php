<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.2
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 *
 * @name: class.config.php
 *
 */

class Config {
    private $vars;
    private static $instance=null;

    /**
     * Constructor
     *
     */
    public function __construct() {
        $this->vars = array();
    }

    //Con set vamos guardando nuestras variables.
    public function set($name, $value) {
        if(!isset($this->vars[$name])) {
            $this->vars[$name] = $value;
        }
    }

    //Con get('nombre_de_la_variable') recuperamos un valor.
    public function get($name) {
        if(isset($this->vars[$name])) {
            return $this->vars[$name];
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