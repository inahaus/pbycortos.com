<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name UsuariosModel.php
     */

    class ConfiguracionSitio extends Modelo {

	/**
	 * Devuelve la configuracion guardada en la base de datos
	 * @version 0.2
	 * @author Lucas M. sastre
	 * @access public
	 * @name listarConfiguracion

	 * @return array
	 */
	public function listarConfiguracion() {	    
	    $consulta=$this->db->QueryArray('SELECT * FROM core_configuracion');	    

	    return $consulta;
	}
	/**
	 * Gurda la configuración del sitio
	 * @version 0.1
	 * @author Lucas M. sastre
	 * @access public
	 * @name guardarConfiguracion

	 *
	 */
	public function guardarConfiguracion($data) {
	    $update['titulo'] = "'".$data['titulo']."'";
	    $update['descripcion'] = "'".$data['descripcion']."'";
	    $update['keywords'] = "'".$data['keywords']."'";
	    $update['email'] = "'".$data['email']."'";
	    $update['user_email'] = "'".$data['useremail']."'";
	    $update['pass_email'] = "'".$data['passemail']."'";
	    $update['port_email'] = "'".$data['portemail']."'";
	    $update['host_email'] = "'".$data['hostemail']."'";
	    $filtro['id'] = 1;

	    if(!$consulta=$this->db->UpdateRows("core_configuracion", $update, $filtro)) {
		$consulta=$this->db->Error();
	    }

	    return $consulta;
	}
    }
?>