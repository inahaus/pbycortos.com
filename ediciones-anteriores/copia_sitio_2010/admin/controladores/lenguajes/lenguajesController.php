<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name lenguajesController.php
     */

    class lenguajesController extends Controller {
	//variable para el modelo Lenguajes
	private $Lenguajes;
	private $Permisos;

	/**
	 * Constructor de la clase
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name __construct
	 *
	 * Modificaciones
	 */
	function __construct() {
	    //llamo al contructor de Controller.php
	    parent::__construct();

	    //instancio el modelo
	    $this->Lenguajes = new Lenguajes();
	    

	}

	/**
	 * index del controlador
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name index
	 *
	 * Modificaciones
	 */
	public function index() {
	    $this->Utilidades->validar($this->Session->get('admin'));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $paginador= $this->Utilidades->paginador($this->Lenguajes->listarLenguajes(),5);
	    $data['paginador'] = $paginador;
	    if($this->Session->get('mensaje')) {
		$data['mensaje'] = $this->Session->get('mensaje');
		$this->Session->del('mensaje');
	    }
	    $this->Vistas->show('index.html',$data);
	}

	/**
	 * Muestra la vista para editar
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarLenguajes
	 *
	 * Modificaciones
	 */
	public function editarLenguajes() {
	    $this->Utilidades->validar($this->Session->get('admin'));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Lenguajes->buscarLenguajes($_REQUEST);
	    $this->Vistas->show('editarLenguajes.html',$data);
	}


	/**
	 * Edita Usuario
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name guardarLenguajes
	 *
	 * Modificaciones
	 */
	public function crearLenguajes() {
	    $this->Utilidades->validar($this->Session->get('admin'));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);

	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);		
		$this->Vistas->show('editarLenguajes.html',$data);
	    }
	    else {
		$resultado = $this->Lenguajes->nuevoLenguajes($_REQUEST);
		if($resultado==true) {
		    $this->Mensajes->agregarMensaje(1,'El Lenguaje se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=Lenguajes');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'El Lenguaje no se pudo guardar correctamente.','error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();		    
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		    $this->Vistas->show('editarLenguajes.html',$data);
		}
	    }
	}

	/**
	 * Muestra la vista para editar
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarLenguajes
	 *
	 * Modificaciones
	 */
	public function nuevoLenguajes() {
	    $this->Utilidades->validar($this->Session->get('admin'));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Lenguajes->buscarLenguajes($_REQUEST);
	    $this->Vistas->show('editarLenguajes.html',$data);
	}


	/**
	 * Edita Usuario
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name guardarLenguajes
	 *
	 * Modificaciones
	 */
	public function guardarLenguajes() {
	    $this->Utilidades->validar($this->Session->get('admin'));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);

	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		$this->Vistas->show('editarLenguajes.html',$data);
	    }
	    else {		
		$resultado = $this->Lenguajes->editarLenguajes($_REQUEST);
		if($resultado==true) {
		    $this->Mensajes->agregarMensaje(1,'El Lenguaje se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=Lenguajes');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'El Lenguaje no se pudo guardar correctamente.','error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();		    
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		    $this->Vistas->show('editarLenguajes.html',$data);
		}
	    }
	}



	/**
	 * Valida los datos enviados por el formulario
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access private
	 * @name validarDatosFormulario
	 * Mon Jan 04 18:44:21 ART 2010
	 *
	 * Modificaciones
	 */
	private function validarDatosFormulario($data) {
	    if(empty($data['idioma'])) {
		$mensaje .= 'El nombre del idioma esta vacío<br/>';
	    }
	    
	    if(empty($data['siglas'])) {
		$mensaje .= 'Las siglas del idioma estan vacío<br/>';
	    }
	    

	    return $mensaje;
	}
    }
?>