<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     *
     * @name EdicionesModel.php
     */


    class Ediciones extends Modelo {

	/**
	 * Lista todas las ediciones del sistema
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name listarNotcias
	 *
	 * @return string
	 *
	 * Modificaciones
	 */
	public function listarEdiciones() {
	    $sql = "SELECT *
                    FROM ediciones
                    ORDER BY fecha DESC";

	    return $sql;
	}

	/**
	 * Crea una nueva ediciones
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name crearEdiciones
	 *
	 * @param array $data
	 * @return boolean
	 *
	 * Modificaciones
	 */
	public function crearEdiciones($data) {
	    $consulta="";
	    $insert['titulo'] = "'".trim(htmlentities($data['titulo']))."'";
	    $insert['fecha'] = "'".trim($data['fecha'])."'";
	    $insert['lugar'] = "'".trim($data['lugar'])."'";
	    $insert['tipo'] = "'".trim($data['tipo'])."'";
	    $insert['jurado'] = "'".trim($data['jurado'])."'";
	    $insert['link'] = "'".trim($data['link'])."'";
	    if(!empty($data['imagen'])){
		$insert['imagen'] = "'".trim($data['imagen'])."'";
	    }

	    $consulta=$this->db->InsertRow("ediciones", $insert);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }
	    
	    return $consulta;
	}

	/**
	 * Busca una ediciones
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name buscarEdiciones
	 *
	 * @package integer $id
	 * @return array
	 *
	 * Modificaciones
	 */
	public function buscarEdiciones($id) {
	    $sql = "SELECT *
                    FROM ediciones
                    WHERE
                    id='$id'";

	    $consulta = $this->db->QuerySingleRow($sql);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }

	    return $consulta;
	}

	/**
	 * Edita una ediciones
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarEdiciones
	 *
	 * @param array $data
	 * @return boolean
	 *
	 * Modificaciones
	 */
	public function editarEdiciones($data) {
	    $update['titulo'] = "'".trim(htmlentities($data['titulo']))."'";
	    $update['fecha'] = "'".trim($data['fecha'])."'";
	    $update['lugar'] = "'".trim($data['lugar'])."'";
	    $update['tipo'] = "'".trim($data['tipo'])."'";
	    $update['jurado'] = "'".trim($data['jurado'])."'";
	    $update['link'] = "'".trim($data['link'])."'";
	    if(!empty($data['imagen'])){
		$update['imagen'] = "'".trim($data['imagen'])."'";
	    }
	    
	    $filtro['id'] = $data['id'];

	    $consulta=$this->db->UpdateRows("ediciones", $update, $filtro);
	    if(!$consulta) {
		$consulta=$this->db->Error();
	    }

	    return $consulta;
	}

	/**
	 * Borra una ediciones
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarEdiciones
	 *
	 * @param intenger $id
	 * @return boolean
	 *
	 * Modificaciones
	 */
	public function borrarEdiciones($id) {
	    $filtro['id'] = $id;
	    $consulta = $this->db->DeleteRows("ediciones", $filtro);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }

	    return $consulta;
	}


	/**
	 * Devuelve todas las ediciones
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarEdiciones
	 *
	 * @return array
	 *
	 * Modificaciones
	 */
	public function listadoEdiciones() {
	    $sql = "SELECT *
                    FROM ediciones";
	    $consulta = $this->db->QueryArray($sql);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }

	    return $consulta;
	}
    }