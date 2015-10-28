<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     *
     * @name StaffModel.php
     */


    class Staff extends Modelo {

	/**
	 * Lista todas las staff del sistema
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name listarNotcias
	 *
	 * @return string
	 *
	 * Modificaciones
	 */
	public function listarStaff() {
	    $sql = "SELECT *
                    FROM staff
                    ";

	    return $sql;
	}

	/**
	 * Crea una nueva staff
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name crearStaff
	 *
	 * @param array $data
	 * @return boolean
	 *
	 * Modificaciones
	 */
	public function crearStaff($data) {
	    $consulta="";	    
	    $insert['nombre'] = "'".trim($data['nombre'])."'";
	    $insert['cargo'] = "'".trim($data['cargo'])."'";
	    

	    $consulta=$this->db->InsertRow("staff", $insert);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }
	    
	    return $consulta;
	}

	/**
	 * Busca una staff
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name buscarStaff
	 *
	 * @package integer $id
	 * @return array
	 *
	 * Modificaciones
	 */
	public function buscarStaff($id) {
	    $sql = "SELECT *
                    FROM staff
                    WHERE
                    id='$id'";

	    $consulta = $this->db->QuerySingleRow($sql);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }

	    return $consulta;
	}

	/**
	 * Edita una staff
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarStaff
	 *
	 * @param array $data
	 * @return boolean
	 *
	 * Modificaciones
	 */
	public function editarStaff($data) {	    
	    $update['nombre'] = "'".trim($data['nombre'])."'";
	    $update['cargo'] = "'".trim($data['cargo'])."'";
	    
	    
	    $filtro['id'] = $data['id'];

	    $consulta=$this->db->UpdateRows("staff", $update, $filtro);
	    if(!$consulta) {
		$consulta=$this->db->Error();
	    }

	    return $consulta;
	}

	/**
	 * Borra una staff
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarStaff
	 *
	 * @param intenger $id
	 * @return boolean
	 *
	 * Modificaciones
	 */
	public function borrarStaff($id) {
	    $filtro['id'] = $id;
	    $consulta = $this->db->DeleteRows("staff", $filtro);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }

	    return $consulta;
	}


	/**
	 * Devuelve todas las staff
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarStaff
	 *
	 * @return array
	 *
	 * Modificaciones
	 */
	public function listadoStaff() {
	    $sql = "SELECT *
                    FROM staff";
	    $consulta = $this->db->QueryArray($sql);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }

	    return $consulta;
	}
    }