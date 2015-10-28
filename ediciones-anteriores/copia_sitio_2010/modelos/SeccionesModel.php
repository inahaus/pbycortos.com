<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * 
     * @name SeccionesModel.php
     */

    class Secciones extends Modelo {
	/**
	 * Devuelve el listado de secciones
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name listarSecciones
	 *
	 * @return string
	 *
	 * Modificaciones
	 */
	public function listarSecciones() {
	    $sql="SELECT * FROM secciones order by id ASC";

	    return $sql;
	}

	/**
	 * crea una nueva seccion
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name nuevaSeccion
	 *
	 * @param array $data
	 * @return integer
	 *
	 * Modificaciones
	 */
	public function nuevaSeccion($data) {
	    $consulta="";
	    $insert['titulo'] = "'".trim($data['titulo'])."'";
	    $insert['texto'] = "'".$data['texto']."'";

	    $consulta=$this->db->InsertRow("secciones", $insert);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }
	    else {
		$consulta = $this->db->GetLastInsertID();
	    }

	    return $consulta;
	}

	/**
	 * devuelve una seccion
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name buscarSeccion
	 *
	 * @param integer $id
	 * @return array
	 *
	 * Modificaciones
	 */
	public function buscarSeccion($id) {
	    $sql="SELECT * FROM secciones WHERE id='$id'";
	    $consulta = $this->db->QueryArray($sql);

	    return $consulta;
	}

	/**
	 * edita una seccion
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarSeccion
	 *
	 * @param array $data
	 * @return boolean
	 *
	 * Modificaciones
	 */
	public function editarSeccion($data) {
	    $update['titulo'] = "'".trim($data['titulo'])."'";
	    $update['texto'] = "'".$data['texto']."'";

	    $filtro['id'] = $data['id'];

	    $consulta=$this->db->UpdateRows("secciones", $update, $filtro);

	    if(!$consulta) {
		$consulta=$this->db->Error();
	    }

	    return $consulta;
	}

	/**
	 * borra seccion
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borraSeccion
	 *
	 * @param integer $i
	 * @return boolean
	 *
	 * Modificaciones
	 */
	public function borrarSeccion($id) {
	    $filtro['id'] = $id;
	    $consulta = $this->db->DeleteRows("secciones", $filtro);

	    return $consulta;
	}

	/**
	 * busca una seccion segun el titulo
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name datosSeccion
	 *
	 * @param string $nombre
	 * @return array
	 *
	 * Modificaciones
	 */
	public function datosSeccion($nombre) {
	    $sql="SELECT * FROM secciones WHERE titulo like '%$nombre%'";
	    $consulta = $this->db->QuerySingleRow($sql);

	    return $consulta;
	}
    }