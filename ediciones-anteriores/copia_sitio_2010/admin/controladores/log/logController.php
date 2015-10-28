<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     *
     */
    class logController extends Controller {
	private $Logg;

	/**
	 * Constructor de la clase
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name __construct
	 *
	 * Modificaciones
	 */
	function __construct() {
	    //llamo al contructor de Controller.php
	    parent::__construct();

	    //instancio el modelo
	    $this->Logg = new Log();
	}

	/**
	 * Index del controlador
	 * @version 0.1
	 * @author Lucas M. sastre
	 * @access public
	 * @name index
	 *
	 */
	public function index() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));

	    $data['datos'] = $this->Logg->listarLog();
	    $data['breadCrumb']=$this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    if($this->Session->get('mensaje')) {
		$data['mensaje'] = $this->Session->get('mensaje');
		$this->Session->del('mensaje');
	    }
	    $this->Vistas->show('index.html',$data);
	}

	/**
	 * detalle del log
	 * @version 0.1
	 * @author Lucas M. sastre
	 * @access public
	 * @name detalleLog
	 *
	 */
	public function verLog() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));

	    $data['datos'] = $this->Logg->listarLog($_REQUEST['id']);
	    $data['breadCrumb']=$this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $this->Vistas->show('editarLog.html',$data);
	}

	/**
	 * limpia el log
	 * @version 0.1
	 * @author Lucas M. sastre
	 * @access public
	 * @name limpiarLog
	 *
	 */
	public function limparLog() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));

	    $resultado = $this->Logg->vaciarLog();
	    $data['breadCrumb']=$this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $this->Vistas->show('editarLog.html',$data);
	}

	
    }
?>
