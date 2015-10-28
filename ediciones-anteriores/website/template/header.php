<!doctype html>
<?php
include($config->get('root') . 'helpers/seo_helper.php');
include($config->get('root') . 'helpers/general_helper.php');
$seo = seo($datos);
$destacadas = destacada(8);
?>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

    <head>
        <meta charset="utf-8">

        <!-- Use the .htaccess and remove these lines to avoid edge case issues.
             More info: h5bp.com/b/378 -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <base href="<?php echo $config->get('base'); ?>"/>

        <title><?php echo $seo['titulo']; ?></title>
        <meta name="description" content="<?php echo $seo['descripcion']; ?>" />
        <meta name="keywords" content="<?php echo $seo['keywords']; ?>"/>

        <meta name="google-site-verification" content="_2Sum8g_zSa6eVp2Ofnm_gAosghDSe-7FWeoM31IfuI" />
        <meta name="language" content="<?php echo $seo['lenguaje']; ?>" />
        <meta http-equiv="Content-Language" content="<?php echo $seo['lenguaje']; ?>" />
        <meta name="revisit-after" content="7 days" />
        <meta name="robot" content="Index,Follow" />
        <meta name="robot" content="All" />
        <meta name="Distribution" content="Global" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta name="rating" content="general" />

        <meta name="author" http-equiv="Author" content="<?php echo $config->get('autor'); ?>"/>
        <meta name="copyright" content="Copyright On&iacute;rico Sistemas - www.oniricosistemas.com" />
        <meta name="generator" content="Framework Punk PHP <?php echo $config->get('version'); ?>" />

        <link rel="icon" type="image/x-icon" href="<?php echo $config->get('viewsFolder'); ?>images/favicon.ico" />
        <link rel="shortcut icon" href="<?php echo $config->get('viewsFolder'); ?>images/favicon.png" type="image/x-icon" />


        <!-- Mobile viewport optimized: j.mp/bplateviewport -->
        <meta name="viewport" content="width=device-width,initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

        <!-- CSS: implied media=all -->
        <!-- CSS concatenated and minified via ant build script-->
        <!-- <link rel="stylesheet" href="css/minified.css"> -->

        <!-- CSS imports non-minified for staging, minify before moving to production-->
        <link rel="stylesheet" href="<?php echo $config->get('viewsFolder'); ?>css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo $config->get('viewsFolder'); ?>css/bootstrap-responsive.css">
        <link rel="stylesheet" href="<?php echo $config->get('viewsFolder'); ?>css/styles.css">
        <link rel="stylesheet" href="<?php echo $config->get('viewsFolder'); ?>css/slideshow.css">
        <!-- end CSS-->

        <script src="<?php echo $config->get('viewsFolder'); ?>js/libs/modernizr-2.0.6.min.js"></script>
        <script type="text/javascript" src="<?php echo $config->get('viewsFolder'); ?>js/swfobject.js"></script>
    </head>

    <body>
        <!-- header -->
        <div class="container">
            <img class="img-responsive" src="<?php echo $config->get('viewsFolder'); ?>/images/auspiciantes-logo.jpg" alt="<?php echo $seo['titulo']; ?>"/>

            <div class="menu">
                <div class="navbar navbar-inverse color_none">
                    <div class="container color_none">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <!--<a class="navbar-brand" href="inicio.php" title="Inicio">Inicio</a>-->
                        <div class="nav-collapse collapse">
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="inicio.php" title="Inicio">Inicio</a></li>
                                <li><a href="bases.php" title="Bases">Bases</a></li>
                                <li><a href="jurado.php" title="Jurado">Jurado</a></li>
                                <li><a href="#cortos.php" title="Cortos Selecciondos">Cortos Seleccionados</a></li>
                                <li><a href="peliculas-invitadas.php" title="Pel&iacute;culas Invitadas">Pel&iacute;culas Invitadas</a></li>
                                <li><a href="#ediciones-anteriores.php" title="Ediciones Anteriores">Ediciones Anteriores</a></li>
                                <li><a href="prensa.php" title="Prensa">Prensa</a></li>
                                <li><a href="#staff.php" title="Staff">Staff</a></li>
                                <li><a href="#fotos.php" title="Staff">Fotos</a></li>
                                <li><a href="#contacto.php" title="Contacto">Contacto</a></li>
                            </ul>
                        </div><!--/.nav-collapse -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /header -->

        <!-- slider botones -->
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="cycle-slideshow" 
                         data-cycle-fx=scrollHorz
                         data-cycle-timeout=0
                         data-cycle-caption="#alt-caption"
                         data-cycle-caption-template="{{alt}}"
                        >
                        <!-- prev/next links -->
                        <div class="cycle-prev"></div>
                        <div class="cycle-next"></div>
                        <!-- empty element for pager links -->
                        <?php
                            if (!empty($destacadas)) {
                                $i = 0;
                                foreach ($destacadas as $value) {
                                    ?>
                                        <img src="<?php echo $config->get('urlImagenes') . $value['imagen']; ?>" alt="<?php echo $value['titulo']; ?>"/>
                                        
                                    <?php
                                    $i++;
                                }
                            } else {
                                ?>
                                    <img src="<?php echo $config->get('urlImagenes'); ?>slider.jpg" alt="Proximamente mas info destacada>"/>
                                <?php
                            }
                            ?>
                    </div>
                    <div id="alt-caption" class="center"></div>
                    
                </div>
                <div class="col-lg-5">
                    <p><a href="basesycondiciones2015.docx" target="_blank" title="Base y Condiciones"><img class="img-responsive" src="<?php echo $config->get('viewsFolder'); ?>images/base_doc.jpg" alt="Base y Condiciones"/></a></p>
                    <p><a href="fichadeinscripcion10.pdf" title="Ficha de Inscripci&oacute;n"><img class="img-responsive" src="<?php echo $config->get('viewsFolder'); ?>images/ficha_pdf.jpg" alt="Ficha de Inscripci&oacute;n"/></a></p>
                    <p><a href="fichadeinscripcion10.docx" title="Ficha de Inscripci&oacute;n"><img class="img-responsive" src="<?php echo $config->get('viewsFolder'); ?>images/ficha_jpg.jpg" alt="Ficha de Inscripci&oacute;n"/></a></p>
                    <p><a href="http://festival.movibeta.com/web/controllers/usuarioController.php?action=4&amp;festival=384" target="_blank" title="MoviBeta Festival"><img class="img-responsive" src="<?php echo $config->get('viewsFolder'); ?>images/movi.jpg" alt="MoviBeta Festival"/></a></p>
                </div>
            </div>
        </div>
        <!-- /slider botones -->

        <?php 
        if($url->segment(0)=='' || $url->segment(0) == 'inicio'){?>
        <!-- contenido central-->
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <section class="intro">
                        <p>Después de muchas invitaciones por parte de Adrián Culasso, el trabajo me permitió poder viajar y darme el lujo de ser jurado del Festival "Pizza,
                         Birra, cortos" en la edición 2013 junto a Ana Piterbarg, Malena Sánchez y Jessica Suárez. </p>
                        <p>Durante un fin de semana vivimos respirando cine, debatiendo cine, y hablando con estudiantes provenientes de todo el país, compartiendo 
                        experiencias, asados, y por supuesto, mucha pizza, birra y cortos.</p>  
                        <p>Sé del esfuerzo hecho por Adrián y del equipo que lo acompaña, y sé de todo lo bueno que ha logrado y está logrando el Festival, potenciando 
                        nuevos directores, motivándolos para que sigan filmando y proyectando cultura proveniente de todo el país. </p>
                        <p>Festivales hechos con tanta pasión y amor al cine son de los que no abundan, y son los que hay que cuidarlos y apuntalarlos, un proyecto que
                         arrancó como un sueño, y que hoy yá es una realidad y casi una cita obligada de todo estudiante de cine en la Argentina.  Brindo por 
                        ustedes, y por lo que vendrá.</p>
                        <p class="vanesa"><strong>Gustavo "chus" Triviño. ( Director - Op. Steadycam.).</strong><img src="<?php echo $config->get('viewsFolder'); ?>images/gustrivino.jpg" alt='Gustavo "chus" Triviños'/></p>
                    </section>
                </div>
               
                <?php include_once($config->get('viewsFolder').'sidebar.php');?>
            </div>
            
        </div>
        <!-- /contenido central -->
         <?php
        }
        ?>

        <!-- contenido -->
        <div class="container">
        

        