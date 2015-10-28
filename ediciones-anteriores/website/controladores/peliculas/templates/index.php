 <div class="row">
    <div class="col-lg-8">
         <h2 class="titpeliculas">Películas Invitadas</h2>
        <?php
        $i = 1;
        foreach ($peliculas as $peli) {
        ?>
         <article class="col-lg-12">
            <div class="img-img-thumbnail col-lg-2 col-offset-1">
                <img class="peli" src="<?php echo $config->get('urlImagenes').$peli['afiche'];?>" alt="<?php echo $peli['titulo'];?>" />
            </div>
            <section class="col-lg-8 col-offset-1 peliculas">
                <h4><?php echo $peli['titulo'];?></h4>
                <?php echo $peli['intro'];?>
                <?php
                if($peli['titulo']!=''){?>
                <a href="#" rel="<?php echo $i;?>" class="more">seguir leyendo &raquo;</a>
    	    <div class="hidden<?php echo $i;?>" style="display: none;">
                <?php echo $peli['texto'];?>
                </div>
                <?php
                }
                ?>
            </section><!-- End text -->
         </article>
        <?php
            $i++;
        }
        ?>
    </div>
<?php include_once($config->get('viewsFolder').'sidebar.php');?>
<div class="col-lg-12"><a href="inicio.php" class="volver col-offset-6 col-push-6" title="Volver">Volver</a></div>
</div>
