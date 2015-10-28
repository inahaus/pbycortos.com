<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 On�rico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name error404Controller.php
     */
    class error404Controller extends Controller {
	function index() {
	    $this->Utilidades->validar($this->Session->get('admin'));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    if($this->Session->get('mensaje')) {
		$data['mensaje'] = $this->Session->get('mensaje');
		$this->Session->del('mensaje');
	    }
	    else {
		$data['mensaje'] = "La p�gina a la que intenta ingresar no existe";
	    }
	    $this->Vistas->show('index.html',$data);
	}
    }
?>