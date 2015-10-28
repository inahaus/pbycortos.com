<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2009 On&iacute;rico Sistemas. Todos los derechos reservados.
     * @version 0.1
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     *
     * @name class.url.php
     */
    class Url {
	protected $url;
	protected $tipo;
	protected $leng;
	protected $base;
	protected $parametros;
	private $config;
	private static $instance=null;

	/**
	 * constructor de la clase
	 *
	 */
	public function __construct() {
	    $this->url = '';
	    $this->tipo = '';
	    $this->leng = '';
	    $this->base = '';
	    $this->parametros = '';
	    $this->config = Config::singleton();
	}

	/**
	 * Creo el patron Singleton
	 *
	 * @return instance
	 */
	public static function singleton() {
	    if( self::$instance == null ) {
		self::$instance = new self();
	    }

	    return self::$instance;
	}

	/**
	 * Seteo el lenguaje si es un sitio multilenguaje
	 *
	 */
	private function setLenguaje() {
	    //$config = Config::singleton();
	    if($this->config->get('multi')==1) {
		if(isset($_SESSION['leng']) && !empty($_SESSION['leng'])) {
		    $this->leng = $_SESSION['leng'];
		}
	    }
	}

	private function setParametros($param) {
	    $this->parametros = '';
	    $valores = explode('index.php?',$param);
	    $valores = explode('&amp;',$valores[1]);
	    $cursor = 0;
	    //$this->parametros .= $valores[0];
	    foreach ($valores as $key => $val) {
		$segmento =  explode('=',$val);
		if($segmento[0]!='leng') {
		    if($key=='controlador') {
			$this->parametros .= strtolower(preg_replace('/([A-Z])/', '-$1',$segmento[1]))."/";
		    }
		    elseif($segmento[0]=='verPagina'){
			$this->parametros .= 'Pagina/'.$segmento[1]."/";
		    }
		    elseif($key!='id') {
			$acentos=array("á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ");
			$sinacentos=array("a","e","i","o","u","n","A","E","I","O","U","N");
			$value=str_replace($acentos,$sinacentos,$segmento[1]);
			$this->parametros .= preg_replace("@[^A-Za-z0-9-]+@i","-",$value)."/";
		    }
		}
	    }
	}

	private function setBase($link) {
	    $base = explode('/',$link);
	    if($base[2]=='index.php') {
		$this->base = 'index.php';
	    }
	    else {
		$this->base = 'noentro.php';
	    }
	}

	public function urlAmigables($url,$tipo=NULL) {
	    $this->url='';
	    $config = Config::singleton();
	    if(empty($tipo)) {
		//valido que la url tendra o no un lenguaje
		$this->setLenguaje();
		if(!empty($this->leng)) {
		    $this->url .= $this->leng."/";
		}
	    }


	    //si es tipo 1 entro a los parametros
	    //seteo si hay parametros
	    $this->setParametros($url);
	    if(!empty($this->parametros)) {
		$this->url .= $this->parametros;
	    }

	    //elimino posibles dobles barras
	    $this->url = preg_replace('/\/$/', '', $this->url).".php";

	    //echo "<pre>";print_r ($this->parametros);echo "</pre>";//exit();

	    return $this->url;

	}


    }
?>