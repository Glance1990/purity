<div class="clear"></div>
</div>
<footer id="footer" role="contentinfo">
<div id="copyright">PURITY Fashion Studio<br />
&copy; 2017</div><div class="footmid">+38 066 00 44 066<br /> Киев, просп. Героев Сталинграда, 8
</div><div class="footright"><?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'menu_class' => 'bot-menu' ) ); ?>
</div>
</footer>
</div>

<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/grid12.css" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/newcss.css" />

<?php wp_footer(); ?>

<div id="buyoneclick" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <img src="<?php echo get_bloginfo('template_directory')?>/img/figm.png" alt="" />
      </div>
      <div class="modal-body">
        <?php echo do_shortcode('[contact-form-7 id="2983" title="Заказ"]'); ?>
      </div>
     
    </div>

  </div>
</div>
</body>
</html>