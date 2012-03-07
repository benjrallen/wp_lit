<?php
/**
 * Template Name: Page - Team
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */

get_header(); ?>	
<div id="grad"></div>
<?php //if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
  <div class="wrap land">
    <?php get_template_part('sidebar', 'team'); ?>
    <article id="person" <?php post_class(); ?>>
      <header>
      </header>
      <section class="entry-content">
      </section>
    </article>
    <div class="clearfix"></div>
  </div>
<?php //endwhile; // end of the loop. ?>
<?php get_footer(); ?>