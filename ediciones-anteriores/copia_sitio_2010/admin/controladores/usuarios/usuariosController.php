<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name usuariosController.php
     */

    class usuariosController extends Controller {
	//variable para el modelo Usuarios
	private $Usuarios;	
	//private $Permisos;



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
	    $this->Usuarios = new Usuarios();
	    //$this->Permisos = new Permisos();


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
	    echo __METHOD__;exit();
	    $this->Utilidades->validar($this->Session->get('admin'));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $paginador= $this->Utilidades->paginador($this->Usuarios->listarUsuarios(),5);
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
	 * @name editarUsuarios
	 *
	 * Modificaciones
	 */
	public function editarUsuarios() {
	    $this->Utilidades->validar($this->Session->get('admin'));
	    $data['permisos'] = $this->PermisosUsuarios->listarPermisos($this->Config->get('root').$this->Config->get('adminControllerFolder'));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Usuarios->buscarUsuarios($_REQUEST);
	    $this->Vistas->show('editarUsuarios.html',$data);
	}


	/**
	 * Edita Usuario
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name guardarUsuarios
	 *
	 * Modificaciones
	 */
	public function crearUsuarios() {
	    $this->Utilidades->validar($this->Session->get('admin'));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);

	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		$data['permisos'] = $this->PermisosUsuarios->listarPermisos($this->Config->get('root').$this->Config->get('adminControllerFolder'));
		$this->Vistas->show('editarUsuarios.html',$data);
	    }
	    else {
		$resultado = $this->Usuarios->nuevoUsuarios($_REQUEST);
		
		//if(resultado==true && $permisos==true){
		if($resultado==true) {
		    $_REQUEST['id_usuario'] = $resultado;
		    $permisos = $this->Permisos->editarPermisos($_REQUEST);
		    $this->Mensajes->agregarMensaje(1,'El Usuario se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=Usuarios');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'El Usuario no se pudo guardar correctamente.','error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();		    
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		    $data['permisos'] = $this->PermisosUsuarios->listarPermisos($this->Config->get('root').$this->Config->get('adminControllerFolder'));
		    $this->Vistas->show('editarUsuarios.html',$data);
		}
	    }
	}

	/**
	 * Muestra la vista para editar
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarUsuarios
	 *
	 * Modificaciones
	 */
	public function nuevoUsuarios() {
	    $this->Utilidades->validar($this->Session->get('admin'));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Usuarios->buscarUsuarios($_REQUEST);
	    $data['permisos'] = $this->PermisosUsuarios->listarPermisos($this->Config->get('root').$this->Config->get('adminControllerFolder'));
	    $this->Vistas->show('editarUsuarios.html',$data);
	}


	/**
	 * Edita Usuario
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name guardarUsuarios
	 *
	 * Modificaciones
	 */
	public function guardarUsuarios() {
	    $this->Utilidades->validar($this->Session->get('admin'));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);

	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		$data['permisos'] = $this->PermisosUsuarios->listarPermisos($this->Config->get('root').$this->Config->get('adminControllerFolder'));
		$this->Vistas->show('editarUsuarios.html',$data);
	    }
	    else {
		if(!empty($_REQUEST['password']) && $_REQUEST['password']==$_REQUEST['clave']){
		    $_REQUEST['password'] = $_REQUEST['clave'];
		}
		elseif(!empty($_REQUEST['password'])){
		    $_REQUEST['password'] = md5($_REQUEST['password']);
		}
		$resultado = $this->Usuarios->editarUsuarios($_REQUEST);
		//$permisos = $this->Permisos->editarPermisos($_REQUEST);
		//if(resultado==true && $permisos==true){
		if($resultado==true) {
		    $this->Mensajes->agregarMensaje(1,'El Usuario se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=Usuarios');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'El Usuario no se pudo guardar correctamente.','error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();		    
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		    $data['permisos'] = $this->PermisosUsuarios->listarPermisos($this->Config->get('root').$this->Config->get('adminControllerFolder'));
		    $this->Vistas->show('editarUsuarios.html',$data);
		}
	    }
	}

	public function borrarUsuarios(){
	    
	}



	/**
	 * Valida los datos enviados por el formulario
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access private
	 * @name validarDatosFormulario
	 *
	 * Modificaciones
	 */
	private function validarDatosFormulario($data) {
	    echo"<pre>";
	    print_r($data);
	    echo"</pre>";
	    echo "serializado: ".serialize($data['controlador']);
	    echo "<br/> normal: <br/>";
	    echo"<pre>";
	    print_r(unserialize(serialize($data['controlador'])));
	    echo"</pre>";

	    exit();
	    if(empty($data['username'])) {
		$mensaje .= 'El nombre de Usuario esta vacío<br/>';
	    }

	    if(!empty($data['email']) && !$this->Utilidades->validar_mail($data['email'])) {
		$mensaje .= 'El email esta vacío o es invalido<br/>';
	    }
	    if(empty($data['estado'])) {
		$mensaje .= 'No ha seleccionado un estado para el usuario<br/>';
	    }
	    

	    return $mensaje;
	}
    }

    
?>