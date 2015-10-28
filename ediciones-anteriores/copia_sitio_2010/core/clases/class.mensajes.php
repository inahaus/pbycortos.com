<?php
/**
* @package Punk Framework
* @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
* @version 0.2
* @author Lucas M. Sastre
* @link http://www.oniricosistemas.com
* @name class.mensajes.php
*/

class Mensajes {
	protected $tipo;
	protected $mensaje;
	protected $nivel;
	private static $instance=null;
	
	public function __construct(){
		$this->tipo = 1;
		$this->mensaje =array();
		$this->nivel ='';
	}
	
	public function agregarMensaje($tipo=1,$mensaje,$nivel){
		$msg='';
		//asigno el mensaje
		$msg=$mensaje;
		//asigno el tipo de mensaje.
		$this->tipo = $tipo;
		//asigno el tipo de nivel
		$this->nivel = $nivel;
		//agrego al array el mensaje.
		array_push($this->mensaje,$msg);					
	}
	
	private function mensajePopup($mensaje,$nivel){
	    $total=count($mensaje);
	    $texto="";
	    for($i=0;$i<$total;$i++){
	        $texto.=$mensaje[$i]."<br/>";
	    }
		switch ($nivel){
			case 'ok':
				$icono="ui-icon ui-icon-check";				
			break;
			case 'error':
				$icono="ui-icon ui-icon-close";				
			break;
			case 'advertencia':
				$icono="ui-icon-alert";				
			break;
		}
		$msg='
			<div id="popup" title="'.$nivel.'" style="display:none;">	
					<p>
						<span class="'.$icono.'" style="float:left; margin:0 7px 50px 0;"></span>
						'.$texto.'
					</p>
			</div>';
	}
	
	private function mensajeNormal($mensaje,$nivel){
	    $total=count($mensaje);
	    $texto="";
	    for($i=0;$i<$total;$i++){
	        $texto.=$mensaje[$i]."<br/>";
	    }	    
		switch ($nivel){
			case 'ok':
				$icono="ui-icon ui-icon-check";
				$clase="ui-state-highlight ui-corner-all";
				$color="#FFF;";
			break;
			case 'error':
				$icono="ui-icon ui-icon-close";
				$clase="ui-state-error ui-corner-all";
				$color="FFF;";
			break;
			case 'advertencia':
				$icono="ui-icon-alert";
				$clase="ui-priority-secondary ui-corner-all";
				$color="#FFF;";
			break;
		}
		$msg='
			<div class="ui-widget" id="mensaje" style="cursor:pointer;">
			<div class="'.$clase.'" style="padding: 0 .7em; margin-top:10px;"> 
				<p style="color:'.$color.'"><span class="'.$icono.'" style="float: left; margin-right: .3em;">&nbsp;</span><br/> 
				<strong style="padding:0 0 50px 0;">'.$texto.'</strong><br/></p>';
		if(!empty($volver) && $icono=='ui-icon ui-icon-check' ){
			$msg.='<p style="padding-left:120px;"><a href="'.$volver.'" title="Volver">Volver</a></p>';
		}
		$msg.='</div>';
		$msg.='</div>';
		return $msg;
	}
	
	public function mostrarMensaje(){
		if($this->tipo==1){
			return $this->mensajeNormal($this->mensaje,$this->nivel);
		}
		else{
			return $this->mensajePopup($this->mensaje,$this->nivel);
		}
	}
	
	/**
	* Creo el patron Singleton
	*
	* @return instance
	*/
	public static function singleton()
	{
		if( self::$instance == null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

?>