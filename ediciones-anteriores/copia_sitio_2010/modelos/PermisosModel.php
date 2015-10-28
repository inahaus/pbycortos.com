<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name PermisosModel.php
     */

    class Permisos extends Modelo {
	/**
	 * Devuelve todos los permisos del sistema
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @namelistarPermisos
	 *
	 * @return string
	 *
	 * Modificaciones
	 */
	public function listarPermisos() {
	    $sql="SELECT * FROM core_permisos";

	    return $sql;
	}

	/**
	 * Crea un nuevo lenguaje
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name nuevoLenguaje
	 *
	 * @param $data array
	 * @return array
	 *
	 * Modificaciones
	 */
	public function nuevoPermisos($data) {
	    /*$insert['tipo'] = "'".$data['tipo']."'";
	    $insert['controladores'] = "'".$data['controladores']."'";
	    $insert['acciones'] = "'".$data['acciones']."'";*/
	    $insert['id_usuario'] = "'".$data['id_usuario']."'";
	    $insert['permisos'] = "'".$data['permisos']."'";
	    $consulta=$this->db->InsertRow("core_permisos", $insert);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }
	    else {
		$consulta = $this->db->GetLastInsertID();
	    }

	    return $consulta;
	}

	/**
	 * busca un lenguaje
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name buscarLenguaje
	 *
	 * @param $id integer
	 * @return array
	 *
	 * Modificaciones
	 */
	public function buscarPermisos($id) {
	    $sql="SELECT * FROM core_permisos WHERE id='$id'";
	    $consulta = $this->db->QuerySingleRow($sql);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }
	    return $consulta;
	}

	/**
	 * edita un lenguaje
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarLenguaje
	 *
	 * @param $data array
	 * @return string
	 *
	 * Modificaciones
	 */
	public function editarPermisos($data) {
	    /*$update['tipo'] = "'".$data['tipo']."'";
	    $update['controladores'] = "'".$data['controladores']."'";
	    $update['acciones'] = "'".$data['acciones']."'";*/
	    $update['permisos'] = "'".$data['permisos']."'";
	    $filtro['id'] = $data['id'];

	    $consulta=$this->db->UpdateRows("core_permisos", $update, $filtro);
	    if(!$consulta) {
		$consulta=$this->db->Error();
	    }

	    return $consulta;
	}

	/**
	 * borra un lenguaje
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarLenguaje
	 *
	 * @param $id intenger
	 * @return string
	 *
	 * Modificaciones
	 */
	public function borrarPermisos($id) {
	    $filtro['id'] = $id;
	    $consulta = $this->db->DeleteRows("core_permisos", $filtro);

	    if(!$consulta) {
		$consulta=$this->db->Error();
	    }

	    return $consulta;
	}

	/**
	 * Lista todos los mensaje del sistema
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name listadoPermisos
	 *
	 * @return array
	 *
	 * Modificaciones
	 */
	public function listadoPermisos($data) {
	    $sql="SELECT * FROM core_permisos WHERE 1 ";
	    if(!empty($data['id'])){
		$sql .= "AND id='{$data['id']}'";
	    }
	    if(!empty($data['id_usuario'])){
		$sql .= "AND id_usuario='{$data['tipo']}'";
	    }
	    $consulta = $this->db->QueryArray($sql);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }
	    return $consulta;
	}
    }