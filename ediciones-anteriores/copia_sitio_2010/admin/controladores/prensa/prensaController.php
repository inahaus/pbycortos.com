<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name prensaController.php
     */

    class prensaController extends Controller {
	private $Prensa;

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
	    $this->Prensa = new Prensa();
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
	    $paginador= $this->Utilidades->paginador($this->Prensa->listarPrensa(),5);
	    $data['paginador'] = $paginador;
	    if($this->Session->get('mensaje')) {
		$data['mensaje'] = $this->Session->get('mensaje');
		$this->Session->del('mensaje');
	    }
	    $this->Vistas->show('index.html',$data);
	}

	/**
	 * muestra el formulario para crear una Prensa
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name nuevaPrensa
	 *
	 * Modificaciones
	 */
	public  function nuevaPrensa() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $this->Vistas->show('editarPrensa.html',$data);
	}

	/**
	 * muestra el formulario para editar una Prensa
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarPrensa
	 *
	 * Modificaciones
	 */
	public function editarPrensa() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Prensa->buscarPrensa($_REQUEST['id']);
	    $this->Vistas->show('editarPrensa.html',$data);
	}

	/**
	 * crea una nueva Prensa
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name crearPrensa
	 *
	 * Modificaciones
	 */
	public function crearPrensa() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    $img = $_FILES['imagen'];
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		$this->Vistas->show('editarPrensa.html',$data);
	    }
	    else {
		if(!empty($img['name'])) {
		    // cargo las fotos de la animacion
		    $error=0;
		    $ok=0;
		    $image = $this->Imagen;
		    $nombreFoto = $this->Utilidades->validarNombreArchivo($img['name']);
		    $rutaFotoThumb = $this->Config->get('imagenes')."prensa/pr_th_".$nombreFoto;
		    $rutaFoto = $this->Config->get('imagenes')."prensa/pr_".$nombreFoto;
		    //creo el thumb
		    $image->load($img['tmp_name']);
		    if($image->getHeight>137){
			$image->resize($images->getWidth,137);
		    }	
		    $image->save($rutaFotoThumb) ;
		    //valido si se creo el thumb y si existe
		    if(file_exists($rutaFotoThumb)) {
			$image->load($img['tmp_name']);
			$image->noResize();
			$image->save($rutaFoto);
			//valido si se creo la foto y si existe
			if(file_exists($rutaFoto)) {
			    //seteo los parametros para guardar la foto en la db
			    $_REQUEST['imagen_thumb'] = str_replace($this->Config->get('imagenes'),'',$rutaFotoThumb);
			    $_REQUEST['imagen'] = str_replace($this->Config->get('imagenes'),'',$rutaFoto);
			}
			else {
			    $this->Mensajes->agregarMensaje(1,'No se pudo guardar la siguiente imagen: '.$nombreFoto.' en el directorio:<br/> '.$rutaFoto.'','error');
			    $error++;			   
			}
		    }
		    else {
			$this->Mensajes->agregarMensaje(1,'No se pudo guardar la siguiente imagen thumb: '.$nombreFoto.' en el directorio:<br/> '.$rutaFoto.'','error');
			$error++;			
		    }

		}
		$resultado = $this->Prensa->crearPrensa($_REQUEST);
		if($resultado==true) {
		    $this->Mensajes->agregarMensaje(1,'La Prensa se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=prensa');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'La Prensa no se puedo guardar correctamente.','error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		    $this->Vistas->show('editarPrensa.html',$data);
		}
	    }
	}

	/**
	 * editar una Prensa
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name guardarPrensa
	 *
	 * Modificaciones
	 */
	public function guardarPrensa() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    $img = $_FILES['imagen'];
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		$this->Vistas->show('editarPrensa.html',$data);
	    }
	    else {
		if(!empty($img['name'])) {
		    // cargo las fotos de la animacion
		    $error=0;
		    $ok=0;
		    $image = $this->Imagen;
		    $nombreFoto = $this->Utilidades->validarNombreArchivo($img['name']);
		    $rutaFotoThumb = $this->Config->get('imagenes')."prensa/pr_th_".$nombreFoto;
		    $rutaFoto = $this->Config->get('imagenes')."prensa/pr_".$nombreFoto;
		    //creo el thumb
		    $image->load($img['tmp_name']);
		    if($image->getHeight>137){
			$image->resize($images->getWidth,137);
		    }
		    $image->save($rutaFotoThumb) ;
		    //valido si se creo el thumb y si existe
		    if(file_exists($rutaFotoThumb)) {
			$image->load($img['tmp_name']);
			$image->noResize();
			$image->save($rutaFoto);
			//valido si se creo la foto y si existe
			if(file_exists($rutaFoto)) {
			    //seteo los parametros para guardar la foto en la db
			    $_REQUEST['imagen_thumb'] = str_replace($this->Config->get('imagenes'),'',$rutaFotoThumb);
			    $_REQUEST['imagen'] = str_replace($this->Config->get('imagenes'),'',$rutaFoto);
			}
			else {
			    $this->Mensajes->agregarMensaje(1,'No se pudo guardar la siguiente imagen: '.$nombreFoto.' en el directorio:<br/> '.$rutaFoto.'','error');
			    $error++;			   
			}
		    }
		    else {
			$this->Mensajes->agregarMensaje(1,'No se pudo guardar la siguiente imagen thumb: '.$nombreFoto.' en el directorio:<br/> '.$rutaFoto.'','error');
			$error++;			
		    }

		}
		$resultado = $this->Prensa->editarPrensa($_REQUEST);
		if($resultado==true) {
		    $this->Mensajes->agregarMensaje(1,'La Prensa se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=prensa');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'La Prensa no se puedo guardar correctamente.','error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		    $this->Vistas->show('editarPrensa.html',$data);
		}
	    }
	}

	/**
	 * borra una Prensa
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarPrensa
	 *
	 * Modificaciones
	 */
	public function borrarPrensa() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $resultado = $this->Prensa->borrarPrensa($_REQUEST['id']);
	    if($resultado==true) {
		$this->Mensajes->agregarMensaje(1,'La Prensa se borro correctamente.','ok');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=prensa');
	    }
	    else {
		$this->Mensajes->agregarMensaje(1,'La Prensa no se puedo borrar correctamente.','error');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=prensa');
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
	    
	    if(empty($data['texto'])) {
		$mensaje.='La introducción de la Prensa esta vacía<br/>';
	    }


	    return $mensaje;
	}
    }

?>