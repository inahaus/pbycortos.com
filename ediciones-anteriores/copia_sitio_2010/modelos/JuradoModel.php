<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     *
     * @name JuradoModel.php
     */


    class Jurado extends Modelo {

	/**
	 * Lista todas las jurado del sistema
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name listarNotcias
	 *
	 * @return string
	 *
	 * Modificaciones
	 */
	public function listarJurado() {
	    $sql = "SELECT *
                    FROM jurado
                    ";

	    return $sql;
	}

	/**
	 * Crea una nueva jurado
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name crearJurado
	 *
	 * @param array $data
	 * @return boolean
	 *
	 * Modificaciones
	 */
	public function crearJurado($data) {
	    $consulta="";
	    $insert['nombre'] = "'".trim(htmlentities($data['nombre']))."'";
	    $insert['intro'] = "'".trim($data['intro'])."'";
	    $insert['texto'] = "'".trim($data['texto'])."'";
	    if(!empty($data['foto'])){
		$insert['foto'] = "'".trim($data['foto'])."'";
	    }

	    $consulta=$this->db->InsertRow("jurado", $insert);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }
	    
	    return $consulta;
	}

	/**
	 * Busca una jurado
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name buscarJurado
	 *
	 * @package integer $id
	 * @return array
	 *
	 * Modificaciones
	 */
	public function buscarJurado($id) {
	    $sql = "SELECT *
                    FROM jurado
                    WHERE
                    id='$id'";

	    $consulta = $this->db->QuerySingleRow($sql);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }

	    return $consulta;
	}

	/**
	 * Edita una jurado
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarJurado
	 *
	 * @param array $data
	 * @return boolean
	 *
	 * Modificaciones
	 */
	public function editarJurado($data) {
	    $update['nombre'] = "'".trim(htmlentities($data['nombre']))."'";
	    $update['intro'] = "'".trim($data['intro'])."'";
	    $update['texto'] = "'".trim($data['texto'])."'";
	    if(!empty($data['foto'])){
		$update['foto'] = "'".trim($data['foto'])."'";
	    }
	    
	    $filtro['id'] = $data['id'];

	    $consulta=$this->db->UpdateRows("jurado", $update, $filtro);
	    if(!$consulta) {
		$consulta=$this->db->Error();
	    }

	    return $consulta;
	}

	/**
	 * Borra una jurado
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarJurado
	 *
	 * @param intenger $id
	 * @return boolean
	 *
	 * Modificaciones
	 */
	public function borrarJurado($id) {
	    $filtro['id'] = $id;
	    $consulta = $this->db->DeleteRows("jurado", $filtro);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }

	    return $consulta;
	}


	/**
	 * Devuelve todas las jurado
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarJurado
	 *
	 * @return array
	 *
	 * Modificaciones
	 */
	public function listadoJurado() {
	    $sql = "SELECT *
                    FROM jurado";
	    $consulta = $this->db->QueryArray($sql);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }

	    return $consulta;
	}
    }