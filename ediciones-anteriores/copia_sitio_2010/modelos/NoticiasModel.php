<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     *
     * @name NoticiasModel.php
     */


    class Noticias extends Modelo {

	/**
	 * Lista todas las noticias del sistema
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name listarNotcias
	 *
	 * @return string
	 *
	 * Modificaciones
	 */
	public function listarNoticias() {
	    $sql = "SELECT *
                    FROM noticias 
                    ORDER BY fecha DESC";

	    return $sql;
	}

	/**
	 * Crea una nueva noticia
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name crearNoticia	 
	 *
	 * @param array $data
	 * @return boolean
	 *
	 * Modificaciones
	 */
	public function crearNoticia($data) {
	    $consulta="";
	    $insert['titulo'] = "'".trim(htmlentities($data['titulo']))."'";
	    $insert['intro'] = "'".trim($data['intro'])."'";
	    $insert['texto'] = "'".trim($data['texto'])."'";
	    $insert['titulo_seo'] = "'".trim(htmlentities($data['titulo']))."'";
	    $insert['desc_seo'] = "'".trim($data['desc_seo'])."'";
	    $insert['keys_seo'] = "'".trim($data['keys_seo'])."'";
	    $insert['video'] = "'".trim($data['video'])."'";
	    if(!empty($data['imagen'])){
		$insert['imagen'] = "'".trim($data['imagen'])."'";
	    }
	    $insert['fecha'] = "NOW()";

	    $consulta=$this->db->InsertRow("noticias", $insert);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }
	    
	    return $consulta;
	}

	/**
	 * Busca una noticia
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name buscarNoticia	 
	 *
	 * @package integer $id
	 * @return array
	 *
	 * Modificaciones
	 */
	public function buscarNoticia($id) {
	    $sql = "SELECT *
                    FROM noticias
                    WHERE
                    id='$id'";

	    $consulta = $this->db->QuerySingleRow($sql);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }

	    return $consulta;
	}

	/**
	 * Edita una noticia
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarNoticia
	 *
	 * @param array $data
	 * @return boolean
	 *
	 * Modificaciones
	 */
	public function editarNoticia($data) {	
	    $update['titulo'] = "'".trim(htmlentities($data['titulo']))."'";
	    $update['intro'] = "'".trim($data['intro'])."'";
	    $update['texto'] = "'".trim($data['texto'])."'";
	    $update['titulo_seo'] = "'".trim(htmlentities($data['titulo_seo']))."'";
	    $update['desc_seo'] = "'".trim($data['desc_seo'])."'";
	    $update['keys_seo'] = "'".trim($data['keys_seo'])."'";
	    $update['fecha'] = "'".trim($data['fecha'])."'";
	    $update['video'] = "'".trim($data['video'])."'";
	    if(!empty($data['imagen'])){
		$update['imagen'] = "'".trim($data['imagen'])."'";
	    }

	    $filtro['id'] = $data['id'];

	    $consulta=$this->db->UpdateRows("noticias", $update, $filtro);
	    if(!$consulta) {
		$consulta=$this->db->Error();
	    }

	    return $consulta;
	}

	/**
	 * Borra una noticia
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarNoticia
	 *
	 * @param intenger $id
	 * @return boolean
	 *
	 * Modificaciones
	 */
	public function borrarNoticia($id) {
	    $filtro['id'] = $id;
	    $consulta = $this->db->DeleteRows("noticias", $filtro);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }

	    return $consulta;
	}


	/**
	 * Devuelve todas las noticias
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarNoticia
	 *
	 * @return array
	 *
	 * Modificaciones
	 */
	public function listadoNoticia() {
	    $sql = "SELECT
                    FROM noticias 
                    ORDER BY fecha DESC";
	    $consulta = $this->db->QueryArray($sql);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }

	    return $consulta;
	}
    }