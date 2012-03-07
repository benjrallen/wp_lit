<?php
/**
 * Template Name: Page - Community Child
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */

get_header(); ?>	
	
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 

  $parent = $post->post_parent;
  $link = get_permalink($parent);

?>

<script type="text/javascript">
  window.location.href = '<?php echo $link; ?>';
</script>

<?php endwhile; endif; ?>
<div class="clearfix"</div>
<?php get_footer(); ?>