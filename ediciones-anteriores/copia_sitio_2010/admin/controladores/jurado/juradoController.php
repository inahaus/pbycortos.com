<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name juradoController.php
     */

    class juradoController extends Controller {
	private $Jurado;

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
	    $this->Jurado = new Jurado();
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
	    $paginador= $this->Utilidades->paginador($this->Jurado->listarJurado(),5);
	    $data['paginador'] = $paginador;
	    if($this->Session->get('mensaje')) {
		$data['mensaje'] = $this->Session->get('mensaje');
		$this->Session->del('mensaje');
	    }
	    $this->Vistas->show('index.html',$data);
	}

	/**
	 * muestra el formulario para crear una Jurado
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name nuevaJurado
	 *
	 * Modificaciones
	 */
	public  function nuevaJurado() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $this->Vistas->show('editarJurado.html',$data);
	}

	/**
	 * muestra el formulario para editar una Jurado
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarJurado
	 *
	 * Modificaciones
	 */
	public function editarJurado() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Jurado->buscarJurado($_REQUEST['id']);
	    $this->Vistas->show('editarJurado.html',$data);
	}

	/**
	 * crea una nueva Jurado
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name crearJurado
	 *
	 * Modificaciones
	 */
	public function crearJurado() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    $img = $_FILES['foto'];
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		$this->Vistas->show('editarJurado.html',$data);
	    }
	    else {
		if(!empty($img['name'])) {
		    // cargo las fotos de la animacion
		    $error=0;
		    $ok=0;
		    $image = $this->Imagen;
		    $nombreFoto = $this->Utilidades->validarNombreArchivo($img['name']);
		    $rutaFotoThumb = $this->Config->get('imagenes')."jurado/ju_".$nombreFoto;
		    //creo el thumb
		    $image->load($img['tmp_name']);
		    $image->resize(99,99);
		    $image->save($rutaFotoThumb) ;
		    //valido si se creo el thumb y si existe
		    if(file_exists($rutaFotoThumb)) {
			$_REQUEST['foto'] = str_replace($this->Config->get('imagenes'),'',$rutaFotoThumb);
		    }
		    else {
			$this->Mensajes->agregarMensaje(1,'No se pudo guardar la siguiente imagen: '.$nombreFoto.' en el directorio:<br/> '.$rutaFoto.'','error');
			$error++;
		    }

		}
		$_REQUEST['foto'] = str_replace($this->Config->get('imagenes'),'',$rutaFotoThumb);
		$resultado = $this->Jurado->crearJurado($_REQUEST);
		if($resultado==true) {
		    $this->Mensajes->agregarMensaje(1,'La Jurado se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=jurado');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'La Jurado no se puedo guardar correctamente.','error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		    $this->Vistas->show('editarJurado.html',$data);
		}
	    }
	}

	/**
	 * editar una Jurado
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name guardarJurado
	 *
	 * Modificaciones
	 */
	public function guardarJurado() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    $img = $_FILES['foto'];
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		$this->Vistas->show('editarJurado.html',$data);
	    }
	    else {
		if(!empty($img['name'])) {
		    // cargo las fotos de la animacion
		    $error=0;
		    $ok=0;
		    $image = $this->Imagen;
		    $nombreFoto = $this->Utilidades->validarNombreArchivo($img['name']);
		    $rutaFotoThumb = $this->Config->get('imagenes')."jurado/ju_".$nombreFoto;
		    //creo el thumb
		    $image->load($img['tmp_name']);
		    $image->resize(99,99);
		    $image->save($rutaFotoThumb) ;
		    //valido si se creo el thumb y si existe
		    if(file_exists($rutaFotoThumb)) {
			$_REQUEST['foto'] = str_replace($this->Config->get('imagenes'),'',$rutaFotoThumb);
		    }
		    else {
			$this->Mensajes->agregarMensaje(1,'No se pudo guardar la siguiente imagen: '.$nombreFoto.' en el directorio:<br/> '.$rutaFoto.'','error');
			$error++;
		    }

		}		
		$_REQUEST['foto'] = str_replace($this->Config->get('imagenes'),'',$rutaFotoThumb);
		$resultado = $this->Jurado->editarJurado($_REQUEST);
		if($resultado==true) {
		    $this->Mensajes->agregarMensaje(1,'La Jurado se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=jurado');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'La Jurado no se puedo guardar correctamente.','error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		    $this->Vistas->show('editarJurado.html',$data);
		}
	    }
	}

	/**
	 * borra una Jurado
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarJurado
	 *
	 * Modificaciones
	 */
	public function borrarJurado() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $resultado = $this->Jurado->borrarJurado($_REQUEST['id']);
	    if($resultado==true) {
		$this->Mensajes->agregarMensaje(1,'La Jurado se borro correctamente.','ok');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=jurado');
	    }
	    else {
		$this->Mensajes->agregarMensaje(1,'La Jurado no se puedo borrar correctamente.','error');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=jurado');
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
		$mensaje.='El nombre del Jurado esta vacío<br/>';
	    }
	    if(empty($data['intro'])) {
		$mensaje.='La introducción del Jurado esta vacía<br/>';
	    }
	    

	    return $mensaje;
	}
    }

?>