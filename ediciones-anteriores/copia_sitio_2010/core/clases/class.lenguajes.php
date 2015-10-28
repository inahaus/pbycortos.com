<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2009 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.1
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 *
 * @name class.utilidades.php
 *
 */

class Language{
    private static $instance=null;
    
    /**
     * constructor
     *
     * @access public
     * @version 0.1
     * @author Lucas M. Sastre
     *
     */
    public function __construct() {

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
    * Initiate SESSION & define output stream buffer
    *
    * @param   nothing
    * @return  nothing
    */
    public function get_session_handler(){
        ob_start();    //output stream buffer
        //session_start();  //Initialize the session data 
        //session_register("cur_language");  //Register one variables with the current session
    }

   /**
    * Returns the languages with hyperlink.
    * @param null
    */
    public function get_language_list(){

        $lang_list .="<table width=100% border=0><tr width=100%><td align=right>";
        $data       = array(1 => 'ENGLISH' , 'SPANISH' , 'FRENCH' );  //Assign Languages into $data Array from Key value 1.
        
        foreach($data as $k=>$v){
                $lang_list.="<a href=\"index.php?language=$v\" class=\"link1\">$v";
                $lang_list .="</a>";
                $lang_list .="&nbsp;<span class=\"pipeline\"> |</span> &nbsp;";
        }

               $lang_list .="</td></tr></table>";

        return $lang_list;
    }

   /**
    * Returns the language name changed based on their SESSION.
    * @param $_GET[language]
    */
    public function language_convert(){
        $config = Config::singleton();

         //Determine whether a Requested Language is set
        if(isset($_GET['leng'])){   

          //Assign Requested Language  to one variable as $lan_name;
           $lan_name = $_GET['leng'];   

          //Assign the value '$lan_name' to SESSION
           $_SESSION['leng'] = $lan_name;   

        }

        //If Requested Language is in session means goto Requested Language of PHP file  Otherwise goto english.php
        if($_SESSION['leng']) {   
            //Make a SESSION value in lowercase because our language file is in lower case(EX: english.php)
      	     $lang = strtolower($_SESSION['leng']);   
      	     
      	     //Include Requested Language of PHP file
             include($config->get('root').'lenguajes/'.$lang.".php");   
        }
        else{
          //Include Default Language of PHP file
            require_once($config->get('root').'lenguajes/es.php');
        }

        return $lang_array;
   }

}

?>

