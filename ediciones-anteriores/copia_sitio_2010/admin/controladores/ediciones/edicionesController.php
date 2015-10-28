<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name edicionesController.php
     */

    class edicionesController extends Controller {
	private $Ediciones;

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
	    $this->Ediciones = new Ediciones();
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
	    $paginador= $this->Utilidades->paginador($this->Ediciones->listarEdiciones(),5);
	    $data['paginador'] = $paginador;
	    if($this->Session->get('mensaje')) {
		$data['mensaje'] = $this->Session->get('mensaje');
		$this->Session->del('mensaje');
	    }
	    $this->Vistas->show('index.html',$data);
	}

	/**
	 * muestra el formulario para crear una Ediciones
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name nuevaEdiciones
	 *
	 * Modificaciones
	 */
	public  function nuevaEdiciones() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $this->Vistas->show('editarEdicion.html',$data);
	}

	/**
	 * muestra el formulario para editar una Ediciones
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarEdiciones
	 *
	 * Modificaciones
	 */
	public function editarEdiciones() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Ediciones->buscarEdiciones($_REQUEST['id']);
	    $this->Vistas->show('editarEdicion.html',$data);
	}

	/**
	 * crea una nueva Ediciones
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name crearEdiciones
	 *
	 * Modificaciones
	 */
	public function crearEdiciones() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    $img = $_FILES['imagen'];	    
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		$this->Vistas->show('editarEdicion.html',$data);
	    }
	    else {
		if(!empty($img['name'])) {
		    // cargo las fotos de la animacion
		    $error=0;
		    $ok=0;
		    $image = $this->Imagen;
		    $nombreFoto = $this->Utilidades->validarNombreArchivo($img['name']);
		    $rutaFotoThumb = $this->Config->get('imagenes')."ediciones/ed_".$nombreFoto;
		    //creo el thumb
		    $image->load($img['tmp_name']);
		    $image->resize(299,133);
		    $image->save($rutaFotoThumb) ;
		    //valido si se creo el thumb y si existe
		    if(file_exists($rutaFotoThumb)) {
			$_REQUEST['imagen'] = str_replace($this->Config->get('imagenes'),'',$rutaFotoThumb);
		    }
		    else {
			$this->Mensajes->agregarMensaje(1,'No se pudo guardar la siguiente imagen: '.$nombreFoto.' en el directorio:<br/> '.$rutaFoto.'','error');
			$error++;
		    }

		}
		$_REQUEST['imagen'] = str_replace($this->Config->get('imagenes'),'',$rutaFotoThumb);
		$resultado = $this->Ediciones->crearEdiciones($_REQUEST);
		if($resultado==true) {
		    $this->Mensajes->agregarMensaje(1,'La Ediciones se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=ediciones');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'La Ediciones no se puedo guardar correctamente.','error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		    $this->Vistas->show('editarEdicion.html',$data);
		}
	    }
	}

	/**
	 * editar una Ediciones
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name guardarEdiciones
	 *
	 * Modificaciones
	 */
	public function guardarEdiciones() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    $img = $_FILES['imagen'];	    
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		$this->Vistas->show('editarEdicion.html',$data);
	    }
	    else {
		if(!empty($img['name'])) {
		    // cargo las fotos de la animacion
		    $error=0;
		    $ok=0;
		    $image = $this->Imagen;
		    $nombreFoto = $this->Utilidades->validarNombreArchivo($img['name']);
		    $rutaFotoThumb = $this->Config->get('imagenes')."ediciones/ed_".$nombreFoto;
		    //creo el thumb
		    $image->load($img['tmp_name']);
		    $image->resize(299,133);
		    $image->save($rutaFotoThumb) ;
		    //valido si se creo el thumb y si existe
		    if(file_exists($rutaFotoThumb)) {
			$_REQUEST['imagen'] = str_replace($this->Config->get('imagenes'),'',$rutaFotoThumb);
		    }
		    else {
			$this->Mensajes->agregarMensaje(1,'No se pudo guardar la siguiente imagen: '.$nombreFoto.' en el directorio:<br/> '.$rutaFoto.'','error');
			$error++;
		    }

		}		
		$_REQUEST['imagen'] = str_replace($this->Config->get('imagenes'),'',$rutaFotoThumb);		
		$resultado = $this->Ediciones->editarEdiciones($_REQUEST);
		if($resultado==true) {
		    $this->Mensajes->agregarMensaje(1,'La Ediciones se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=ediciones');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'La Ediciones no se puedo guardar correctamente.','error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		    $this->Vistas->show('editarEdicion.html',$data);
		}
	    }
	}

	/**
	 * borra una Ediciones
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarEdiciones
	 *
	 * Modificaciones
	 */
	public function borrarEdiciones() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $resultado = $this->Ediciones->borrarEdiciones($_REQUEST['id']);
	    if($resultado==true) {
		$this->Mensajes->agregarMensaje(1,'La Ediciones se borro correctamente.','ok');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=ediciones');
	    }
	    else {
		$this->Mensajes->agregarMensaje(1,'La Ediciones no se puedo borrar correctamente.','error');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=ediciones');
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
	    if(empty($data['titulo'])) {
		$mensaje.='El titulo de la Edicion esta vacío<br/>';
	    }
	    if(empty($data['lugar'])) {
		$mensaje.='El lugar de la Edicion esta vacía<br/>';
	    }
	    if(isset($data['fecha']) && empty($data['fecha']) && $data['accion']!=='guardarEdiciones') {
		$mensaje.='La fecha de la Edicion esta vacía<br/>';
	    }

	    return $mensaje;
	}
    }

?>