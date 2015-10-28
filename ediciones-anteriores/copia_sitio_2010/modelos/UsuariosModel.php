<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name UsuariosModel.php
     */

    class Usuarios extends Modelo {

	/**
	 * Lista todos los usuarios del sistema
	 *
	 * @return <array>
	 */
	public function listarUsuarios() {
	    $sql = "SELECT * FROM core_users";

	    return $sql;
	}

	/**
	 * Borra una un usuario
	 */
	public function borrarUsuarios($id) {
	    $filtro['id'] = $id;
	    $consulta = $this->db->DeleteRows("core_users", $filtro);

	    if(!$consulta) {
		$consulta=$this->db->Error();
	    }

	    return $consulta;
	}

	/**
	 * busca un usuario
	 *
	 * @return <array>
	 */
	public function  buscarUsuarios($data) {
	    $sql = "SELECT * FROM core_users WHERE 1 ";
	    if(!empty($data['id'])) {
		$sql .= " AND id='{$data['id']}'";
	    }
	    if(!empty($data['username'])) {
		$sql .= " AND username='{$data['username']}'";
	    }
	    $consulta=$this->db->QuerySingleRow($sql);
	    if(!$consulta) {
		$consulta=$this->db->Error();
	    }
	    return $consulta;
	}

	/**
	 * crea un nuevo usuario de sistema
	 * @param <array> $data
	 * @return <integer>  $consulta
	 */
	public function nuevoUsuarios($data) {
	    $insert['username'] = "'".trim($data['username'])."'";
	    $insert['password'] = "'".md5(trim($data['password']))."'";
	    $insert['email']	= "'".trim($data['email'])."'";
	    $insert['nombre']	= "'".trim($data['nombre'])."'";
	    $insert['apellido'] = "'".trim($data['apellido'])."'";
	    $insert['estado']	= "'".trim($data['estado'])."'";
	    $consulta=$this->db->InsertRow("core_users", $insert);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }
	    else {
		$consulta = $this->db->GetLastInsertID();
	    }

	    return $consulta;

	}


	/**
	 * Edita un usuario del sistema
	 * @param <array> $data
	 * @return <bool>
	 */
	public function editarUsuarios($data) {
	    $update['username'] = "'".trim($data['username'])."'";
	    if(!empty($data['password'])){
		$update['password'] = "'".md5(trim($data['password']))."'";
	    }
	    $update['email']	= "'".trim($data['email'])."'";
	    $update['nombre']	= "'".trim($data['nombre'])."'";
	    $update['apellido'] = "'".trim($data['apellido'])."'";
	    $update['estado']	= "'".trim($data['estado'])."'";
	    $filtro['id'] = $data['id'];

	    $consulta=$this->db->UpdateRows("core_users", $update, $filtro);
	    if(!$consulta) {
		$consulta=$this->db->Error();
	    }

	    return $consulta;
	}

	/**
	 * Hace el login de los usuarios
	 * @param <array> $data
	 * @return <integer>
	 */
	public function login($data) {
	    $consulta=$this->db->Query("SELECT * FROM core_users WHERE username='".trim($data['username'])."' AND password='".md5(trim($data['password']))."' AND estado='activo'");
	    if(!$consulta) {
		return $this->db->Error();
	    }
	    return $this->db->RowCount();
	}

    }
?>