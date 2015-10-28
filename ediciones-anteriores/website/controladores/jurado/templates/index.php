<div class="row">
		<div class="col-lg-8">
		    <h2 class="titjurado">Jurado</h2>

		    <?php
		    for($i=0;$i<count($jurado);$i++){
			$k=$i+1;
			?>
		    <article class="col-lg-12 jurado">
				<div class="img-img-thumbnail col-lg-2 col-offset-1">
					<img src="<?php echo $config->get('urlImagenes').$jurado[$i]['foto'];?>" alt="<?php $jurado[$i]['nombre'];?>" />
				</div>
				<section  class="col-lg-9">
					<h4><?php echo $jurado[$i]['nombre'];?></h4>
				    <?php echo $jurado[$i]['intro'];?>
				    <?php
				    if(!empty($jurado[$i]['texto'])){?>
				    <a href="#" rel="<?php echo $i;?>" class="more">seguir leyendo &raquo;</a>
				    <div class="hidden<?php echo $i;?>" style="display: none;"><?php echo $jurado[$i]['texto'];?></div>
				    <?php
				    }
				    ?>
				</section><!-- End section -->
		    </article><!-- End block -->
			<?php
			}
			?>
		</div>
		<?php include_once($config->get('viewsFolder').'sidebar.php');?>
	    <div class="col-lg-12"><a href="inicio.php" class="volver col-offset-6 col-push-6" title="Volver">Volver</a></div>
</div>