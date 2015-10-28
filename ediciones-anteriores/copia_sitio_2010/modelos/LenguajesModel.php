<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name LenguajesModel.php
     */

    class Lenguajes extends Modelo {
	/**
	 * Devuelve todos los lenguajes del sistema
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @namelistarLenguajes
	 *
	 * @return string
	 *
	 * Modificaciones
	 */
	public function listarLenguajes() {
	    $sql="SELECT * FROM core_lenguajes";

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
	public function nuevoLenguajes($data) {
	    $insert['idioma'] = "'".$data['idioma']."'";
	    $insert['siglas'] = "'".$data['siglas']."'";
	    $consulta=$this->db->InsertRow("core_lenguajes", $insert);
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
	public function buscarLenguajes($id) {
	    $sql="SELECT * FROM core_lenguajes WHERE id='$id'";
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
	public function editarLenguajes($data) {
	    $update['idioma'] = "'".$data['idioma']."'";
	    $update['siglas'] = "'".$data['siglas']."'";
	    $filtro['id'] = $data['id'];

	    $consulta=$this->db->UpdateRows("core_lenguajes", $update, $filtro);
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
	public function borrarLenguajes($id) {
	    $filtro['id'] = $id;
	    $consulta = $this->db->DeleteRows("core_lenguajes", $filtro);

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
	 * @name listadoLenguajes
	 *
	 * @return array
	 *
	 * Modificaciones
	 */
	public function listadoLenguajes() {
	    $sql="SELECT * FROM core_lenguajes";
	    $consulta = $this->db->QueryArray($sql);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }
	    return $consulta;
	}
    }