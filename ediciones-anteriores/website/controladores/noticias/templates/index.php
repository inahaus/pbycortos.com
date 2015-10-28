<div class="row">
    <div class="col-lg-8">
        <article class="col-lg-12 noticia">
                <div class="img-img-thumbnail col-lg-2 col-offset-1">
                <?php
                    $extrae = "#\<img (.*?)\/>#";
                    if ($datos[0]['imagen'] && !$datos[0]['destacado']) {
                        $imagen = '<img src="' . $config->get('urlImagenes').$datos[0]['imagen'] . '" alt="' . $datos[0]['titulo'] . '" />';
                    } else {
                        $texto = $datos[0]['intro'].$datos[0]['texto'];
                        $imagen =  imagen($texto, $datos[0]['titulo']);
                    }
                    echo $imagen;
               ?>
               </div>
                <section  class="col-lg-9">
                    <p class="fecha"><?php echo $utilidades->cambiarFecha($datos[0]['fecha'],4); ?></p>
                    <h2><?php echo $datos[0]['titulo']; ?></h2>
                    <?php echo preg_replace($extrae, '', $datos[0]['intro']); echo $datos[0]['texto'];?>
                    <ul id="social">
                        <li>
                            <a href="https://plusone.google.com/_/+1/confirm?hl=en&amp;url=<?php echo $config->get('base').'noticias/'. $datos[0]['url_amigable'];?>.php" class="socialite googleplus-one" data-size="tall" data-href="<?php echo $config->get('base').'noticias/'. $datos[0]['url_amigable'];?>.php" rel="nofollow" target="_blank">
                                <span class="vhidden">Share on Google+</span>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.facebook.com/sharer.php?u=<?php echo $config->get('base').'noticias/'. $datos[0]['url_amigable'];?>.php&amp;t=<?php echo $seo['titulo']; ?>" class="socialite facebook-like" data-href="<?php echo $config->get('base').'noticias/'. $datos[0]['url_amigable'];?>.php" data-send="false" data-layout="box_count" data-width="60" data-show-faces="false" rel="nofollow" target="_blank">
                                <span class="vhidden">Share on Facebook</span>
                            </a>
                        </li>
                        <li class="tw">
                            <a href="http://twitter.com/share" class="socialite twitter-share" data-via="<?php echo $seo['titulo']; ?>" data-text="<?php echo $seo['titulo'] . ' - ' . str_replace('<p>', '', $utilidades->cortarTexto($datos[0]['intro_' . $_SESSION['leng']], 50)); ?>" data-url="<?php echo $config->get('base').'noticias/'.$datos[0]['url_amigable'];?>.php" data-count="vertical" rel="nofollow" target="_blank">
                                <span class="vhidden">Share on Twitter</span>
                            </a>
                        </li>
                    </ul>
                </section>
        </article>
    </div>
    <?php include_once($config->get('viewsFolder').'sidebar.php');?>
    <div class="col-lg-12"><a href="inicio.php" class="volver col-offset-6 col-push-6" title="Volver">Volver</a></div>
</div>