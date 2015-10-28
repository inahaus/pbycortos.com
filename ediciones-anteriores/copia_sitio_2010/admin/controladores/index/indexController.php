<?php
/**
* @package Punk Framework
* @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
* @version 0.2
* @author Lucas M. Sastre
* @link http://www.oniricosistemas.com
* @name indexController.php
 */

class indexController extends Controller {
    // variable para el modelo Usuario
    private $Usuario;
    /**
     * Constructor de la clase para instanciar los modelos
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name __contruct
     *
     */
    function __construct() {
        //llamo al consructor de Controller.php
        parent::__construct();
        //creo una instancia del modelo Usuario
        $this->Usuario = new Usuarios();
    }
    /**
     * Funcion index que controla si el admin esta logueado o no
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name index
     *
     * Modificado:
     * 02-08-2010
     *
     */
    public function index() {
        if(!$this->Session->get('admin'.$this->Config->get('app')) || $this->Session->get('admin'.$this->Config->get('app'))=='admin') {
            $data['mensaje']['mensaje']="No estas logueado";
            $data['mensaje']['tipo']="attention";
            $this->Vistas->show('login.html',$data);
        }
        else {
            $data['breadCrumb']=$this->BreadCrumb->listarBreadCrumb($_REQUEST);	    
            $this->Vistas->show('index.html',$data);
        }
    }

    /**
     * realiza el login
     * @version 0.2
     * @author Lucas M. sastre
     * @access public
     * @name login
     *
     * Modificado: 
     * 31-12-2009
     * 06-05-2010
     * 02-08-2010
     *
     */
    public function login() {
        $validacion = $this->validarFormulario($_REQUEST);
        if(!empty($validacion)) {
            $data['mensaje']['mensaje']=$validacion;
            $data['mensaje']['tipo']="fail";
            $this->Vistas->show('login.html',$data);
        }
        else {
            if($this->Session->get('captcha')==$_REQUEST['captcha']) {
                if($this->Usuario->login($_REQUEST)) {
                    $data['breadCrumb']=$this->BreadCrumb->listarBreadCrumb($_REQUEST);
                    $this->Session->set('nombre',$_REQUEST['username']);
                    $data['usuario']=$_REQUEST['username'];
                    $hash = $this->Utilidades->crearPassword(3,'a');
                    $nombre = $_REQUEST['username'].$hash;
		    $this->Session->set('admin'.$this->Config->get('app'),$nombre);
                    $user = $this->Usuario->BuscarUsuarios($_REQUEST);
                    $this->Session->set('user_id',$user->id);
		    //$this->Session->set('nivel',$user->permisos);
                    $this->Utilidades->redirect('index.php');
                }
                else {
                    $data['mensaje']['tipo'] = "fail";
                    $data['mensaje']['mensaje'] = "Nombre de usuario / contraseña incorrecto<br/>";
                    $this->Vistas->show('login.html',$data);
                }
            }
        }

    }

    /**
     * Valida los datos del formulario
     * @version 0.1
     * @author Lucas M. sastre
     * @access private
     * @name validaFormulario
     * Mon Dec 28 23:22:02 ART 2009
     *
     */
    private function validarFormulario($data) {
        if($_REQUEST['username']=='username' || $_REQUEST['username']=='') {
            $mensaje.="No ha ingresado ningun nombre de usuario<br/>";
        }
        if($_REQUEST['password']=='' || $_REQUEST['password']=='password') {
            $mensaje.="no ha ingresado ningún password<br/>";
        }
        if($_REQUEST['captcha']=='') {
            $mensaje.="No ha ingresado el código de seguridad.<br/>";
        }
        if($this->Session->get('captcha')!=$_REQUEST['captcha'] && $_REQUEST['captcha']!='') {
            $mensaje.="El código de seguridad es incorrecto.<br/>";
        }

        return $mensaje;
    }

    /**
     * Sale de la administracion
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name salir
     * Mon Dec 28 23:22:38 ART 2009
     *
     */
    public function salir() {
        if($this->Session->get('admin'.$this->Config->get('app'))!='admin') {
            $this->Session->del('admin'.$this->Config->get('app'));
            $this->Session->del('user_id');
            $this->Session->del('nivel');
        }
        $this->Utilidades->redirect('index.php');
    }

}
?>