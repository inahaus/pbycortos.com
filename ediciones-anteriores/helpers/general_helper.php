<?php
/**
 * imagen
 *
 * devuelve la primer imagen que haya en la noticia, si no existe muestra una por default
 */
if (!function_exists('imagen')) {

    function imagen($texto, $titulo,$tipo = 0) {
        $config = Config::singleton();
        $url = Url::singleton();
        $utilidades = Utilidades::singleton();
        $debug = firePHP::getInstance();


        // Extraemos todas las imagenes
        $extrae = '/<img .*src=["\']([^ ^"^\']*)["\']/';

        // Extraemos todas las imágenes
        preg_match_all($extrae, $texto, $matches);

        // donde
        // [1] -> segundo elemento del array "texto/imagenes"
        // [0] -> primera imagen del array de "imagenes"
        $image = $matches[1][0];
        
        if ($image) {
            $imagen = '<img src="' . $config->get('base').$image . '" class="img-thumbnail" alt="' . str_replace('"',"'",$titulo) . '" />';
        } else {
            if($tipo){
               $imagen = '
              <img class="img-thumbnail" src="' . $config->get('viewsFolder') . 'images/noticia.jpg" alt="' . str_replace('"',"'",$titulo) . '" />
              '; 
            }
            else{
              $imagen = '
              <img class="img-thumbnail" src="' . $config->get('urlImagenes') . 'noticia.jpg" alt="' . str_replace('"',"'",$titulo) . '" />
              ';  
            }
            
        }
        return $imagen;
    }

}
// ------------------------------------------------------------------------

/**
 * destacadas
 *
 * devuelve las noticias destacadas para el slider del home
 */
if (!function_exists('destacada')) {

    function destacada($edicion) {
        $config = Config::singleton();
        $url = Url::singleton();
        $utilidades = Utilidades::singleton();
        include_once ($config->get('root') . $config->get('modelsFolder') . "NoticiasModel.php");
        $noticias = New Noticias();

        $destacadas = $noticias->destacadas($edicion);
        return $destacadas;
    }

}
// ------------------------------------------------------------------------

