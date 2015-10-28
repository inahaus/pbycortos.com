        </div>
        <!-- /contenido -->
        
        <!-- footer -->
        <div class="container">
            <footer>
                
                    <div class="col-lg-12 aus">
                        <img class="img-responsive" src="<?php echo $config->get('viewsFolder'); ?>images/auspiciantes_footer.jpg" alt="Auspiciantes"/>
                    </div>
                    <div class="col-lg-12 footer">
                        <img class="img-responsive" src="<?php echo $config->get('viewsFolder'); ?>images/footer.jpg" alt=""/>
                    </div>
                
            </footer>
        </div> <!-- /footer -->

        <!-- JavaScript at the bottom for fast page loading -->
<?php include_once("website/template/analyticstracking.php") ?>
        <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.2.min.js"><\/script>')</script>
        <script type="text/javascript">
<?php
echo "var baseJs = '" . $config->get('base') . $config->get('js') . "/';";
echo "var baseUrl = '" . $config->get('base') . "';";
?>
        </script>

        <script src="<?php echo $config->get('viewsFolder'); ?>js/bootstrap.js"></script>
        <!--<script src="<?php echo $config->get('viewsFolder'); ?>js/jquery.cycle.all.js"></script>
        <script src="<?php echo $config->get('viewsFolder'); ?>js/carousel.js"></script>-->
        <script src="<?php echo $config->get('viewsFolder'); ?>js/jquery.cycle2.js"></script>
        <!--<script src="<?php echo $config->get('viewsFolder'); ?>js/jquery.cycle2.pager.js"></script>-->
        <script type="text/javascript" src="<?php echo $config->get('viewsFolder'); ?>js/socialite.min.js"></script>
        <script src="<?php echo $config->get('viewsFolder'); ?>js/plugins.js"></script>
        <script src="<?php echo $config->get('viewsFolder'); ?>js/main.js"></script>
        <script type="text/javascript" src="<?php echo $config->get('base') . $config->get('js'); ?>/punk.js"></script>
        <script type="text/javascript" src="<?php echo $config->get('viewsFolder'); ?>js/funciones.js"></script>
        <!-- end scripts-->
        <script type="text/javascript">
            $('.cycle-slideshow').cycle({
                speed: 800,
                manualSpeed: 100
            });
        </script>


        <!-- Prompt IE 6 users to install Chrome Frame. We suggest that you not support IE 6.
             chromium.org/developers/how-tos/chrome-frame-getting-started -->
        <!--[if lt IE 7 ]>
          <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
          <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
        <![endif]-->

    </body>
</html>