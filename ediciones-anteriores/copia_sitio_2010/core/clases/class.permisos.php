<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     *
     * @name: class.permisos.php
     *
     */

    class PermisosUsuarios {

	private static $instance=null;
	private $Permisos;

	/**
	 * Constructor
	 *
	 */
	public function __construct() {
	    $config = Config::singleton();
	    include_once($config->get('path_root').'modelos/PermisosModel.php');
	    $this->Permisos = new Permisos();

	}

	/**
	 * carga los nombre de los controladores existentes
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name cargarControladoresPermisos
	 *
	 * Modificaciones
	 */
	private function cargarControladoresPermisos($dir) {
	    if(is_dir($dir)) {
		if ($dh = opendir($dir)) {
		    while (($file = readdir($dh)) !== false) {
			if($file != "." && $file != ".." && $file != 'smarty' && $file != '.svn' && $file != 'ajax' && $file != 'index' && $file != 'error404') {
			    $nombres[] = $file;
			}
		    }
		    closedir($dh);
		}
	    }

	    return $nombres;

	}

	/**
	 * carga los nombre de los metodos de un controlador existentes
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access private
	 * @name cargarMetodosControladoresPermisos
	 *
	 * Modificaciones
	 * @param <string> $ruta
	 * @param <string> $class
	 * @return <array>
	 */
	private function cargarMetodosControladoresPermisos($ruta,$class) {
	    $clase = $ruta.$class."/".strtolower($class)."Controller.php";
	    $class = strtolower($class)."Controller";

	    if(file_exists($clase)) {
		if(class_exists($class)) {
		    $class_methods = get_class_methods($class);
		}
		else {
		    include_once ($clase);
		    $class_methods = get_class_methods(new $class());
		}
	    }

	    return $class_methods;
	}

	/**
	 * lista los permisos
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name listarPermisos
	 *
	 * Modificaciones
	 */
	public function listarPermisos($ruta) {
	    $controladores = $this->cargarControladoresPermisos($ruta);
	    for($i=0;$i<count($controladores);$i++) {
		$nombre[$i]['nombre']=$controladores[$i];
		$metodos = $this->cargarMetodosControladoresPermisos($ruta,$controladores[$i]);
		$k=0;
		for($j=0;$j<count($metodos);$j++) {		    
		    if($metodos[$j]!='__construct' && $metodos[$j]!='modelo' && $metodos[$j]!='guardar'.ucfirst($controladores[$i]) && $metodos[$j]!='crear'.ucfirst($controladores[$i]) && $metodos[$j]!='libreria') {
			$nombre[$i][]= $metodos[$j];
			//echo $nombre[$i][$j]."- i: $i - j: $j <br/>";
		    }
		    $k++;
		}
	    }

	    return $nombre;
	}

	/**
	 * valido los permisos de un usuario
	 * 
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name validarPermisos
	 *
	 * Modificaciones
	 */
	public function validarPermisos($user,$accion) {
	    $data['id_usuario'] = $user;
	    $permisos = $this->Permisos->listadoPermisos($data);
	    $control = unserialize($permisos[0]);
	    $seccion = explode('::', $accion);
	    $seccion[0] = ucfirst(str_replace('Controller','',$seccion[0]));
	    if(!in_array($accion, $control) && $_SESSION['superadmin']!='1') {		
		$_SESSION['mensaje'] = "No tiene los permisos de asignados para ingresar a la sección: ".$seccion[0]." - ".$seccion[1]."<br/>";
		echo "<script>window.open('index.php?controlador=error404','_self');</script>";
		die();
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