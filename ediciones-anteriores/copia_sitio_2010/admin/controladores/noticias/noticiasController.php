<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name seoController.php
     */

    class noticiasController extends Controller {
	private $Noticias;

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
	    $this->Noticias = new Noticias();
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
	    $paginador= $this->Utilidades->paginador($this->Noticias->listarNoticias(),5);
	    $data['paginador'] = $paginador;
	    if($this->Session->get('mensaje')) {
		$data['mensaje'] = $this->Session->get('mensaje');
		$this->Session->del('mensaje');
	    }
	    $this->Vistas->show('index.html',$data);
	}

	/**
	 * muestra el formulario para crear una noticia
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name nuevaNoticia
	 *
	 * Modificaciones
	 */
	public  function nuevaNoticia() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $this->Vistas->show('editarNoticia.html',$data);
	}

	/**
	 * muestra el formulario para editar una noticia
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarNoticia
	 *
	 * Modificaciones
	 */
	public function editarNoticia() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Noticias->buscarNoticia($_REQUEST['id']);
	    $this->Vistas->show('editarNoticia.html',$data);
	}

	/**
	 * crea una nueva noticia
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name crearNoticia
	 *
	 * Modificaciones
	 */
	public function crearNoticia() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    $img = $_FILES['imagen'];	    
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		$this->Vistas->show('editarNoticia.html',$data);
	    }
	    else {
		if(!empty($img['name'])) {
		    // cargo las fotos de la animacion
		    $error=0;
		    $ok=0;
		    $image = $this->Imagen;
		    $nombreFoto = $this->Utilidades->validarNombreArchivo($img['name']);
		    $rutaFotoThumb = $this->Config->get('imagenes')."noticias/not_".$nombreFoto;
		    //creo el thumb
		    $image->load($img['tmp_name']);
		    $image->resize(301,133);
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
		$resultado = $this->Noticias->crearNoticia($_REQUEST);
		if($resultado==true) {
		    $this->Mensajes->agregarMensaje(1,'La noticia se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=noticias');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'La noticia no se puedo guardar correctamente.','error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		    $this->Vistas->show('editarNoticia.html',$data);
		}
	    }
	}

	/**
	 * editar una noticia
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name guardarNoticia
	 *
	 * Modificaciones
	 */
	public function guardarNoticia() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    $img = $_FILES['imagen'];	    
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		$this->Vistas->show('editarNoticia.html',$data);
	    }
	    else {
		if(!empty($img['name'])) {
		    // cargo las fotos de la animacion
		    $error=0;
		    $ok=0;
		    $image = $this->Imagen;
		    $nombreFoto = $this->Utilidades->validarNombreArchivo($img['name']);
		    $rutaFotoThumb = $this->Config->get('imagenes')."noticias/not_".$nombreFoto;		    
		    //creo el thumb
		    $image->load($img['tmp_name']);
		    $image->resize(301,133);
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
		$resultado = $this->Noticias->editarNoticia($_REQUEST);
		if($resultado==true) {
		    $this->Mensajes->agregarMensaje(1,'La noticia se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=noticias');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'La noticia no se puedo guardar correctamente.','error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		    $this->Vistas->show('editarNoticia.html',$data);
		}
	    }
	}

	/**
	 * borra una noticia
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarNoticia
	 *
	 * Modificaciones
	 */
	public function borrarNoticia() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $resultado = $this->Noticias->borrarNoticia($_REQUEST['id']);
	    if($resultado==true) {
		$this->Mensajes->agregarMensaje(1,'La noticia se borro correctamente.','ok');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=noticias');
	    }
	    else {
		$this->Mensajes->agregarMensaje(1,'La noticia no se puedo borrar correctamente.','error');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=noticias');
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
		$mensaje.='El titulo de la noticia esta vacío<br/>';
	    }
	    if(empty($data['intro'])) {
		$mensaje.='La introducción de la noticia esta vacía<br/>';
	    }
	    if(isset($data['fecha']) && empty($data['fecha']) && $data['accion']!=='guardarNoticia') {
		$mensaje.='La fecha de la noticia esta vacía<br/>';
	    }

	    return $mensaje;
	}
    }

?>