<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */

get_header(); ?>

<?php ?>
  <div id="grad"></div>	
	<div class="wrap">
    	<article id="construction" class="post error404 not-found hentry" role="main">
    		<header class="parent-title">
    			<h1>404 Page Not Found</h1>
    		</header>
    		<div class="entry-content">
    			<class="entry-title">We're not sure what you were looking for, but it ain't here. Feel free to peruse the links on the menu bar above, sign up for our mailing list below, or just crack open a cold one and switch back to your tab watching The Daily Show. That's what we're doing!
    			<a href="<?php bloginfo('url'); ?>" class="home-link" title="<?php bloginfo('name'); ?>"><h1>Continue to Home</h1></a>
    			<div class="clearfix"></div>
    		</div><!-- .entry-content -->
    	</article><!-- #post-## -->
    <div class="clearfix"></div>
	</div>

<div class="clearfix"></div>
<?php get_footer(); ?>