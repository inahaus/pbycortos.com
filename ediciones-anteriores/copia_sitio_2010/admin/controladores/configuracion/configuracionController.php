<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.2
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 *
 */
class configuracionController extends Controller {

    /**
     * Index del controlador
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name index
     * Wed Dec 30 14:01:26 ART 2009
     *
     */
    public function index() {
        $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
        $configuración = new ConfiguracionSitio();
        $datos=$this->validarDatos($configuración->listarConfiguracion());

        if(!$datos) {
            $data['datos'] = $this->validarDatos($configuración->listarConfiguracion());
        }
        else {
            $data['datos'] = $datos;
        }
        $data['breadCrumb']=$this->BreadCrumb->listarBreadCrumb($_REQUEST);
        if($this->Session->get('mensaje')) {
            $data['mensaje'] = $this->Session->get('mensaje');
            $this->Session->del('mensaje');
        }
        $this->Vistas->show('index.html',$data);
    }

    /**
     * Muestra el formulario de edición
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name editar
     * Wed Dec 30 14:02:05 ART 2009
     *
     */
    public function editarConfiguracion() {
        $configuración = new ConfiguracionSitio();
        $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
        $data['datos'] = $this->validarDatos($configuración->listarConfiguracion());
        $data['breadCrumb']=$this->BreadCrumb->listarBreadCrumb($_REQUEST);
        $this->Vistas->show('editar.html',$data);
    }

    /**
     * Guarda los cambios realizados
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name guardar
     * Wed Dec 30 14:02:27 ART 2009
     *
     */
    public function guardarConfiguracion() {
        $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
        $data['breadCrumb']=$this->BreadCrumb->listarBreadCrumb($_REQUEST);
        $configuración = new ConfiguracionSitio();
        $datos = $this->validarFormulario($_REQUEST);
        $resultado=$configuración->guardarConfiguracion($datos);
        if($resultado==true) {
            $this->Mensajes->agregarMensaje(1,'La configuración se guardo correctamente','ok');
            $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());

            //$this->Vistas->show('index.html',$data);
            $this->Utilidades->redirect('index.php?controlador=configuracion');
        }
        else {
            $this->Mensajes->agregarMensaje(1,'La configuración no se puedo guardar correctamente','error');
            $this->Mensajes->agregarMensaje(1,$resultado,'error');
            $data['mensaje'] = $this->Mensajes->mostrarMensaje();
            $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
            $this->Vistas->show('editar.html',$data);
        }
    }

    /**
     * Valida los datos que se envian desde el formulario
     * @version 0.1
     * @author Lucas M. sastre
     * @access private
     * @name validarFormulario
     * Wed Dec 30 14:02:50 ART 2009
     *
     */
    private function validarFormulario($data) {
        $config = Config::singleton();
        if(empty($data['titulo'])) {
            $dato['titulo'] = $config->get('titulo');
        }
        else {
            $dato['titulo'] = $data['titulo'];
        }
        if(empty($data['descripcion'])) {
            $dato['descripcion'] = $config->get('descripcion');
        }
        else {
            $dato['descripcion'] = $data['descripcion'];
        }
        if(empty($data['keywords'])) {
            $dato['keywords'] = $config->get('keywords');
        }
        else {
            $keyword=explode(',',$data['keywords']);
            for($i=0;$i<count($keyword);$i++) {
                if($i<(count($keyword)-1)) {
                    $keywords.=trim($keyword[$i]).",";
                }
                else {
                    $keywords.=trim($keyword[$i]);
                }
            }
            $dato['keywords'] = $keywords;
        }
        if(empty($data['email'])) {
            $dato['email'] = $config->get('email');
        }
        else {
            $dato['email'] = $data['email'];
        }
        if(empty($data['useremail'])) {
            $dato['useremail'] = $config->get('usuario');
        }
        else {
            $dato['useremail'] = $data['useremail'];
        }
        if(empty($data['passemail'])) {
            $dato['passemail'] = $config->get('pass');
        }
        else {
            $dato['passemail'] = $data['passemail'];
        }
        if(empty($data['portemail'])) {
            $dato['portemail'] = $config->get('puerto');
        }
        else {
            $dato['portemail'] = $data['portemail'];
        }
        if(empty($data['hostemail'])) {
            $dato['hostemail'] = $config->get('host');
        }
        else {
            $dato['hostemail'] = $data['hostemail'];
        }
               

        return $dato;
    }

    /**
     * Valida si los datos que se pasan estan vacios, si estan vacios muestra los del archivo de configuracion
     * @version 0.1
     * @author Lucas M. sastre
     * @access private
     * @name validarDatos
     * Wed Dec 30 14:03:22 ART 2009
     *
     */
    private function validarDatos($data) {
        $config = Config::singleton();
        if(empty($data[0]['titulo'])) {
            $datos['titulo'] = $config->get('titulo');
        }
        else {
            $datos['titulo'] =$data[0]['titulo'];
        }
        if(empty($data[0]['descripcion'])) {
            $datos['descripcion'] = $config->get('descripcion');
        }
        else {
            $datos['descripcion'] =$data[0]['descripcion'];
        }
        if(empty($data[0]['keywords'])) {
            $datos['keywords'] = $config->get('keywords');
        }
        else {
            $datos['keywords'] =$data[0]['keywords'];
        }
        if(empty($data[0]['email'])) {
            $datos['email'] = $config->get('email');
        }
        else {
            $datos['email'] =$data[0]['email'];
        }
        if(empty($data[0]['user_email'])) {
            $datos['useremail'] = $config->get('usuario');
        }
        else {
            $datos['useremail'] =$data[0]['user_email'];
        }
        if(empty($data[0]['pass_email'])) {
            $datos['passemail'] = $config->get('pass');
        }
        else {
            $datos['passemail'] =$data[0]['pass_email'];
        }
        if(empty($data[0]['port_email'])) {
            $datos['portemail'] = $config->get('puerto');
        }
        else {
            $datos['portemail'] =$data[0]['port_email'];
        }
        if(empty($data[0]['host_email'])) {
            $datos['hostemail'] = $config->get('host');
        }
        else {
            $datos['hostemail'] =$data[0]['host_email'];
        }       
        return $datos;
    }
}
?>
