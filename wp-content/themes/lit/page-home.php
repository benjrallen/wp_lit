<?php
/**
 * Template Name: Page - Home
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */

get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	
  <?php get_template_part('front-page', 'rotator'); ?>

<?php endwhile; ?>
<?php //get_sidebar(); ?>
<div class="clearfix"></div>
		</section><!-- #main -->
		
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */
	wp_footer();
?>
	</body>
</html>