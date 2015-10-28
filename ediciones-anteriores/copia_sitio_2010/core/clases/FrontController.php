<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2009 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.1
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     *
     * @name FrontController.php
     */
    /**
     * Modificaciones realizadas
     *
     * 28/02/2010
     * - se modificó el código, ahora valida si la aplicación esta siendo ejecutada
     * en el servidor del cliente o en un servidor local, y a partir de esa
     * validación setear las ruta_absolutas de los directorios de la apliación.
     *
     * 07/03/2010
     * - se agrego un ruta_absoluta relativa para el directorio de las imagenes.
     *
     * 23/03/2010
     * - Se agrego el redireccionamiento error404.
     * - Se agrego el guardado de errores en un archivo errores.log
     *
     * 30/03/2010
     * - se agrego al método loader que evite los directorios .svn
     *
     * 02/04/2010
     * - Se modifico en el FrontController.php los include y la validación para el idioma.
     */

    class Router {
	private static $instance;
	private $servidor;
	private $ubicacion;
	private $ruta;
	private $ruta_absoluta;
	private $path;
	private $rutaConfiguracion;

	/**
	 * Constructor
	 *
	 * @name _construct
	 * @param $registry
	 * @access public
	 * @version 0.2
	 * @author Lucas M. Sastre
	 *
	 *
	 */
	function __construct($param) {
	    $this->servidor = $_SERVER['HTTP_HOST'];
	    $ubicacion=explode('/',$_SERVER['PHP_SELF']);
	    array_pop($ubicacion);
	    $this->ubicacion = $ubicacion;

	    $this->path = implode('/',$this->ubicacion);
	    if(array_search('admin',$this->ubicacion)) {
		array_pop($this->ubicacion);
		$ruta = implode('/',$this->ubicacion);
		$this->ruta_absoluta = $ruta.'/' ;
	    }
	    else {
		$ruta = implode('/',$this->ubicacion);
		$this->ruta_absoluta = $ruta.'/' ;
	    }

	    $this->ruta = $_SERVER['DOCUMENT_ROOT'].$ruta.'/';

	    // valido si hay mas de una aplicacion en el sistema
	    if(count($this->ubicacion)>2) {		
		$this->path_root = $_SERVER['DOCUMENT_ROOT'].'/'.$this->ubicacion[1].'/';
		$this->rutaConfiguracion = $_SERVER['DOCUMENT_ROOT'].'/'.$this->ubicacion[1].'/';
	    }
	    else {		
		$this->rutaConfiguracion = $this->ruta;
	    }

	}

	/**
	 *  router
	 * @name router
	 * @access public
	 * @version 0.1
	 * @author Lucas M. Sastre
	 */
	public function route() {
	    include_once($this->rutaConfiguracion.'configuracion.php');
	    //seteo el path_root que contiene la ruta basica en caso de que el sistema sea multiple.
	    if(!empty($this->path_root)){
		$config->set('path_root',$this->path_root);
	    }
	    else{
		$config->set('path_root',$this->ruta);
	    }

	    //seteo el root
	    $config->set('root',$this->ruta);
	    

	    //configuro la ruta_absoluta de las imagenes
	    $config->set('imagenes',$config->get('root').'images/');
	    $config->set('urlImagenes','http://'.$this->servidor.$this->ruta_absoluta.'images/');

	    //seteo el path
	    $path=$config->get('root');

	    //valido si no estoy en el root y seteo el nuevo path
	    if(strpos($this->path,'admin')) {
		$path=$config->get('root').'admin';
		//seteo la ruta_absoluta url
		$config->set('urlRoot','http://'.$this->servidor.$this->ruta_absoluta);
	    }
	    else {
		$path=$config->get('root').'website';
		//seteo la ruta_absoluta url
		$config->set('urlRoot','http://'.$this->servidor.$this->ruta_absoluta);
	    }

	    //seteo el path definitivo
	    $config->set('path',$path);


	    //cargo todas las clases
	    $this->loader($config->get('root').$config->get('core'));

	    //obtengo el controlador que se envia por $_GET
	    $controller = $_GET['controlador'];

	    //obtengo el controlador que se envia por $_GET
	    if(isset($_GET['accion'])) {
		$action = $_GET['accion'];
	    }


	    //seteo el controlador si esta vacio seteo el controlador por default
	    if( empty($controller) ) {
		$controller = 'indexController';
	    }
	    else {
		$controller = $controller.'Controller';
	    }
	    
	    //cargo el lenguaje del sistema
	    if($config->get('multi')==1) {
		$leng = Language::singleton();
		$leng->get_session_handler();
		$idiomaActual = $config->get('lenguaje');
		setcookie ("leng", 'es', time () + 7*24*60*60);
		session_start();		

		$_SESSION['leng'] = $idiomaActual;

		if(isset($_GET['leng'])) {
		    setcookie ("leng", $_GET['leng'], time () + 7*24*60*60);
		    $idiomaActual = $_GET['leng'];
		    $_SESSION['leng'] = $_GET['leng'];
		}
		elseif(isset($_COOKIE['leng'])) {
		    if(file_exists($config->get('root')."/lenguajes/".$_COOKIE['leng'].".php")) {
			$idiomaActual = $_COOKIE['leng'];
			$_SESSION['leng'] = $_COOKIE['leng'];
		    }
		}
		else {
		    if(file_exists($config->get('root')."/lenguajes/".$_SESSION['leng'].".php")) {
			$idiomaActual = $_SESSION['leng'];

		    }
		}

		// Incluimos el archivo del idioma seleccionado
		// o el archivo por defecto si no se seleccionó
		// idioma o si no se encuentra el archivo
		include $config->get('root')."/lenguajes/".$idiomaActual.".php";
	    }

	    //extraigo el nombre del controlador.
	    $nombre=explode('Controller',$controller);

	    //seteo la accion, si esta vacia seteo la acción por default
	    if( empty($action) ) {
		$action = 'index';
	    }
	    else {
		$action = $action ;
	    }

	    //seteo la ruta_absoluta del controlador

	    $controllerLocation =  $config->get('path') . '/controladores/' . $nombre[0] . '/'.$controller.'.php';
	    $vista=$config->get('path') . '/controladores/' . $nombre[0] . '/templates/';
	    $config->set('vista',$vista);	    
	    

	    //valido si existe el archivo sino ejecuta la excepcion
	    if( file_exists( $controllerLocation ) ) {
		include_once( $controllerLocation );
	    } else {		
		error_log("[".date("F j, Y, G:i")."] [E_USER_NOTICE] [tipo Controlador] No se encuentra el controlador: {$controllerLocation}\n", 3,$config->get('root').'/errores.log');
		header("Location:index.php?controlador=error404");
	    }

	    //valido si existe la clase sino ejecuta la excepcion
	    if( class_exists( $controller, false ) ) {
		$cont = new $controller();
	    } else {		
		error_log("[".date("F j, Y, G:i")."] [E_USER_NOTICE] [tipo Clase] No se encuentra la clase en el controlador $controller en $controllerLocation \n", 3,$config->get('root').'/errores.log');
		header("Location:index.php?controlador=error404");
	    }

	    //valido si existe el método sino ejecuta la excepcion
	    if( method_exists( $cont, $action ) ) {
		$cont->$action();
	    } else {		
		error_log("[".date("F j, Y, G:i")."] [E_USER_NOTICE] [tipo Accion] La Acción $action no existe $action en la clase $controller en $controllerLocation \n", 3,$config->get('root').'/errores.log');
		header("Location:index.php?controlador=error404");
	    }



	}
	/**
	 * Cargador de clases
	 *
	 * @name loader
	 * @access public
	 *  @version 0.2
	 *  @since 0.1
	 *  @author Lucas M. Sastre
	 */
	public function loader() {
	    $path = str_replace('\\','/',dirname(__FILE__)).'/';

	    //leo el directorio
	    $dir = scandir($path);
	    //valido si es un array y que tenga algun contenido
	    if ((is_array($dir)) && (count($dir) > 0))
		foreach ($dir as $k=>$v)
		//recorro el directorio y valido que sea un archivo php
		    if ( !(is_dir($path.$v)) && ( file_exists($path.$v) ) && ($v != ".") && ($v != "FrontController.php") && ($v != "..") && (strtolower(end(explode(".", $v))) == 'php') )
		    //incluyo el archivo
			include_once($path.$v);
		    elseif ( is_dir($path.$v) && ($v != ".") && ($v != "..") && ($v != 'smarty') && ($v != '.svn')&& ($v != 'ajax'))
			loader($path.$v."/");
	}
    }
?>