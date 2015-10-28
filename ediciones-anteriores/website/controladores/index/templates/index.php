<div class="row">
    <img class="img-responsive sep" src="<?php echo $config->get('viewsFolder'); ?>images/sep_noticias.jpg" alt="noticias"/>
    <?php
    $paginador->linkEstructura('inicio/pagina/{n}.php');
    $k = 1;
    while ($noticia = $paginador->fetchResultado()) {
        $extrae = "#\<img (.*?)\/>#";
        ?>
        <div class="col-6 col-sm-6 col-lg-6">
            <article class="col-lg-12"> 
                <div class="col-4 col-sm-4 col-lg-4 col-offset-1 visible-lg">
                    <?php
                    if ($noticia['imagen'] && !$noticia['destacado']) {
                        $imagen = '<img src="' . $config->get('urlImagenes') . $noticia['imagen'] . '" class="img-thumbnail" alt="' . str_replace('"',"'",$noticia['titulo']) . '" />';
                    } else {
                        $texto = $noticia['intro'] . $noticia['texto'];
                        $imagen = imagen($texto, str_replace('"',"'",$noticia['titulo']),1);
                    }
                    echo $imagen;
                    ?>
                </div>
                <div class="col-7 col-sm-7 col-lg-7 visible-lg">
                    <section class="noticia">
                        <p class="fecha"><?php echo $utilidades->cambiarFecha($noticia['fecha'], 4); ?></p>
                        <h2><?php echo $noticia['titulo']; ?></h2>
                        <?php echo preg_replace($extrae, '', $noticia['intro']); ?>
                        <?php if (!empty($noticia['texto'])) { ?>
                            <p><a href="noticias/<?php echo $noticia['url_amigable']; ?>.php" >seguir leyendo &raquo;</a></p>
                            <?php
                        }
                        ?>
                    </section>
                </div>
                <!-- visible para moviles solamente -->
                <div class="col-12 col-sm-12 col-lg-12 hidden-lg">
                    <?php
                    if ($noticia['imagen'] && !$noticia['destacado']) {
                        $imagen = '<img src="' . $config->get('urlImagenes') . $noticia['imagen'] . '" class="img-thumbnail" alt="' . str_replace('"',"'",$noticia['titulo']) . '" />';
                    } else {
                        $texto = $noticia['intro'] . $noticia['texto'];
                        $imagen = imagen($texto, str_replace('"',"'",$noticia['titulo']),1);
                    }
                    echo $imagen;
                    ?>
                </div>
                <div class="col-12 col-sm-12 col-lg-12 hidden-lg">
                    <section class="noticia">
                        <p class="fecha"><?php echo $utilidades->cambiarFecha($noticia['fecha'], 4); ?></p>
                        <h2><?php echo $noticia['titulo']; ?></h2>
                        <?php echo preg_replace($extrae, '', $noticia['intro']); ?>
                        <?php if (!empty($noticia['texto'])) { ?>
                            <p><a href="noticias/<?php echo $noticia['url_amigable']; ?>.php" >seguir leyendo &raquo;</a></p>
                            <?php
                        }
                        ?>
                    </section>
                </div>
            </article>
        </div>

    <?php
    $k++;
}
?>
    </div>
<?php echo "<div class='row'><div class='col-lg-12' id='navigation'>" . $paginador->fetchNavegacion() . "</div></div>";?>