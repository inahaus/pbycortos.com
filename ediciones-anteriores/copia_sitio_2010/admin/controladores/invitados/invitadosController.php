<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 On�rico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name invitadosController.php
     */

    class invitadosController extends Controller {
	private $Invitados;

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
	    $this->Invitados = new Invitados();
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
	    $paginador= $this->Utilidades->paginador($this->Invitados->listarInvitados(),5);
	    $data['paginador'] = $paginador;
	    if($this->Session->get('mensaje')) {
		$data['mensaje'] = $this->Session->get('mensaje');
		$this->Session->del('mensaje');
	    }
	    $this->Vistas->show('index.html',$data);
	}

	/**
	 * muestra el formulario para crear una Invitados
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name nuevaInvitados
	 *
	 * Modificaciones
	 */
	public  function nuevaInvitados() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $this->Vistas->show('editarInvitados.html',$data);
	}

	/**
	 * muestra el formulario para editar una Invitados
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarInvitados
	 *
	 * Modificaciones
	 */
	public function editarInvitados() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Invitados->buscarInvitados($_REQUEST['id']);
	    $this->Vistas->show('editarInvitados.html',$data);
	}

	/**
	 * crea una nueva Invitados
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name crearInvitados
	 *
	 * Modificaciones
	 */
	public function crearInvitados() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    $img = $_FILES['foto'];
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		$this->Vistas->show('editarInvitados.html',$data);
	    }
	    else {
		if(!empty($img['name'])) {
		    // cargo las fotos de la animacion
		    $error=0;
		    $ok=0;
		    $image = $this->Imagen;
		    $nombreFoto = $this->Utilidades->validarNombreArchivo($img['name']);
		    $rutaFotoThumb = $this->Config->get('imagenes')."invitados/inv_".$nombreFoto;
		    //creo el thumb
		    $image->load($img['tmp_name']);
		    if($image->getWidth<106 && $image->getHeight<99){
			$image->noResize();
		    }
		    elseif($image->getHeight<99 && $images->getWidth>106){
			$image->resize(106,$image->getHeight);
		    }
		    elseif($image->getHeight>99 && $images->getWidth<106){
			$image->resize($images->getWidth,99);
		    }
		    else{
			$image->resize(106,99);
		    }
		    //$image->resize(99,99);
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
		$resultado = $this->Invitados->crearInvitados($_REQUEST);
		if($resultado==true) {
		    $this->Mensajes->agregarMensaje(1,'La Invitados se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=invitados');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'La Invitados no se puedo guardar correctamente.','error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		    $this->Vistas->show('editarInvitados.html',$data);
		}
	    }
	}

	/**
	 * editar una Invitados
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name guardarInvitados
	 *
	 * Modificaciones
	 */
	public function guardarInvitados() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    $img = $_FILES['foto'];
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		$this->Vistas->show('editarInvitados.html',$data);
	    }
	    else {
		if(!empty($img['name'])) {
		    // cargo las fotos de la animacion
		    $error=0;
		    $ok=0;
		    $image = $this->Imagen;
		    $nombreFoto = $this->Utilidades->validarNombreArchivo($img['name']);
		    $rutaFotoThumb = $this->Config->get('imagenes')."invitados/inv_".$nombreFoto;
		    //creo el thumb
		    $image->load($img['tmp_name']);
		    if($image->getWidth<106 && $image->getHeight<99){
			$image->noResize();
		    }
		    elseif($image->getHeight<99 && $images->getWidth>106){
			$image->resize(106,$image->getHeight);
		    }
		    elseif($image->getHeight>99 && $images->getWidth<106){
			$image->resize($images->getWidth,99);
		    }
		    else{
			$image->resize(106,99);
		    }
		    //$image->resize(99,99);
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
		$resultado = $this->Invitados->editarInvitados($_REQUEST);
		if($resultado==true) {
		    $this->Mensajes->agregarMensaje(1,'La Invitados se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=invitados');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'La Invitados no se puedo guardar correctamente.','error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		    $this->Vistas->show('editarInvitados.html',$data);
		}
	    }
	}

	/**
	 * borra una Invitados
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarInvitados
	 *
	 * Modificaciones
	 */
	public function borrarInvitados() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $resultado = $this->Invitados->borrarInvitados($_REQUEST['id']);
	    if($resultado==true) {
		$this->Mensajes->agregarMensaje(1,'La Invitados se borro correctamente.','ok');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=invitados');
	    }
	    else {
		$this->Mensajes->agregarMensaje(1,'La Invitados no se puedo borrar correctamente.','error');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=invitados');
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
		$mensaje.='El nombre del Invitados esta vac�o<br/>';
	    }
	    if(empty($data['intro'])) {
		$mensaje.='La introducci�n del Invitados esta vac�a<br/>';
	    }
	    

	    return $mensaje;
	}
    }

?>