<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name staffController.php
     */

    class staffController extends Controller {
	private $Staff;

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
	    $this->Staff = new Staff();
	}

	/**
	 * muestra el index del controlador
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
	    $paginador= $this->Utilidades->paginador($this->Staff->listarStaff(),5);
	    $data['paginador'] = $paginador;
	    if($this->Session->get('mensaje')) {
		$data['mensaje'] = $this->Session->get('mensaje');
		$this->Session->del('mensaje');
	    }
	    $this->Vistas->show('index.html',$data);
	}

	/**
	 * muestra el formulario para crear una Staff
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name nuevaStaff
	 *
	 * Modificaciones
	 */
	public  function nuevaStaff() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $this->Vistas->show('editarStaff.html',$data);
	}

	/**
	 * muestra el formulario para editar una Staff
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarStaff
	 *
	 * Modificaciones
	 */
	public function editarStaff() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Staff->buscarStaff($_REQUEST['id']);
	    $this->Vistas->show('editarStaff.html',$data);
	}

	/**
	 * crea una nueva Staff
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name crearStaff
	 *
	 * Modificaciones
	 */
	public function crearStaff() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $mensaje = $this->validarDatosFormulario($_REQUEST);	    	    
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		$this->Vistas->show('editarStaff.html',$data);
	    }
	    else {		
		$resultado = $this->Staff->crearStaff($_REQUEST);
		if($resultado==true) {
		    $this->Mensajes->agregarMensaje(1,'El Staff se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=staff');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'El Staff no se puedo guardar correctamente.','error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		    $this->Vistas->show('editarStaff.html',$data);
		}
	    }
	}

	/**
	 * editar una Staff
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name guardarStaff
	 *
	 * Modificaciones
	 */
	public function guardarStaff() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $mensaje = $this->validarDatosFormulario($_REQUEST);	   	    
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		$this->Vistas->show('editarStaff.html',$data);
	    }
	    else {			
		$resultado = $this->Staff->editarStaff($_REQUEST);
		if($resultado==true) {
		    $this->Mensajes->agregarMensaje(1,'El Staff se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=staff');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'El Staff no se puedo guardar correctamente.','error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		    $this->Vistas->show('editarStaff.html',$data);
		}
	    }
	}

	/**
	 * borra una Staff
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarStaff
	 *
	 * Modificaciones
	 */
	public function borrarStaff() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $resultado = $this->Staff->borrarStaff($_REQUEST['id']);
	    if($resultado==true) {
		$this->Mensajes->agregarMensaje(1,'El Staff se borro correctamente.','ok');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=staff');
	    }
	    else {
		$this->Mensajes->agregarMensaje(1,'El Staff no se puedo borrar correctamente.','error');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=staff');
	    }
	}

	/**
	 * valida los datos del formulario
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access private
	 * @name validarDatosFormulario
	 *
	 * @param array $data
	 * @return string
	 *
	 * Modificaciones
	 */
	private function validarDatosFormulario($data) {
	    if(empty($data['nombre'])) {
		$mensaje.='El nombr del Staff esta vacío<br/>';
	    }
	    if(empty($data['cargo'])) {
		$mensaje.='El cargo del Staff esta vacío<br/>';
	    }
	    
	    return $mensaje;
	}
    }

?>