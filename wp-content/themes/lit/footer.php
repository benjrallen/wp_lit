<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */
?>
		</section><!-- #main -->
						
		<footer id="footer" role="contentinfo">
  		<?php 
  		  if (is_front_page())
  		    echo '<a class="homeLink" href="'.home_url( '/home/' ).'"></a>'
  		?>
			<div class="wrap">

				<?php	
					if( !is_front_page() ){
				?>
					<span class="foot-left">
					  
					  <?php get_template_part('newsletter', 'signup'); ?>
					  
					</span>
					<span class="foot-right">
					  <div id="fbLike" class="fb">
              <div class="fb-like" data-href="http://www.facebook.com/pages/Lit-Motors-Inc/134698133268554" data-send="true" data-layout="button_count" data-width="90" data-show-faces="false"></div>
					  </div>
					  <div class="tw">
					    <a href="http://twitter.com/LitMotors" class="twitter-follow-button" data-show-count="false">@LitMotors</a>
					  </div>
					</span>
				<?php
				  } else {
				?>
			    <span class="foot-home">
			      <div class="logo"></div>
  					<?php
  						$fDate = '2011';
  						if ( date('Y') != '2011' ) $fDate = $fDate.' - '.date('Y');
  					?>
  					<span class="foot-copy">&copy; Lit Motors <?php echo $fDate; ?></span>
			    </span>
				<?php
			    }
				?>
				<div class="clearfix"></div>
			</div>
		</footer><!-- footer -->

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */
	wp_footer();
?>
	</body>
</html>