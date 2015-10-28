<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Pizza, Birra y Cortos 7ma Edición </title>

        <style type="text/css">
            body { margin: 0 auto; font-family: sans-serif; background: url(images/armado/bg.jpg) repeat #fef9e5; font-size: 1em; }
            a{color: #fff;text-decoration: none;}
            #container{background: #fff;margin: 0 auto;overflow: hidden;width: 980px;}
            .logos{float: left;margin:35px 0 0 35px;}
            .logo_principal{float: left;margin:60px 0 80px 0;width: 100%}
            .logo_principal img{margin: 5px auto;display: block}
            .texto{float: left;margin:60px 0 80px 0;width: 100%}
            .texto img{margin: 5px auto;display: block}
            .links{float: left; margin-bottom: 10px; width: 100%}
            .links ul{list-style: none;}
            .links ul li{display: inline;margin-right: 8px;}
            .concurso{float:left;margin:10px 0;width: 100%}
            .concurso img{margin: 5px auto;display: block}
			.auspiciantes{float:left;margin:10px 0;width: 100%}
			.auspiciantes img{margin: 5px auto;display: block}
        </style>

    </head>
    <body>
        <?php include_once("website/template/analyticstracking.php") ?>
        <div id="container">
            <div class="logos">
                <img src="<?php echo $config->get('base'); ?>images/armado/logos.png" alt=""/>
            </div>
            <div class="logo_principal">
                <img src="<?php echo $config->get('base'); ?>images/armado/logo.png" alt=""/>
            </div>
            <div class="texto">
                <img src="<?php echo $config->get('base'); ?>images/armado/texto.png" alt=""/>
            </div>
            <div class="links">
                <ul>
                    <li><a href="<?php echo $config->get('base'); ?>basesycondiciones2012.doc" title="Descagar las bases y condiciones"><img src="<?php echo $config->get('base'); ?>/images/armado/bases.png" alt="Descagar las bases y condiciones"/></a></li>
                    <li><a href="<?php echo $config->get('base'); ?>fichadeinscripcion7.pdf" title="Descagar la ficha de inscripción"><img src="<?php echo $config->get('base'); ?>/images/armado/ins_pdf.png" alt="Descagar la ficha de inscripción"/></a></li>
                    <li><a href="<?php echo $config->get('base'); ?>fichadeinscripcion7.jpg" title="Descagar la ficha de inscripción"><img src="<?php echo $config->get('base'); ?>/images/armado/ins_jpg.png" alt="Descagar la ficha de inscripción"/></a></li>
                </ul>
            </div>
			<div class="auspiciantes">
				<img src="<?php echo $config->get('base'); ?>images/armado/auspiciantes.jpg" alt=""/>
			</div>
            <div class="concurso">
                <img src="<?php echo $config->get('base'); ?>images/armado/lancamento.gif" alt=""/>
            </div>
        </div>
    </body>
</html>
