<?php if( is_front_page() ){ ?>
  
  <a class="rekindle" href="<?php bloginfo('template_directory'); ?>/home/" title="<?php bloginfo('name'); ?> | <?php bloginfo('description'); ?>"><?php bloginfo('description'); ?></a>
			  
<?php } else { ?>    

  <nav id="access" role="navigation">			
    <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
  </nav><!-- #access -->

<?php } ?>
