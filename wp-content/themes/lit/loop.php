<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */
?>

<?php
  
  query_posts(array(
    'posts_per_page' => 1,
    'tax_query' => array(
      array(
      	'taxonomy' => 'post_format',
    		'field' => 'slug',
    		'terms' => array( 'post-format-video' )
      )
    )
  ));
  
  if ( have_posts() ) :
    the_post();
    
    global $current_lit_video;
    $current_lit_video = $post->ID;
  
?>

<div class="wrap">
  <article id="newsPost" <?php post_class(); ?>>

    <?php the_content(); ?>

  </article>
</div>

<?php get_template_part('video','carousel'); ?>

<?php endif; ?>