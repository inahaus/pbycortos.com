<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 On�rico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name seoController.php
     */

    class SeoController extends Controller {
	//variable para el modelo Seo
	private $Seo;
	private $Lenguajes;

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
	    $this->Seo = new Seo();
	    $this->Lenguajes = new Lenguajes();
	}

	/**
	 * index del controlador
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name index
	 *
	 * Modificaciones
	 */
	public function index() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $paginador= $this->Utilidades->paginador($this->Seo->listarSeccionesSeo(),5);
	    $data['paginador'] = $paginador;
	    if($this->Session->get('mensaje')) {
		$data['mensaje'] = $this->Session->get('mensaje');
		$this->Session->del('mensaje');
	    }
	    $this->Vistas->show('index.html',$data);
	}

	/**
	 * Muestra la vista para editar
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarSeo
	 *
	 * Modificaciones
	 */
	public function nuevoSeo() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['leng'] = $this->Lenguajes->listadoLenguajes();
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $this->Vistas->show('editarSeo.html',$data);
	}

	/**
	 * Muestra la vista para editar
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarSeo
	 *
	 * Modificaciones
	 */
	public function editarSeo() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['leng'] = $this->Lenguajes->listadoLenguajes();
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Seo->buscarSeccionSeo($_REQUEST);
	    $this->Vistas->show('editarSeo.html',$data);
	}


	/**
	 * Edita SEO
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name guardarSeo
	 *
	 * Modificaciones
	 */
	public function guardarSeo() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);

	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'][0] = $_REQUEST;
		$this->Vistas->show('editarSeo.html',$data);
	    }
	    else {
		//$resultado = $this->Seo->editarSeccionSeo($_REQUEST);
		$leng = $this->Lenguajes->listadoLenguajes();
		$envio = $_REQUEST['seo'];
		$error=0;
		if(!empty($leng)) {
		    foreach ($leng as $key => $val) {
			if(!empty($envio[$val['siglas']]['id'])) {
			    $resultado = $this->Seo->editarSeccionSeo($envio[$val['siglas']]);
			    if(!$resultado) {
				$error++;
			    }
			}
			else {
			    if(!empty($envio[$val['siglas']]['titulo']) || !empty($envio[$val['siglas']]['descripcion']) || !empty($envio[$val['siglas']]['keywords'])) {
				$resultado = $this->Seo->insertarSeccionSeo($envio[$val['siglas']]);
				if(!is_numeric($resultado)) {
				    $error++;
				}
			    }
			}
		    }
		}
		else {
		    $resultado = $this->Seo->editarSeccionSeo($_REQUEST);
		    if(!$resultado) {
			$error++;
		    }
		}

		if($error==0) {
		    $this->Mensajes->agregarMensaje(1,'Las opciones SEO se guardaron correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=Seo');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'Las opciones SEO no se puedieron guardar correctamente.','error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $i=0;
		    foreach ($leng as $key => $val) {
			$seo[]=$envio[$val['siglas']];
		    }
//echo "<pre>";print_r ($seo);echo "</pre>";exit();

		    $seo['seccion'] = $_REQUEST['seo']['seccion'];
		    $seo['subaccion'] = $_REQUEST['seo']['subaccion'];
		    $seo['nombre'] = $_REQUEST['seo']['nombre'];
		    $data['datos'] = $seo;
		    $data['leng'] = $this->Lenguajes->listadoLenguajes();
		    $this->Vistas->show('editarSeo.html',$data);
		}

	    }
	}

	/**
	 * Edita SEO
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name guardarSeo
	 *
	 * Modificaciones
	 */
	public function crearSeo() {
	    $this->Utilidades->validar($this->Session->get('admin'.$this->Config->get('app')));
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    //echo "<pre>";print_r ($_REQUEST);echo "</pre>";

	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $_REQUEST;
		$this->Vistas->show('editarSeo.html',$data);
	    }
	    else {
		//$resultado = $this->Seo->editarSeccionSeo($_REQUEST);
		$leng = $this->Lenguajes->listadoLenguajes();
		$envio = $_REQUEST['seo'];
		$error=0;
		if(!empty($leng)) {
		    foreach ($leng as $key => $val) {
			if(!empty($envio[$val['siglas']]['id'])) {
			    $resultado = $this->Seo->insertarSeccionSeo($envio[$val['siglas']]);
			    if(!$resultado) {
				$error++;
			    }
			}
			else {
			    if(!empty($envio[$val['siglas']]['titulo']) || !empty($envio[$val['siglas']]['descripcion']) || !empty($envio[$val['siglas']]['keywords'])) {
				$resultado = $this->Seo->insertarSeccionSeo($envio[$val['siglas']]);
				if(!is_numeric($resultado)) {
				    $error++;
				}
			    }
			}
		    }
		}
		else {
		    $resultado = $this->Seo->insertarSeccionSeo($_REQUEST);
		}

		if($error==0) {
		    $this->Mensajes->agregarMensaje(1,'Las opciones SEO se guardaron correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=Seo');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'Las opciones SEO no se puedieron guardar correctamente.','error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $i=0;
		    if(!empty($leng)) {
			foreach ($leng as $key => $val) {
			    $seo[]=$envio[$val['siglas']];
			}
			$seo['seccion'] = $_REQUEST['seo']['seccion'];
			$seo['subaccion'] = $_REQUEST['seo']['subaccion'];
			$seo['nombre'] = $_REQUEST['seo']['nombre'];
			$data['datos'] = $seo;
			$data['leng'] = $this->Lenguajes->listadoLenguajes();
			$this->Vistas->show('editarSeo.html',$data);
		    }
		    else {
			$data['datos'] = $_REQUEST;
			$data['leng'] = $this->Lenguajes->listadoLenguajes();
			$this->Vistas->show('editarSeo.html',$data);
		    }
		}
	    }
	}



	/**
	 * Valida los datos enviados por el formulario
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access private
	 * @name validarDatosFormulario
	 * Mon Jan 04 18:44:21 ART 2010
	 *
	 * Modificaciones
	 */
	private function validarDatosFormulario($data) {
	    $leng = $this->Lenguajes->listadoLenguajes();
	    if(!empty($leng)) {
		foreach ($leng as $key => $val) {
		    if(!empty($data[$val['siglas']]['seccion'])) {
			$mensaje.='La secci&oacute;n esta vac&iacute;a<br/>';
		    }
		    if(!empty($data[$val['siglas']]['titulo'])) {
			$mensaje.='El titulo esta vac&iacute;o<br/>';
		    }

		}
	    }
	    else {
		if(empty($data['seccion'])) {
		    $mensaje.='La secci&oacute;n esta vac&iacute;a<br/>';
		}
		if(empty($data['titulo'])) {
		    $mensaje.='El titulo esta vac&iacute;o<br/>';
		}
		if(empty($data['nombres'])) {
		    $mensaje.='El nombre esta vac&iacute;o<br/>';
		}
		if(empty($data['descripcion'])) {
		    $mensaje.='La descripci�n esta vac&iacute;a<br/>';
		}
		if(empty($data['keywords'])) {
		    $mensaje.='Las keywords estan vac&iacute;as<br/>';
		}
	    }

	    return $mensaje;
	}
    }

?>