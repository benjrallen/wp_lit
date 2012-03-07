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

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
        global $current_lit_video;
        $current_lit_video = $post->ID;
?>

<div class="wrap">
  <article id="newsPost" <?php post_class(); ?>>

    <?php the_content(); ?>

  </article>
</div>

<?php endwhile; // end of the loop. ?>

<?php get_template_part('video','carousel'); ?>

<?php endif; ?>

<?php get_footer(); ?>
