<?php
/**
* @package Punk Framework
* @copyright Copyright (C) 2009 On&iacute;rico Sistemas. Todos los derechos reservados.
* @version 0.1
* @author Lucas M. Sastre
* @link http://www.oniricosistemas.com
*
* @name Vistas.php
*/

/**
 * Modificaciones realizadas
 *
 * 28/02/2010
 * - se agrego el codigo para llamar a otras clases y asignarlas para ser usadas
 * en las vistas.
 * 
 * 17/04/2010
 * - se modifico la clase para que se use una estructura de template, donde en las vistas de cada controlador solo se carga el contenido del html a mostrar y en la carpeta
 * template en el archivo index.html se imprima el contenido de cada vista.
 * 
 */
class Vistas
{


    function __construct()
    {
    }

    public function show($name, $vars = array())
    {
        //$name es el nombre de nuestra plantilla, por ej, listado.php
        //$vars es el contenedor de nuestras variables, es un arreglo del tipo llave => valor, opcional.

        //Traemos una instancia de nuestra clase de configuracion.
        $config = Config::singleton();
        $utilidades = Utilidades::singleton();
        $debug = FirePHP::getInstance(true);
        $lenguaje = Language::singleton();
        $url = Url::singleton();

        //Armamos la ruta a la plantilla
        $path = $config->get('vista') . $name;

        //asingo algunos objetos para que puedas ser usados en el frontend
        $vars['utilidades'] = $utilidades;
        $vars['config'] = $config;
        $vars['debug'] = $debug;
	$vars['leng'] = $lenguaje;	

        //Si no existe el fichero en cuestion, tiramos un 404
        if (file_exists($path) == false)
        {
            //trigger_error ('El Template `' . $path . '` no existe.', E_USER_NOTICE);
            //return false;
            error_log("[".date("F j, Y, G:i")."] [Error: E_USER_NOTICE] [Descripcion:El Template: {$path}  no existe - \n", 3,$config->get('root').'/errores.log');
            header("Location:index.php?controlador=error404");
        }

        //Si hay variables para asignar, las pasamos una a una.
        if(is_array($vars))
        {
            foreach ($vars as $key => $value)
            {
                $$key = $value;
            }
        }
        //header('Content-Type: text/html; charset=ISO-8859-1');
        //valido si se quiere mostrar el login
        if($name!='login.html'){
            //cargo la vista a mostrar
            ob_start();
            //$contenido=file_get_contents($path);
            if(($config->get('activo')=='1' || $_REQUEST['controlador']=='inicio') && ($config->get('path')!=$config->get('root').'admin')){
                include_once($config->get('root').$config->get('viewsFolder').'header.html');
                include ($path);
                include_once($config->get('root').$config->get('viewsFolder').'footer.html');
            }
            else{
                include ($path);
            }
            $contenido = ob_get_contents();
            
            
            ob_end_clean();
            

            //Finalmente, incluimos la plantilla validando si estoy en el admin o en el frontend
            if(strpos($config->get('path'),'admin')){
                include($config->get('root').$config->get('adminViewsFolder').'index.html');
            }
            else{
                include($config->get('root').$config->get('viewsFolder').'index.html');
            }
        }
        else{
            include ($path);
        }
    }
}
/*
El uso es bastante sencillo:
$vista = new View();
$vista->show('listado.php', array("nombre" => "Juan"));
*/
?>
