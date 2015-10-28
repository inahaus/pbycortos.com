<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     *
     * @name InvitadosModel.php
     */


    class Invitados extends Modelo {

	/**
	 * Lista todas los invitados del sistema
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name listarNotcias
	 *
	 * @return string
	 *
	 * Modificaciones
	 */
	public function listarInvitados() {
	    $sql = "SELECT *
                    FROM invitados
                    ";

	    return $sql;
	}

	/**
	 * Crea una nueva invitados
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name crearInvitados
	 *
	 * @param array $data
	 * @return boolean
	 *
	 * Modificaciones
	 */
	public function crearInvitados($data) {
	    $consulta="";
	    $insert['nombre'] = "'".trim(htmlentities($data['nombre']))."'";
	    $insert['intro'] = "'".trim($data['intro'])."'";
	    $insert['texto'] = "'".trim($data['texto'])."'";
	    if(!empty($data['foto'])){
		$insert['foto'] = "'".trim($data['foto'])."'";
	    }

	    $consulta=$this->db->InsertRow("invitados", $insert);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }
	    
	    return $consulta;
	}

	/**
	 * Busca una invitados
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name buscarInvitados
	 *
	 * @package integer $id
	 * @return array
	 *
	 * Modificaciones
	 */
	public function buscarInvitados($id) {
	    $sql = "SELECT *
                    FROM invitados
                    WHERE
                    id='$id'";

	    $consulta = $this->db->QuerySingleRow($sql);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }

	    return $consulta;
	}

	/**
	 * Edita una invitados
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarInvitados
	 *
	 * @param array $data
	 * @return boolean
	 *
	 * Modificaciones
	 */
	public function editarInvitados($data) {
	    $update['nombre'] = "'".trim(htmlentities($data['nombre']))."'";
	    $update['intro'] = "'".trim($data['intro'])."'";
	    $update['texto'] = "'".trim($data['texto'])."'";
	    if(!empty($data['foto'])){
		$update['foto'] = "'".trim($data['foto'])."'";
	    }
	    
	    $filtro['id'] = $data['id'];

	    $consulta=$this->db->UpdateRows("invitados", $update, $filtro);
	    if(!$consulta) {
		$consulta=$this->db->Error();
	    }

	    return $consulta;
	}

	/**
	 * Borra una invitados
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarInvitados
	 *
	 * @param intenger $id
	 * @return boolean
	 *
	 * Modificaciones
	 */
	public function borrarInvitados($id) {
	    $filtro['id'] = $id;
	    $consulta = $this->db->DeleteRows("invitados", $filtro);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }

	    return $consulta;
	}


	/**
	 * Devuelve todas los invitados
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarInvitados
	 *
	 * @return array
	 *
	 * Modificaciones
	 */
	public function listadoInvitados() {
	    $sql = "SELECT *
                    FROM invitados";
	    $consulta = $this->db->QueryArray($sql);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }

	    return $consulta;
	}
    }