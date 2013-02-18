<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query. 
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */

get_header(); ?>

			<?php
			/* Run the loop to output the posts.
			 * If you want to overload this in a child theme then include a file
			 * called loop-index.php and that will be used instead.
			 */
			 //get_template_part( 'loop', 'index' );
			?>

<?php /* Sidebar before rotator on owasso */ ?>


<article id="front-page-entry" <?php post_class(); ?>>

<?php //if ( have_posts() ) : while( have_posts() ) : the_post(); ?>

<?php //the_content(); ?>

<?php //endwhile; endif; ?>

<?php 
  if (is_front_page())
    echo '<a class="homeLink" href="'.home_url( '/home/' ).'" style="background: #FFFFFF;"></a>'
?>


  <div class="wrap">
		<?php 
		  if (is_front_page())
		    echo '<a class="homeLink" href="'.home_url( '/home/' ).'"></a>'
		?>



<img src="http://litmotors.com/wp-content/uploads/2012/10/SplashPage.gif" alt="Lit Motors - The Future of Personal Transportation" width="1000" height="466" >


</article>


<?php get_footer(); ?>