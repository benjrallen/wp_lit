<?php
/**
 * Template Name: Page - Community
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */

get_header(); ?>	
	
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
  
  $bgImg = '';
  
  if( has_post_thumbnail() ){														
  	$thumbID = get_post_thumbnail_id($post->ID);
  	$thumbSrc = wp_get_attachment_image_src( $thumbID, 'full' );
    $bgImg = ' style="background-image:url(\''.$thumbSrc[0].'\')"';
  }

?>
  <div id="grad"></div>	
	<div class="wrap">
  	<article id="communityPage" <?php post_class(); echo $bgImg; ?>>

      <?php echo ease_make_subpage_list( $post->ID, 1, false, 'page-thumb'); ?>
	    
	    <div class="hide">
	      <?php get_template_part('shirt', 'form'); ?>
	    </div>
	    
      <div class="clearfix"</div>
	  </article>
	</div>

<?php endwhile; endif; ?>
<div class="clearfix"</div>
<?php get_footer(); ?>