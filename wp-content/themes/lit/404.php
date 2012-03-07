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
    			<h3>404 Page Not Found</h3>
    		</header>
    		<div class="entry-content">
    			<h1 class="entry-title">Invalid Page</h1>
    			<a href="<?php bloginfo('url'); ?>" class="home-link" title="<?php bloginfo('name'); ?>">Continue to Home >></a>
    			<div class="clearfix"></div>
    		</div><!-- .entry-content -->
    	</article><!-- #post-## -->
    <div class="clearfix"></div>
	</div>

<div class="clearfix"></div>
<?php get_footer(); ?>