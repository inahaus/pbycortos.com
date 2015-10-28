<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     *
     * @name PrensaModel.php
     */


    class Prensa extends Modelo {

	/**
	 * Lista todas los prensa del sistema
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name listarNotcias
	 *
	 * @return string
	 *
	 * Modificaciones
	 */
	public function listarPrensa() {
	    $sql = "SELECT *
                    FROM prensa
                    ";

	    return $sql;
	}

	/**
	 * Crea una nueva prensa
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name crearPrensa
	 *
	 * @param array $data
	 * @return boolean
	 *
	 * Modificaciones
	 */
	public function crearPrensa($data) {
	    $consulta="";
	    $insert['texto'] = "'".trim($data['texto'])."'";
	    $insert['fecha'] = "'".trim($data['fecha'])."'";
	    if(!empty($data['imagen_thumb'])){
		$insert['imagen_thumb'] = "'".trim($data['imagen_thumb'])."'";
	    }
	    if(!empty($data['imagen'])){
		$update['imagen'] = "'".trim($data['imagen'])."'";
	    }

	    $consulta=$this->db->InsertRow("prensa", $insert);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }
	    
	    return $consulta;
	}

	/**
	 * Busca una prensa
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name buscarPrensa
	 *
	 * @package integer $id
	 * @return array
	 *
	 * Modificaciones
	 */
	public function buscarPrensa($id) {
	    $sql = "SELECT *
                    FROM prensa
                    WHERE
                    id='$id'";

	    $consulta = $this->db->QuerySingleRow($sql);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }

	    return $consulta;
	}

	/**
	 * Edita una prensa
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarPrensa
	 *
	 * @param array $data
	 * @return boolean
	 *
	 * Modificaciones
	 */
	public function editarPrensa($data) {	    
	    $update['texto'] = "'".trim($data['texto'])."'";
	    $update['fecha'] = "'".trim($data['fecha'])."'";
	    if(!empty($data['imagen_thumb'])){
		$update['imagen_thumb'] = "'".trim($data['imagen_thumb'])."'";
	    }
	    if(!empty($data['imagen'])){
		$update['imagen'] = "'".trim($data['imagen'])."'";
	    }
	    
	    $filtro['id'] = $data['id'];

	    $consulta=$this->db->UpdateRows("prensa", $update, $filtro);
	    if(!$consulta) {
		$consulta=$this->db->Error();
	    }

	    return $consulta;
	}

	/**
	 * Borra una prensa
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarPrensa
	 *
	 * @param intenger $id
	 * @return boolean
	 *
	 * Modificaciones
	 */
	public function borrarPrensa($id) {
	    $filtro['id'] = $id;
	    $consulta = $this->db->DeleteRows("prensa", $filtro);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }

	    return $consulta;
	}


	/**
	 * Devuelve todas los prensa
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarPrensa
	 *
	 * @return array
	 *
	 * Modificaciones
	 */
	public function listadoPrensa() {
	    $sql = "SELECT *
                    FROM prensa";
	    $consulta = $this->db->QueryArray($sql);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }

	    return $consulta;
	}
    }