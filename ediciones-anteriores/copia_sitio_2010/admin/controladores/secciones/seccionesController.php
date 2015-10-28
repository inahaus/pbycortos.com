<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     *
     * @name seccionesController.php
     */

    class seccionesController extends Controller {
	private $Secciones;
	private $Seo;

	/**
	 * Constructor de la clase
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access
	 * @name
	 *
	 * Modificaciones
	 */
	function __construct() {
	    parent::__construct();
	    $this->Secciones = new Secciones();
	    $this->Seo = new Seo();
	}

	/**
	 * Muestra el index del controlador
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name index
	 *
	 * Modificaciones
	 */
	public function index() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $paginador= $this->Utilidades->paginador($this->Secciones->listarSecciones(),5);
	    $data['paginador'] = $paginador;
	    if($this->Session->get('mensaje')) {
		$data['mensaje'] = $this->Session->get('mensaje');
		$this->Session->del('mensaje');
	    }
	    $this->Vistas->show('index.html',$data);
	}

	/**
	 * muestra el formulario para crear una nueva secci&oacute;n
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name nuevaSeccion
	 *
	 * Modificaciones
	 */
	public function nuevaSeccion() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $this->Vistas->show('editarSeccion.html',$data);
	}

	/**
	 * Muestra el formulario para editar una secci&oacute;n
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarSeccion
	 *
	 * Modificaciones
	 */
	public function editarSeccion() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $datos = $this->Secciones->buscarSeccion($_REQUEST['id']);
	    $data['datos'] = $datos[0];
	    $this->Vistas->show('editarSeccion.html',$data);
	}

	/**
	 * Crea una nueva secci&oacute;n
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name crearSeccion
	 *
	 * Modificaciones
	 */
	public function crearSeccion() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $_REQUEST;
		$this->Vistas->show('editarSeccion.html',$data);
	    }
	    else {
		$resultado = $this->Secciones->nuevaSeccion($_REQUEST);
		if(is_numeric($resultado)) {
		    $this->Mensajes->agregarMensaje(1,'La secci&oacute;n se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=secciones');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'La secci&oacute;n no se puedo guardar correctamente.','error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $data['datos'] = $_REQUEST;
		    $this->Vistas->show('editarSeccion.html',$data);
		}
	    }
	}

	/**
	 * Edita una secci&oacute;n
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name guardarSeccion
	 *
	 * Modificaciones
	 */
	public function guardarSeccion() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $_REQUEST;
		$this->Vistas->show('editarSeccion.html',$data);
	    }
	    else {
		$resultado = $this->Secciones->editarSeccion($_REQUEST);
		if($resultado==true) {
		    $this->Mensajes->agregarMensaje(1,'La secci&oacute;n se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=secciones');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'La secci&oacute;n no se puedo guardar correctamente.','error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $data['datos'] = $_REQUEST;
		    $this->Vistas->show('editarSeccion.html',$data);
		}
	    }
	}

	/**
	 * Borra una secci&oacute;n
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarSeccion
	 *
	 * Modificaciones
	 */
	public function borrarSeccion() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $resultado = $this->Secciones->borrarSeccion($_REQUEST['id']);
	    if($resultado==true) {
		$this->Mensajes->agregarMensaje(1,'La secci&oacute;n se borro correctamente.','ok');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=secciones');
	    }
	    else {
		$this->Mensajes->agregarMensaje(1,'La secci&oacute;n no se puedo borrar correctamente.','error');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=secciones');
	    }
	}

	/**
	 * Valida los datos enviados desde el formulario
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access private
	 * @name valdarDatosFormulario
	 *
	 * @param array $data
	 * @return string
	 *
	 *
	 * Modificaciones
	 */
	private function validarDatosFormulario($data) {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    if(empty($data['titulo'])) {
		$mensaje.='El titulo de la secci&oacute;n esta vac&iacute;o<br/>';
	    }
	    if(empty($data['texto'])) {
		$mensaje.='El contenido de la secci&oacute;n esta vac&iacute;o<br/>';
	    }

	    return $mensaje;
	}
    }
