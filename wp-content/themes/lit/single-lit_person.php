<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */

get_header(); ?>
<div id="grad"></div>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
  <div class="wrap">
    <?php get_template_part('sidebar', 'team'); ?>
    <article id="person" <?php post_class(); ?>>
      <header>
        <h1><?php 
          $position = get_post_meta($post->ID, 'lit_position', true);	
          the_title();
          if ($position && $position != '')
            echo ' - '.apply_filters('the_title', $position);
        ?></h1>
      </header>
      <section class="entry-content">
        <?php the_content(); ?>
      </section>
    </article>
    <div class="clearfix"></div>
  </div>
<?php endwhile; // end of the loop. ?>
<?php get_footer(); ?>
